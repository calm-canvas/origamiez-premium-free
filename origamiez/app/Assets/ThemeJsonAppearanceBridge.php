<?php
/**
 * Resolves appearance data from merged Theme JSON after Customizer → global styles migration.
 *
 * Full merged resolution uses WP_Theme_JSON_Resolver::get_merged_data() (WordPress 6.2+).
 * When migration completed, colors come from global styles CSS; this class skips legacy
 * theme_mod color overrides and supplies typography + Google Font URLs where possible.
 *
 * @package Origamiez
 */

namespace Origamiez\Assets;

use Origamiez\Migration\GlobalStylesCustomizerMigrator;

/**
 * Class ThemeJsonAppearanceBridge
 */
class ThemeJsonAppearanceBridge {

	/**
	 * Cached merged Theme JSON raw array.
	 *
	 * @var array<string, mixed>|null
	 */
	private ?array $merged_raw = null;

	/**
	 * Whether merged_raw has been resolved this request.
	 *
	 * @var bool
	 */
	private bool $merged_resolved = false;

	/**
	 * Whether the one-shot migration completed successfully (stored meta array).
	 *
	 * @return bool
	 */
	public function is_active(): bool {
		$flag = get_option( GlobalStylesCustomizerMigrator::OPTION_KEY, false );

		return (bool) apply_filters(
			'origamiez_theme_json_appearance_bridge_active',
			is_array( $flag ) && isset( $flag['completed_at'] )
		);
	}

	/**
	 * Merged theme + user Theme JSON as array (WP 6.2+), or null.
	 *
	 * @return array<string, mixed>|null
	 */
	public function get_merged_raw_data(): ?array {
		if ( $this->merged_resolved ) {
			return $this->merged_raw;
		}
		$this->merged_resolved = true;
		$this->merged_raw      = null;

		if ( ! $this->is_active() ) {
			return null;
		}

		$merged = $this->resolve_merged_theme_json();
		if ( $merged ) {
			$this->merged_raw = $merged->get_raw_data();
		}

		return $this->merged_raw;
	}

	/**
	 * Dynamic Google Font stylesheets: user JSON first, then theme_mod slots.
	 *
	 * @return array<string, string> Handle suffix => URL.
	 */
	public function get_dynamic_google_fonts_for_enqueue(): array {
		if ( $this->is_active() ) {
			$from_json = $this->get_google_fonts_from_merged();
			if ( ! empty( $from_json ) ) {
				return $from_json;
			}
		}

		return $this->get_dynamic_google_fonts_from_theme_mods();
	}

	/**
	 * Body background flags from merged Theme JSON (for layout classes when custom-background support is off).
	 *
	 * @return array{image_url: string, color: string} Non-empty strings when a literal image URL or hex color is set.
	 */
	public function get_merged_body_background_flags(): array {
		$out = array(
			'image_url' => '',
			'color'     => '',
		);
		$raw = $this->get_merged_raw_data();
		if ( ! $raw || empty( $raw['styles'] ) || ! is_array( $raw['styles'] ) ) {
			return $out;
		}
		$styles = $raw['styles'];
		$url    = '';
		if ( ! empty( $styles['background']['backgroundImage']['url'] ) && is_string( $styles['background']['backgroundImage']['url'] ) ) {
			$url = trim( $styles['background']['backgroundImage']['url'] );
		} elseif ( ! empty( $styles['elements']['body']['background']['backgroundImage']['url'] ) && is_string( $styles['elements']['body']['background']['backgroundImage']['url'] ) ) {
			$url = trim( $styles['elements']['body']['background']['backgroundImage']['url'] );
		}
		if ( '' !== $url ) {
			$out['image_url'] = $url;
		}
		foreach ( array( $styles['color']['background'] ?? null, $styles['elements']['body']['color']['background'] ?? null ) as $candidate ) {
			if ( ! is_string( $candidate ) || '' === trim( $candidate ) ) {
				continue;
			}
			$c = trim( $candidate );
			if ( preg_match( '/^#([0-9a-f]{3}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $c ) ) {
				$out['color'] = $c;
				break;
			}
		}
		return $out;
	}

	/**
	 * Load merged theme + user Theme JSON (WP 6.2+).
	 *
	 * @return \WP_Theme_JSON|null
	 */
	private function resolve_merged_theme_json(): ?\WP_Theme_JSON {
		if ( ! class_exists( '\WP_Theme_JSON_Resolver' ) || ! class_exists( '\WP_Theme_JSON' ) ) {
			return null;
		}

		if ( method_exists( '\WP_Theme_JSON_Resolver', 'get_merged_data' ) ) {
			return \WP_Theme_JSON_Resolver::get_merged_data();
		}

		return null;
	}

	/**
	 * Google Font stylesheet URLs from merged settings.custom.origamiez.googleFonts.
	 *
	 * @return array<string, string>
	 */
	private function get_google_fonts_from_merged(): array {
		$raw = $this->get_merged_raw_data();
		if ( ! $raw ) {
			return array();
		}
		$gf = $raw['settings']['custom']['origamiez']['googleFonts'] ?? array();
		if ( ! is_array( $gf ) ) {
			return array();
		}
		$out = array();
		foreach ( $gf as $row ) {
			if ( empty( $row['slug'] ) || empty( $row['src'] ) || ! is_string( $row['src'] ) ) {
				continue;
			}
			$handle = sanitize_key( str_replace( 'origamiez-google-', 'gs-gf-', (string) $row['slug'] ) );
			$url    = esc_url_raw( $row['src'] );
			if ( $handle && $url ) {
				$out[ $handle ] = $url;
			}
		}

		return $out;
	}

	/**
	 * Legacy Google Font URLs from theme_mod slots.
	 *
	 * @return array<string, string>
	 */
	private function get_dynamic_google_fonts_from_theme_mods(): array {
		$out                    = array();
		$number_of_google_fonts = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );
		for ( $i = 0; $i < $number_of_google_fonts; $i++ ) {
			$font_family = get_theme_mod( sprintf( 'google_font_%s_name', $i ), '' );
			$font_src    = get_theme_mod( sprintf( 'google_font_%s_src', $i ), '' );
			if ( $font_family && $font_src ) {
				$slug         = strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', (string) $font_family ) );
				$out[ $slug ] = (string) $font_src;
			}
		}

		return $out;
	}
}
