<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class GeneralClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager = $configManager;
	}

	public function provide( array $classes ): array {
		$this->addBackgroundClasses( $classes );
		$this->addLayoutClasses( $classes );
		$this->addFooterClasses( $classes );
		$this->addSkinClasses( $classes );
		$this->addHeaderClasses( $classes );
		$this->addSidebarClasses( $classes );

		return $classes;
	}

	private function addBackgroundClasses( array &$classes ): void {
		$bgImage = get_background_image();
		$bgColor = get_background_color();

		if ( $bgImage || $bgColor ) {
			$classes[] = 'origamiez_custom_bg';
		} else {
			$classes[] = 'without_bg_slides';
		}
	}

	private function addLayoutClasses( array &$classes ): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			$classes[] = 'origamiez-boxer';
		} else {
			$classes[] = 'origamiez-fluid';
		}
	}

	private function addFooterClasses( array &$classes ): void {
		$hasFooter = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' )
			|| is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' )
			|| is_active_sidebar( 'footer-5' );

		if ( $hasFooter ) {
			$classes[] = 'origamiez-show-footer-area';
		}
	}

	private function addSkinClasses( array &$classes ): void {
		$skin = get_theme_mod( 'skin', 'default' );
		if ( $skin ) {
			$classes[] = sprintf( 'origamiez-skin-%s', $skin );
		}
	}

	private function addHeaderClasses( array &$classes ): void {
		$headerStyle = get_theme_mod( 'header_style', 'left-right' );
		if ( $headerStyle ) {
			$classes[] = sprintf( 'origamiez-header-style-%s', $headerStyle );
		}
	}

	private function addSidebarClasses( array &$classes ): void {
		if ( ! ( is_home() || is_archive() || is_single() ) ) {
			return;
		}

		$sidebarRight = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
		if ( ! is_active_sidebar( $sidebarRight ) ) {
			$classes[] = 'origamiez-missing-sidebar-right';
		}

		$sidebarLeft = apply_filters( 'origamiez_get_current_sidebar', 'left', 'left' );
		if ( ! is_active_sidebar( $sidebarLeft ) ) {
			$classes[] = 'origamiez-missing-sidebar-left';
		}
	}
}
