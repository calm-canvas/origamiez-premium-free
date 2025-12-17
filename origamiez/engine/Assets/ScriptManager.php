<?php
/**
 * Manages theme scripts.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Engine\Assets;

/**
 * Class ScriptManager
 */
class ScriptManager {

	private const PREFIX      = 'origamiez_';
	private const INIT_HANDLE = 'origamiez-init';

	/**
	 * Enqueues all scripts.
	 *
	 * @param string $template_uri The template URI.
	 */
	public function enqueue( string $template_uri ): void {
		$this->enqueue_comment_reply();
		$this->enqueue_vendor_scripts( $template_uri );
		$this->enqueue_theme_scripts( $template_uri );
		$this->localize_theme_scripts();
	}

	/**
	 * Enqueues the comment reply script.
	 */
	private function enqueue_comment_reply(): void {
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueues vendor scripts.
	 *
	 * @param string $template_uri The template URI.
	 */
	private function enqueue_vendor_scripts( string $template_uri ): void {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'hoverIntent' );

		$scripts = array(
			'jquery-easing'       => 'js/jquery.easing.js',
			'jquery-fitvids'      => 'js/jquery.fitvids.js',
			'jquery-navgoco'      => 'js/jquery.navgoco.js',
			'jquery-poptrox'      => 'js/jquery.poptrox.js',
			'jquery-transit'      => 'js/jquery.transit.js',
			'jquery-owl-carousel' => 'js/owl.carousel.js',
			'jquery-superfish'    => 'js/superfish.js',
		);

		foreach ( $scripts as $handle => $path ) {
			wp_enqueue_script(
				self::PREFIX . $handle,
				trailingslashit( $template_uri ) . $path,
				array( 'jquery' ),
				defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : null,
				true
			);
		}
	}

	/**
	 * Enqueues theme scripts.
	 *
	 * @param string $template_uri The template URI.
	 */
	private function enqueue_theme_scripts( string $template_uri ): void {
		wp_enqueue_script(
			self::PREFIX . self::INIT_HANDLE,
			trailingslashit( $template_uri ) . 'js/script.js',
			array( 'jquery' ),
			defined( 'ORIGAMIEZ_VERSION' ) ? ORIGAMIEZ_VERSION : null,
			true
		);
	}

	/**
	 * Localizes theme scripts.
	 */
	private function localize_theme_scripts(): void {
		$localization_data = apply_filters(
			'get_origamiez_vars',
			array(
				'info'   => array(
					'home_url'     => esc_url( home_url() ),
					'template_uri' => get_template_directory_uri(),
					'affix'        => '',
				),
				'config' => array(
					'is_enable_lightbox'           => (int) get_theme_mod( 'is_enable_lightbox', 1 ),
					'is_enable_convert_flat_menus' => (int) get_theme_mod( 'is_enable_convert_flat_menus', 1 ),
					'is_use_gallery_popup'         => (int) get_theme_mod( 'is_use_gallery_popup', 1 ),
				),
			)
		);

		wp_localize_script(
			self::PREFIX . self::INIT_HANDLE,
			'origamiez_vars',
			$localization_data
		);
	}
}
