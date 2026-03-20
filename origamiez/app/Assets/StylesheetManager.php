<?php
/**
 * Manages theme stylesheets.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Assets;

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
	 * Merged Theme JSON / theme_mod resolver for Google Fonts.
	 *
	 * @var ThemeJsonAppearanceBridge
	 */
	private ThemeJsonAppearanceBridge $appearance_bridge;

	/**
	 * StylesheetManager constructor.
	 *
	 * @param ThemeJsonAppearanceBridge|null $appearance_bridge Optional bridge.
	 */
	public function __construct( ?ThemeJsonAppearanceBridge $appearance_bridge = null ) {
		$this->appearance_bridge = $appearance_bridge ?? new ThemeJsonAppearanceBridge();
	}

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
				defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : '4.3.1'
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
			defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : '4.3.1'
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
			defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : '4.3.1'
		);
	}

	/**
	 * Enqueues dynamic fonts from theme options.
	 */
	private function enqueue_dynamic_fonts(): void {
		$dynamic = $this->appearance_bridge->get_dynamic_google_fonts_for_enqueue();

		foreach ( $dynamic as $font_slug => $font_url ) {
			if ( ! is_string( $font_slug ) || ! is_string( $font_url ) || '' === $font_url ) {
				continue;
			}
			wp_enqueue_style(
				self::PREFIX . $font_slug,
				$font_url,
				array(),
				defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : '4.3.1'
			);
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
}
