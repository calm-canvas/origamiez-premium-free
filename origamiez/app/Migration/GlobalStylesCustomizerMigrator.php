<?php
/**
 * One-shot migration: Customizer color / typography / Google Fonts → user global styles (Theme JSON).
 *
 * Requires WordPress 5.9+ (class WP_Theme_JSON, wp_global_styles CPT). See docs/specs/13-customizer-to-site-editor-migration.md.
 *
 * @package Origamiez
 */

namespace Origamiez\Migration;

/**
 * Class GlobalStylesCustomizerMigrator
 */
class GlobalStylesCustomizerMigrator {

	public const OPTION_KEY = 'origamiez_mig_gs_v1';

	public const ERROR_OPTION_KEY = 'origamiez_mig_gs_v1_error';

	/**
	 * Run migration if needed (idempotent via OPTION_KEY).
	 *
	 * @return void
	 */
	public function maybe_migrate(): void {
		if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		if ( ! apply_filters( 'origamiez_global_styles_migration_enabled', true ) ) {
			return;
		}

		// Option absent: get_option() returns false → run once. Any stored status (array, string) skips.
		if ( false !== get_option( self::OPTION_KEY, false ) ) {
			return;
		}

		if ( get_transient( 'origamiez_mig_gs_v1_lock' ) ) {
			return;
		}
		set_transient( 'origamiez_mig_gs_v1_lock', '1', 60 );

		try {
			$this->run();
			delete_option( self::ERROR_OPTION_KEY );
		} catch ( \Throwable $e ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- debug-only failure logging
				error_log( 'Origamiez global styles migration: ' . $e->getMessage() );
			}
			update_option(
				self::ERROR_OPTION_KEY,
				sprintf(
				/* translators: %s: technical error message */
					__( 'Origamiez could not migrate styles to the Site Editor data store. %s', 'origamiez' ),
					$e->getMessage()
				),
				false
			);
		}

