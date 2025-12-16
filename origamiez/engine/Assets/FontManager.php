<?php
/**
 * Manages theme fonts.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Engine\Assets;

/**
 * Class FontManager
 */
class FontManager {

	private const PREFIX = 'origamiez_';
	/**
	 * The template URI.
	 *
	 * @var string
	 */
	private string $template_uri;

	/**
	 * FontManager constructor.
	 *
	 * @param string $template_uri The template URI.
	 */
	public function __construct( string $template_uri ) {
		$this->template_uri = $template_uri;
	}

	/**
	 * Enqueues all fonts.
	 */
	public function enqueue(): void {
		$this->enqueue_google_fonts();
		$this->enqueue_dynamic_fonts();
	}

	/**
	 * Enqueues Google Fonts.
	 */
	private function enqueue_google_fonts(): void {
		if ( 'off' === _x( 'on', 'Google font: on or off', 'origamiez' ) ) {
			return;
		}

		$google_fonts_url = add_query_arg(
			'family',
			urlencode( 'Inter:wght@600;700&display=swap' ),
			'//fonts.googleapis.com/css2'
		);

		wp_enqueue_style(
			self::PREFIX . 'google-fonts',
			$google_fonts_url
		);
	}

	/**
	 * Enqueues dynamic fonts from theme options.
	 */
	private function enqueue_dynamic_fonts(): void {
		$font_groups            = array();
		$number_of_google_fonts = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );

		if ( $number_of_google_fonts ) {
			for ( $i = 0; $i < $number_of_google_fonts; $i++ ) {
				$font_family = get_theme_mod( sprintf( 'google_font_%s_name', $i ), '' );
				$font_src    = get_theme_mod( sprintf( 'google_font_%s_src', $i ), '' );

				if ( $font_family && $font_src ) {
					$font_family_slug                            = $this->slugify_string( $font_family );
					$font_groups['dynamic'][ $font_family_slug ] = $font_src;
				}
			}
		}

		foreach ( $font_groups as $font_group ) {
			if ( $font_group ) {
				foreach ( $font_group as $font_slug => $font ) {
					wp_enqueue_style(
						self::PREFIX . $font_slug,
						$font,
						array(),
						null
					);
				}
			}
		}
	}

	/**
	 * Slugifies a string.
	 *
	 * @param string $str The string to slugify.
	 * @return string The slugified string.
	 */
	private function slugify_string( string $str ): string {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', $str ) );
	}
}
