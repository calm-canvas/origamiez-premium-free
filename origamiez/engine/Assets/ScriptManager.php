<?php

namespace Origamiez\Engine\Assets;

class ScriptManager {

	private const PREFIX = 'origamiez_';
	private const INIT_HANDLE = 'origamiez-init';

	public function enqueue( string $templateUri ): void {
		$this->enqueueCommentReply();
		$this->enqueueVendorScripts( $templateUri );
		$this->enqueueThemeScripts( $templateUri );
		$this->localizeThemeScripts();
	}

	private function enqueueCommentReply(): void {
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	private function enqueueVendorScripts( string $templateUri ): void {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'hoverIntent' );

		$scripts = [
			'jquery-easing'      => 'js/jquery.easing.js',
			'jquery-fitvids'     => 'js/jquery.fitvids.js',
			'jquery-navgoco'     => 'js/jquery.navgoco.js',
			'jquery-poptrox'     => 'js/jquery.poptrox.js',
			'jquery-transit'     => 'js/jquery.transit.js',
			'jquery-owl-carousel' => 'js/owl.carousel.js',
			'jquery-superfish'   => 'js/superfish.js',
		];

		foreach ( $scripts as $handle => $path ) {
			wp_enqueue_script(
				self::PREFIX . $handle,
				trailingslashit( $templateUri ) . $path,
				[ 'jquery' ],
				null,
				true
			);
		}
	}

	private function enqueueThemeScripts( string $templateUri ): void {
		wp_enqueue_script(
			self::PREFIX . self::INIT_HANDLE,
			trailingslashit( $templateUri ) . 'js/script.js',
			[ 'jquery' ],
			null,
			true
		);
	}

	private function localizeThemeScripts(): void {
		$localization_data = apply_filters(
			'get_origamiez_vars',
			[
				'info'   => [
					'home_url'       => esc_url( home_url() ),
					'template_uri'   => get_template_directory_uri(),
					'affix'          => '',
				],
				'config' => [
					'is_enable_lightbox'           => (int) get_theme_mod( 'is_enable_lightbox', 1 ),
					'is_enable_convert_flat_menus' => (int) get_theme_mod( 'is_enable_convert_flat_menus', 1 ),
					'is_use_gallery_popup'        => (int) get_theme_mod( 'is_use_gallery_popup', 1 ),
				],
			]
		);

		wp_localize_script(
			self::PREFIX . self::INIT_HANDLE,
			'origamiez_vars',
			$localization_data
		);
	}
}