		delete_transient( 'origamiez_mig_gs_v1_lock' );
	}

	/**
	 * Perform migration and set status option.
	 *
	 * @return void
	 * @throws \RuntimeException When the global styles post cannot be read, merged, or saved.
	 */
	private function run(): void {
		if ( ! class_exists( '\WP_Theme_JSON' ) || ! class_exists( '\WP_Theme_JSON_Resolver' ) ) {
			update_option( self::OPTION_KEY, 'skipped-incompatible-wp', false );
			return;
		}

		if ( ! function_exists( 'wp_theme_has_theme_json' ) || ! wp_theme_has_theme_json() ) {
			update_option( self::OPTION_KEY, 'skipped-no-theme-json', false );
			return;
		}

		$user_cpt = \WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme(), true );
		if ( empty( $user_cpt['ID'] ) || empty( $user_cpt['post_content'] ) ) {
			throw new \RuntimeException( 'Could not load or create wp_global_styles post.' );
		}

		$post_id = (int) $user_cpt['ID'];
		$data    = json_decode( $user_cpt['post_content'], true );
		if ( ! is_array( $data ) ) {
			throw new \RuntimeException( 'Invalid global styles post JSON.' );
		}

		$schema_version = class_exists( '\WP_Theme_JSON' ) ? \WP_Theme_JSON::LATEST_SCHEMA : 2;
		if ( ! isset( $data['version'] ) ) {
			$data['version'] = $schema_version;
		}

		$patch = $this->build_patch();

		/**
		 * Filter the Theme JSON fragment merged into the user global styles post (fill-missing policy).
		 *
		 * @param array $patch Merged into existing user data.
		 * @param array $data  Existing decoded post content before merge.
		 */
		$patch = apply_filters( 'origamiez_global_styles_migration_patch', $patch, $data );

		if ( ! empty( $patch ) ) {
			$data    = $this->merge_fill_missing( $data, $patch );
			$encoded = wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			if ( false === $encoded ) {
				throw new \RuntimeException( 'Could not encode global styles JSON.' );
			}

			$result = wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => wp_slash( $encoded ),
				),
				true
			);

			if ( is_wp_error( $result ) ) {
				throw new \RuntimeException( esc_html( $result->get_error_message() ) );
			}
		}

		if ( function_exists( 'wp_clean_theme_json_cache' ) ) {
			wp_clean_theme_json_cache();
		}

		update_option(
			self::OPTION_KEY,
			array(
				'completed_at' => time(),
				'wp_version'   => get_bloginfo( 'version' ),
			),
			false
		);
	}

	/**
	 * Build migration fragment from theme_mods.
	 *
	 * @return array Top-level keys: settings, styles.
	 */
	private function build_patch(): array {
		$patch = array(
			'settings' => array(),
			'styles'   => array(),
		);

		$colors = $this->build_color_palette_entries();
		if ( ! empty( $colors ) ) {
			$patch['settings']['color']['palette'] = $colors;
		}

		$typo_styles         = array();
		$settings_typography = $this->append_typography_patch( $typo_styles );
		if ( ! empty( $typo_styles ) ) {
			$patch['styles'] = array_replace_recursive( $patch['styles'], $typo_styles );
		}
		if ( ! empty( $settings_typography ) ) {
			$patch['settings'] = array_replace_recursive( $patch['settings'], $settings_typography );
		}

		$font_families = $this->build_google_font_families();
		if ( ! empty( $font_families['families'] ) ) {
			if ( ! isset( $patch['settings']['typography'] ) ) {
				$patch['settings']['typography'] = array();
			}
			$patch['settings']['typography']['fontFamilies'] = $font_families['families'];
			if ( ! isset( $patch['settings']['custom']['origamiez'] ) ) {
				$patch['settings']['custom']['origamiez'] = array();
			}
			$patch['settings']['custom']['origamiez']['googleFonts'] = $font_families['meta'];
		}

		$background_styles = $this->build_background_styles_patch();
		if ( ! empty( $background_styles ) ) {
			$patch['styles'] = array_replace_recursive( $patch['styles'], $background_styles );
		}

		return $this->remove_empty_branch( $patch );
	}

	/**
	 * Map legacy Customizer / custom-background theme mods to Theme JSON styles (body / canvas).
	 *
	 * @return array<string, mixed> Partial styles tree.
	 */
	private function build_background_styles_patch(): array {
		$image = get_theme_mod( 'background_image', '' );
		$color = get_theme_mod( 'background_color', '' );
		$image = is_string( $image ) ? trim( $image ) : '';
		$color = is_string( $color ) ? trim( $color ) : '';

		if ( '' === $image && '' === $color ) {
			return array();
		}

		$styles = array();

		if ( '' !== $color ) {
			$hex = ltrim( $color, '#' );
			if ( preg_match( '/^[0-9a-fA-F]{3,8}$/', $hex ) ) {
				$styles['color']['background'] = '#' . strtolower( $hex );
			}
		}

		if ( '' !== $image ) {
			$url = esc_url_raw( $image );
			if ( $url ) {
				$attachment_id = function_exists( 'attachment_url_to_postid' )
					? (int) attachment_url_to_postid( $url )
					: 0;
				$bg            = array(
					'backgroundImage' => array(
						'url'    => $url,
						'title'  => '',
						'id'     => $attachment_id,
						'source' => 'file',
					),
				);
				$repeat        = get_theme_mod( 'background_repeat', 'repeat' );
				$attachment    = get_theme_mod( 'background_attachment', 'scroll' );
				$size          = get_theme_mod( 'background_size', 'auto' );
				$pos_x         = get_theme_mod( 'background_position_x', 'left' );
				$pos_y         = get_theme_mod( 'background_position_y', 'top' );
				if ( is_string( $repeat ) && '' !== $repeat ) {
					$bg['backgroundRepeat'] = $repeat;
				}
				if ( is_string( $attachment ) && '' !== $attachment ) {
					$bg['backgroundAttachment'] = $attachment;
				}
				if ( is_string( $size ) && '' !== $size ) {
					$bg['backgroundSize'] = $size;
				}
				if ( is_string( $pos_x ) && is_string( $pos_y ) ) {
					$bg['backgroundPosition'] = trim( $pos_x . ' ' . $pos_y );
				}
				$styles['background'] = $bg;
			}
		}

		return $styles;
	}

	/**
	 * Merge patch into existing data without overwriting existing leaf values.
	 *
	 * @param array $existing Existing Theme JSON (decoded).
	 * @param array $patch    Fragment from build_patch().
	 *
	 * @return array
	 */
	private function merge_fill_missing( array $existing, array $patch ): array {
		if ( isset( $patch['settings']['color']['palette'] ) && is_array( $patch['settings']['color']['palette'] ) ) {
			if ( ! isset( $existing['settings'] ) ) {
				$existing['settings'] = array();
			}
			$existing['settings'] = $this->merge_palette_fill_missing(
				$existing['settings'],
				$patch['settings']['color']['palette']
			);
			unset( $patch['settings']['color'] );
		}

		if ( isset( $patch['settings']['typography']['fontFamilies'] ) && is_array( $patch['settings']['typography']['fontFamilies'] ) ) {
			if ( ! isset( $existing['settings'] ) ) {
				$existing['settings'] = array();
			}
			$existing['settings'] = $this->merge_font_families_fill_missing(
				$existing['settings'],
				$patch['settings']['typography']['fontFamilies']
			);
			unset( $patch['settings']['typography']['fontFamilies'] );
			if ( empty( $patch['settings']['typography'] ) ) {
				unset( $patch['settings']['typography'] );
			}
		}

		if ( isset( $patch['settings']['custom']['origamiez']['googleFonts'] ) ) {
			if ( ! isset( $existing['settings']['custom']['origamiez'] ) ) {
				$existing['settings']['custom']['origamiez'] = array();
			}
			$incoming = $patch['settings']['custom']['origamiez']['googleFonts'];
			if ( ! isset( $existing['settings']['custom']['origamiez']['googleFonts'] ) || ! is_array( $existing['settings']['custom']['origamiez']['googleFonts'] ) ) {
				$existing['settings']['custom']['origamiez']['googleFonts'] = $incoming;
			} else {
				$existing['settings']['custom']['origamiez']['googleFonts'] = $this->merge_google_font_meta_fill_missing(
					$existing['settings']['custom']['origamiez']['googleFonts'],
					$incoming
				);
			}
			unset( $patch['settings']['custom']['origamiez']['googleFonts'] );
			$patch['settings'] = $this->remove_empty_branch( $patch['settings'] );
		}

		if ( ! empty( $patch['settings'] ) ) {
			$existing['settings'] = $this->deep_merge_settings_fill_missing(
				$existing['settings'] ?? array(),
				$patch['settings']
			);
		}

		if ( ! empty( $patch['styles'] ) ) {
			$existing['styles'] = $this->deep_merge_styles_fill_missing(
				$existing['styles'] ?? array(),
				$patch['styles']
			);
		}

		return $existing;
	}

	/**
	 * Merge color palette entries that do not already exist (by slug).
	 *
	 * @param array $settings Existing settings branch.
	 * @param array $entries  New palette entries.
	 *
	 * @return array
	 */
	private function merge_palette_fill_missing( array $settings, array $entries ): array {
		$palette = $settings['color']['palette'] ?? array();
		if ( ! is_array( $palette ) ) {
			$palette = array();
		}
		$slugs = array();
		foreach ( $palette as $row ) {
			if ( ! empty( $row['slug'] ) ) {
				$slugs[ $row['slug'] ] = true;
			}
		}
		foreach ( $entries as $row ) {
			if ( empty( $row['slug'] ) ) {
				continue;
			}
			if ( ! isset( $slugs[ $row['slug'] ] ) ) {
				$palette[]             = $row;
				$slugs[ $row['slug'] ] = true;
			}
		}
		if ( ! isset( $settings['color'] ) ) {
			$settings['color'] = array();
		}
		$settings['color']['palette'] = $palette;
		return $settings;
	}

	/**
	 * Merge font family definitions that do not already exist (by slug).
	 *
	 * @param array $settings  Existing settings branch.
	 * @param array $families  New font family definitions.
	 *
	 * @return array
	 */
	private function merge_font_families_fill_missing( array $settings, array $families ): array {
		$list = $settings['typography']['fontFamilies'] ?? array();
		if ( ! is_array( $list ) ) {
			$list = array();
		}
		$slugs = array();
		foreach ( $list as $row ) {
			if ( ! empty( $row['slug'] ) ) {
				$slugs[ $row['slug'] ] = true;
			}
		}
		foreach ( $families as $row ) {
			if ( empty( $row['slug'] ) ) {
				continue;
			}
			if ( ! isset( $slugs[ $row['slug'] ] ) ) {
				$list[]                = $row;
				$slugs[ $row['slug'] ] = true;
			}
		}
		if ( ! isset( $settings['typography'] ) ) {
			$settings['typography'] = array();
		}
		$settings['typography']['fontFamilies'] = $list;
		return $settings;
	}

	/**
	 * Merge Google Font slot metadata (slug + stylesheet URL) without clobbering src.
	 *
	 * @param array $existing Existing googleFonts meta list.
	 * @param array $incoming Incoming meta.
	 *
	 * @return array
	 */
	private function merge_google_font_meta_fill_missing( array $existing, array $incoming ): array {
		$by_slug = array();
		foreach ( $existing as $row ) {
			if ( ! empty( $row['slug'] ) ) {
				$by_slug[ $row['slug'] ] = $row;
			}
		}
		foreach ( $incoming as $row ) {
			if ( empty( $row['slug'] ) ) {
				continue;
			}
			if ( ! isset( $by_slug[ $row['slug'] ] ) ) {
				$by_slug[ $row['slug'] ] = $row;
			} elseif ( empty( $by_slug[ $row['slug'] ]['src'] ) && ! empty( $row['src'] ) ) {
				$by_slug[ $row['slug'] ]['src'] = $row['src'];
			}
		}
		return array_values( $by_slug );
	}

	/**
	 * Deep merge settings (custom.origamiez.widgetTitleTypography, etc.).
	 *
	 * @param array $base  Existing.
	 * @param array $extra Patch.
	 *
	 * @return array
	 */
	private function deep_merge_settings_fill_missing( array $base, array $extra ): array {
		foreach ( $extra as $key => $value ) {
			if ( is_array( $value ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
				$base[ $key ] = $this->deep_merge_settings_fill_missing( $base[ $key ], $value );
			} elseif ( ! isset( $base[ $key ] ) ) {
				$base[ $key ] = $value;
			}
		}
		return $base;
	}

	/**
	 * Merge styles tree; typography nodes use fill-missing per property.
	 *
	 * @param array $base  Existing styles.
	 * @param array $extra Patch.
	 *
	 * @return array
	 */
	private function deep_merge_styles_fill_missing( array $base, array $extra ): array {
		foreach ( $extra as $key => $value ) {
			if ( 'typography' === $key && is_array( $value ) && isset( $base['typography'] ) && is_array( $base['typography'] ) ) {
				foreach ( $value as $tk => $tv ) {
					if ( ! isset( $base['typography'][ $tk ] ) ) {
						$base['typography'][ $tk ] = $tv;
					}
				}
				continue;
			}
			if ( is_array( $value ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
				$base[ $key ] = $this->deep_merge_styles_fill_missing( $base[ $key ], $value );
			} elseif ( ! isset( $base[ $key ] ) ) {
				$base[ $key ] = $value;
			}
		}
		return $base;
	}

	/**
	 * Color presets when Customizer custom skin is active.
	 *
	 * @return array<int, array{name?: string, slug: string, color: string}>
	 */
	private function build_color_palette_entries(): array {
		if ( 'custom' !== get_theme_mod( 'skin', 'default' ) ) {
			return array();
		}

		$defaults = array(
			'primary_color'                        => '#111111',
			'secondary_color'                      => '#f5f7fa',
			'body_color'                           => '#333333',
			'heading_color'                        => '#111111',
			'link_hover_color'                     => '#00589f',
			'main_menu_color'                      => '#111111',
			'main_menu_bg_color'                   => '#ffffff',
			'main_menu_hover_color'                => '#00589f',
			'main_menu_active_color'               => '#111111',
			'line_1_bg_color'                      => '#e8ecf1',
			'line_2_bg_color'                      => '#f0f2f5',
			'line_3_bg_color'                      => '#f8fafc',
			'footer_sidebars_bg_color'             => '#222222',
			'footer_sidebars_text_color'           => '#a0a0a0',
			'footer_sidebars_widget_heading_color' => '#ffffff',
			'footer_end_bg_color'                  => '#111111',
			'footer_end_text_color'                => '#a0a0a0',
			'black_light_color'                    => '#f8fafc',
			'metadata_color'                       => '#666666',
			'color_success'                        => '#27ae60',
		);

		$map = array(
			'primary'                        => 'primary_color',
			'secondary'                      => 'secondary_color',
			'body'                           => 'body_color',
			'heading'                        => 'heading_color',
			'link-hover'                     => 'link_hover_color',
			'main-menu-text'                 => 'main_menu_color',
			'main-menu-bg'                   => 'main_menu_bg_color',
			'main-menu-hover'                => 'main_menu_hover_color',
			'main-menu-active'               => 'main_menu_active_color',
			'line-1-bg'                      => 'line_1_bg_color',
			'line-2-bg'                      => 'line_2_bg_color',
			'line-3-bg'                      => 'line_3_bg_color',
			'footer-sidebars-bg'             => 'footer_sidebars_bg_color',
			'footer-sidebars-text'           => 'footer_sidebars_text_color',
			'footer-sidebars-widget-heading' => 'footer_sidebars_widget_heading_color',
			'footer-end-bg'                  => 'footer_end_bg_color',
			'footer-end-text'                => 'footer_end_text_color',
			'black-light'                    => 'black_light_color',
			'metadata'                       => 'metadata_color',
			'success'                        => 'color_success',
		);

		$names = array(
			'primary'                        => __( 'Primary', 'origamiez' ),
			'secondary'                      => __( 'Secondary', 'origamiez' ),
			'body'                           => __( 'Body', 'origamiez' ),
			'heading'                        => __( 'Heading', 'origamiez' ),
			'link'                           => __( 'Link', 'origamiez' ),
			'link-hover'                     => __( 'Link Hover', 'origamiez' ),
			'main-menu-text'                 => __( 'Main Menu Text', 'origamiez' ),
			'main-menu-bg'                   => __( 'Main Menu Background', 'origamiez' ),
			'main-menu-hover'                => __( 'Main Menu Hover', 'origamiez' ),
			'main-menu-active'               => __( 'Main Menu Active', 'origamiez' ),
			'line-1-bg'                      => __( 'Line 1 Background', 'origamiez' ),
			'line-2-bg'                      => __( 'Line 2 Background', 'origamiez' ),
			'line-3-bg'                      => __( 'Line 3 Background', 'origamiez' ),
			'footer-sidebars-bg'             => __( 'Footer Sidebars Background', 'origamiez' ),
			'footer-sidebars-text'           => __( 'Footer Sidebars Text', 'origamiez' ),
			'footer-sidebars-widget-heading' => __( 'Footer Sidebars Widget Heading', 'origamiez' ),
			'footer-end-bg'                  => __( 'Footer End Background', 'origamiez' ),
			'footer-end-text'                => __( 'Footer End Text', 'origamiez' ),
			'black-light'                    => __( 'Black Light', 'origamiez' ),
			'metadata'                       => __( 'Metadata', 'origamiez' ),
			'success'                        => __( 'Success', 'origamiez' ),
		);

		$out = array();
		foreach ( $map as $slug => $mod_key ) {
			$def = $defaults[ $mod_key ] ?? '';
			$hex = get_theme_mod( $mod_key, $def );
			if ( ! is_string( $hex ) || '' === $hex ) {
				continue;
			}
			$hex = sanitize_hex_color( $hex );
			if ( ! $hex ) {
				continue;
			}
			$out[] = array(
				'name'  => $names[ $slug ] ?? $slug,
				'slug'  => $slug,
				'color' => $hex,
			);
		}

		$primary_hex = sanitize_hex_color( get_theme_mod( 'primary_color', $defaults['primary_color'] ) );
		$link_hex    = sanitize_hex_color( get_theme_mod( 'link_color', '#111111' ) );
		if ( $link_hex && $primary_hex && strtolower( $link_hex ) !== strtolower( $primary_hex ) ) {
			$out[] = array(
				'name'  => $names['link'],
				'slug'  => 'link',
				'color' => $link_hex,
			);
		}

		return $out;
	}

	/**
	 * Typography from Customizer → styles.elements / styles.blocks; widget title → settings.custom.origamiez.
	 *
	 * @param array $typo_styles Output tree under top-level "styles" shape.
	 *
	 * @return array Settings fragment (may include custom.origamiez.widgetTitleTypography).
	 */
	private function append_typography_patch( array &$typo_styles ): array {
		$settings_out = array();

		$targets = array(
			'font_body'          => array( 'elements', 'body' ),
			'font_h1'            => array( 'elements', 'h1' ),
			'font_h2'            => array( 'elements', 'h2' ),
			'font_h3'            => array( 'elements', 'h3' ),
			'font_h4'            => array( 'elements', 'h4' ),
			'font_h5'            => array( 'elements', 'h5' ),
			'font_h6'            => array( 'elements', 'h6' ),
			'font_menu'          => array( 'blocks', 'core/navigation' ),
			'font_site_title'    => array( 'blocks', 'core/site-title' ),
			'font_site_subtitle' => array( 'blocks', 'core/site-tagline' ),
		);

		foreach ( $targets as $prefix => $path ) {
			if ( ! (int) get_theme_mod( "{$prefix}_is_enable", 0 ) ) {
				continue;
			}
			$typography = $this->build_typography_from_mods( $prefix );
			if ( empty( $typography ) ) {
				continue;
			}
			$this->set_nested_typography( $typo_styles, $path, $typography );
		}

		if ( (int) get_theme_mod( 'font_widget_title_is_enable', 0 ) ) {
			$typography = $this->build_typography_from_mods( 'font_widget_title' );
			if ( ! empty( $typography ) ) {
				$settings_out['custom']['origamiez']['widgetTitleTypography'] = $typography;
			}
		}

		return $settings_out;
	}

	/**
	 * Write typography into a nested path (elements.* or blocks.*).
	 *
	 * @param array $styles     Styles branch (modified by reference root).
	 * @param array $path       e.g. array( 'elements', 'body' ).
	 * @param array $typography Theme JSON typography object.
	 *
	 * @return void
	 */
	private function set_nested_typography( array &$styles, array $path, array $typography ): void {
		$ref = &$styles;
		foreach ( $path as $segment ) {
			if ( ! isset( $ref[ $segment ] ) ) {
				$ref[ $segment ] = array();
			}
			$ref = &$ref[ $segment ];
		}
		if ( ! isset( $ref['typography'] ) ) {
			$ref['typography'] = $typography;
			return;
		}
		foreach ( $typography as $k => $v ) {
			if ( ! isset( $ref['typography'][ $k ] ) ) {
				$ref['typography'][ $k ] = $v;
			}
		}
	}

	/**
	 * Build a Theme JSON typography object from Customizer theme_mod keys.
	 *
	 * @param string $prefix Font object slug (theme_mod prefix).
	 *
	 * @return array<string, string>
	 */
	private function build_typography_from_mods( string $prefix ): array {
		$map = array(
			'family'      => 'fontFamily',
			'size'        => 'fontSize',
			'style'       => 'fontStyle',
			'weight'      => 'fontWeight',
			'line_height' => 'lineHeight',
		);
		$out = array();
		foreach ( $map as $suffix => $json_key ) {
			$val = get_theme_mod( "{$prefix}_{$suffix}" );
			if ( is_string( $val ) && '' !== $val ) {
				$out[ $json_key ] = $val;
			}
		}
		return $out;
	}

	/**
	 * Google Fonts slots → fontFamilies + custom.origamiez.googleFonts[].src for enqueue (Phase 4+).
	 *
	 * @return array{families: array<int, array>, meta: array<int, array{slug: string, src: string}>}|array{}
	 */
	private function build_google_font_families(): array {
		$count    = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );
		$families = array();
		$meta     = array();
		for ( $i = 0; $i < $count; $i++ ) {
			$name = get_theme_mod( "google_font_{$i}_name" );
			$src  = get_theme_mod( "google_font_{$i}_src" );
			if ( ! is_string( $name ) || '' === trim( $name ) ) {
				continue;
			}
			if ( ! is_string( $src ) || '' === trim( $src ) ) {
				continue;
			}
			$slug  = 'origamiez-google-' . $i;
			$stack = $name;
			if ( false === strpos( $name, ',' ) ) {
				$stack = $name . ', sans-serif';
			}
			$families[] = array(
				'fontFamily' => $stack,
				'name'       => $name,
				'slug'       => $slug,
			);
			$meta[]     = array(
				'slug' => $slug,
				'src'  => esc_url_raw( $src ),
			);
		}
		if ( empty( $families ) ) {
			return array();
		}
		return array(
			'families' => $families,
			'meta'     => $meta,
		);
	}

	/**
	 * Remove empty nested arrays from a tree.
	 *
	 * @param array $tree Data.
	 *
	 * @return array
	 */
	private function remove_empty_branch( array $tree ): array {
		foreach ( $tree as $k => $v ) {
			if ( is_array( $v ) ) {
				$tree[ $k ] = $this->remove_empty_branch( $v );
				if ( array() === $tree[ $k ] ) {
					unset( $tree[ $k ] );
				}
			}
		}
		return $tree;
	}
}
