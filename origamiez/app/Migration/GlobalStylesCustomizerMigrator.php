<?php
/**
 * One-shot migration: Customizer color / typography / Google Fonts → user global styles (Theme JSON).
 *
 * Requires WordPress 5.9+ (class WP_Theme_JSON, wp_global_styles CPT). See docs/specs/13-customizer-to-site-editor-migration.md.
 *
 * @package Origamiez
 */

namespace Origamiez\Migration;

use Origamiez\Helpers\ThemeVersion;

/**
 * Class GlobalStylesCustomizerMigrator
 */
class GlobalStylesCustomizerMigrator {

	/**
	 * Stores migration outcome: success (array with theme_version, completed_at), or skip reason (string).
	 */
	public const OPTION_KEY = 'origamiez_global_styles_migration';

	public const ERROR_OPTION_KEY = 'origamiez_global_styles_migration_error';

	/**
	 * One-shot migration runs only while the Origamiez engine theme `Version` header equals this value
	 * (parent version when a child theme is active). Bump for future migration waves.
	 */
	public const MIGRATION_TARGET_VERSION = '4.4.2';

	private const TRANSIENT_LOCK = 'origamiez_global_styles_migration_lock';

	/** Default dark gray used for multiple custom-skin theme_mod fallbacks. */
	private const CUSTOM_SKIN_DEFAULT_DARK = '#111111';

	/**
	 * Whether the active Origamiez release is exactly the version that should run this migration.
	 *
	 * @return bool
	 */
	public static function is_migration_target_version(): bool {
		$target = apply_filters( 'origamiez_global_styles_migration_target_version', self::MIGRATION_TARGET_VERSION );
		$target = is_string( $target ) ? trim( $target ) : '';
		if ( '' === $target ) {
			return false;
		}

		return ThemeVersion::get_style_sheet_version() === $target;
	}

	/**
	 * Run migration if needed (idempotent via OPTION_KEY).
	 *
	 * @return void
	 */
	public function maybe_migrate(): void {
		// Option absent: get_option() returns false → run once. Any stored status (array, string) skips.
		if (
			! is_admin()
			|| ! current_user_can( 'edit_theme_options' )
			|| ! apply_filters( 'origamiez_global_styles_migration_enabled', true )
			|| ! self::is_migration_target_version()
			|| false !== get_option( self::OPTION_KEY, false )
			|| get_transient( self::TRANSIENT_LOCK )
		) {
			return;
		}
		set_transient( self::TRANSIENT_LOCK, '1', 60 );

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

		delete_transient( self::TRANSIENT_LOCK );
	}

	/**
	 * Perform migration and set status option.
	 *
	 * @return void
	 * @throws GlobalStylesMigrationException When the global styles post cannot be read, merged, or saved.
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
			throw new GlobalStylesMigrationException( 'Could not load or create wp_global_styles post.' );
		}

		$post_id = (int) $user_cpt['ID'];
		$data    = json_decode( $user_cpt['post_content'], true );
		if ( ! is_array( $data ) ) {
			throw new GlobalStylesMigrationException( 'Invalid global styles post JSON.' );
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
			$merger  = new GlobalStylesThemeJsonMerger();
			$data    = $merger->merge_fill_missing( $data, $patch );
			$encoded = wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			if ( false === $encoded ) {
				throw new GlobalStylesMigrationException( 'Could not encode global styles JSON.' );
			}

			$result = wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => wp_slash( $encoded ),
				),
				true
			);

			if ( is_wp_error( $result ) ) {
				throw new GlobalStylesMigrationException( esc_html( $result->get_error_message() ) );
			}
		}

		if ( function_exists( 'wp_clean_theme_json_cache' ) ) {
			wp_clean_theme_json_cache();
		}

		update_option(
			self::OPTION_KEY,
			array(
				'completed_at'  => time(),
				'theme_version' => ThemeVersion::get_style_sheet_version(),
				'wp_version'    => get_bloginfo( 'version' ),
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

		return ( new GlobalStylesThemeJsonMerger() )->remove_empty_branch( $patch );
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
		$this->assign_background_color_style( $styles, $color );
		$this->assign_background_image_style( $styles, $image );

		return $styles;
	}

	/**
	 * Apply validated background color to the styles fragment.
	 *
	 * @param array  $styles Output styles fragment.
	 * @param string $color  Raw background_color theme_mod.
	 */
	private function assign_background_color_style( array &$styles, string $color ): void {
		if ( '' === $color ) {
			return;
		}
		$hex = ltrim( $color, '#' );
		if ( preg_match( '/^[0-9a-fA-F]{3,8}$/', $hex ) ) {
			$styles['color']['background'] = '#' . strtolower( $hex );
		}
	}

	/**
	 * Apply background image and related properties to the styles fragment.
	 *
	 * @param array  $styles Output styles fragment.
	 * @param string $image  Raw background_image theme_mod.
	 */
	private function assign_background_image_style( array &$styles, string $image ): void {
		if ( '' === $image ) {
			return;
		}
		$url = esc_url_raw( $image );
		if ( ! $url ) {
			return;
		}
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
			'primary_color'                        => self::CUSTOM_SKIN_DEFAULT_DARK,
			'secondary_color'                      => '#f5f7fa',
			'body_color'                           => '#333333',
			'heading_color'                        => self::CUSTOM_SKIN_DEFAULT_DARK,
			'link_hover_color'                     => '#00589f',
			'main_menu_color'                      => self::CUSTOM_SKIN_DEFAULT_DARK,
			'main_menu_bg_color'                   => '#ffffff',
			'main_menu_hover_color'                => '#00589f',
			'main_menu_active_color'               => self::CUSTOM_SKIN_DEFAULT_DARK,
			'line_1_bg_color'                      => '#e8ecf1',
			'line_2_bg_color'                      => '#f0f2f5',
			'line_3_bg_color'                      => '#f8fafc',
			'footer_sidebars_bg_color'             => '#222222',
			'footer_sidebars_text_color'           => '#a0a0a0',
			'footer_sidebars_widget_heading_color' => '#ffffff',
			'footer_end_bg_color'                  => self::CUSTOM_SKIN_DEFAULT_DARK,
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
		$link_hex    = sanitize_hex_color( get_theme_mod( 'link_color', self::CUSTOM_SKIN_DEFAULT_DARK ) );
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
}
