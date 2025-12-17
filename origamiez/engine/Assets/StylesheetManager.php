<?php
/**
 * Manages theme stylesheets.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Engine\Assets;

/**
 * Class StylesheetManager
 */
class StylesheetManager {

	private const PREFIX = 'origamiez_';
	/**
	 * The handle for the main stylesheet.
	 *
	 * @var string
	 */
	private string $style_handle = '';

	/**
	 * Enqueues all stylesheets.
	 *
	 * @param string $template_uri The template URI.
	 */
	public function enqueue( string $template_uri ): void {
		$this->enqueue_library_styles( $template_uri );
		$this->enqueue_theme_style();
		$this->enqueue_google_fonts();
		$this->enqueue_dynamic_fonts();
	}

	/**
	 * Enqueues library stylesheets.
	 *
	 * @param string $template_uri The template URI.
	 */
	private function enqueue_library_styles( string $template_uri ): void {
		$styles = array(
			'bootstrap'           => 'css/bootstrap.css',
			'font-awesome'        => 'css/fontawesome.css',
			'jquery-owl-carousel' => 'css/owl.carousel.css',
			'jquery-owl-theme'    => 'css/owl.theme.default.css',
			'jquery-superfish'    => 'css/superfish.css',
			'jquery-navgoco'      => 'css/jquery.navgoco.css',
			'jquery-poptrox'      => 'css/jquery.poptrox.css',
		);

		foreach ( $styles as $handle => $path ) {
			wp_enqueue_style(
				self::PREFIX . $handle,
				trailingslashit( $template_uri ) . $path,
				array(),
				defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : null
			);
		}
	}

	/**
	 * Enqueues the main theme stylesheet.
	 */
	private function enqueue_theme_style(): void {
		$this->style_handle = self::PREFIX . 'style';
		wp_enqueue_style(
			$this->style_handle,
			get_stylesheet_uri(),
			array(),
			defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : null
		);
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
			rawurlencode( 'Inter:wght@600;700&display=swap' ),
			'//fonts.googleapis.com/css2'
		);

		wp_enqueue_style(
			self::PREFIX . 'google-fonts',
			$google_fonts_url,
			array(),
			null
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
					$font_family_slug                            = $this->slugify( $font_family );
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
	 * Adds inline CSS.
	 *
	 * @param string $css The CSS to add.
	 */
	public function add_inline_style( string $css ): void {
		if ( empty( $this->style_handle ) ) {
			$this->style_handle = self::PREFIX . 'style';
		}
		wp_add_inline_style( $this->style_handle, $css );
	}

	/**
	 * Slugifies a string.
	 *
	 * @param string $str The string to slugify.
	 * @return string The slugified string.
	 */
	private function slugify( string $str ): string {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', $str ) );
	}
}
