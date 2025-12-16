<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class GeneralClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;
	private BodyClassConfig $bodyClassConfig;

	public function __construct( ConfigManager $configManager, BodyClassConfig $bodyClassConfig ) {
		$this->configManager = $configManager;
		$this->bodyClassConfig = $bodyClassConfig;
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
			$classes[] = $this->bodyClassConfig::CUSTOM_BG;
		} else {
			$classes[] = $this->bodyClassConfig::WITHOUT_BG_SLIDES;
		}
	}

	private function addLayoutClasses( array &$classes ): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			$classes[] = $this->bodyClassConfig::LAYOUT_BOXER;
		} else {
			$classes[] = $this->bodyClassConfig::LAYOUT_FLUID;
		}
	}

	private function addFooterClasses( array &$classes ): void {
		$hasFooter = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' )
			|| is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' )
			|| is_active_sidebar( 'footer-5' );

		if ( $hasFooter ) {
			$classes[] = $this->bodyClassConfig::SHOW_FOOTER_AREA;
		}
	}

	private function addSkinClasses( array &$classes ): void {
		$skin = get_theme_mod( 'skin', 'default' );
		if ( $skin ) {
			$classes[] = $this->bodyClassConfig::SKIN_PREFIX . $skin;
		}
	}

	private function addHeaderClasses( array &$classes ): void {
		$headerStyle = get_theme_mod( 'header_style', 'left-right' );
		if ( $headerStyle ) {
			$classes[] = $this->bodyClassConfig::HEADER_STYLE_PREFIX . $headerStyle;
		}
	}

	private function addSidebarClasses( array &$classes ): void {
		if ( ! ( is_home() || is_archive() || is_single() ) ) {
			return;
		}

		$sidebarRight = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
		if ( ! is_active_sidebar( $sidebarRight ) ) {
			$classes[] = $this->bodyClassConfig::MISSING_SIDEBAR_RIGHT;
		}

		$sidebarLeft = apply_filters( 'origamiez_get_current_sidebar', 'left', 'left' );
		if ( ! is_active_sidebar( $sidebarLeft ) ) {
			$classes[] = $this->bodyClassConfig::MISSING_SIDEBAR_LEFT;
		}
	}
}
