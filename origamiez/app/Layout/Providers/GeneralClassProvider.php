<?php
/**
 * General Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Layout\Providers;

use Origamiez\Assets\ThemeJsonAppearanceBridge;

/**
 * Class GeneralClassProvider
 *
 * Provides general body classes applied to all pages.
 * Extends AbstractBodyClassProvider to eliminate duplicate constructor code.
 *
 * @package Origamiez\Layout\Providers
 */
class GeneralClassProvider extends AbstractBodyClassProvider {

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array {
		$this->add_background_classes( $classes );
		$this->add_layout_classes( $classes );
		$this->add_footer_classes( $classes );
		$this->add_skin_classes( $classes );
		$this->add_header_classes( $classes );
		$this->add_sidebar_classes( $classes );

		return $classes;
	}

	/**
	 * Add background classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return void
	 */
	private function add_background_classes( array &$classes ): void {
		$bridge = new ThemeJsonAppearanceBridge();
		if ( $bridge->is_active() ) {
			$bg_image = (string) get_theme_mod( 'background_image', '' );
			$bg_color = (string) get_theme_mod( 'background_color', '' );
			if ( '' === $bg_image && '' === $bg_color ) {
				$flags    = $bridge->get_merged_body_background_flags();
				$bg_image = $flags['image_url'];
				$bg_color = $flags['color'];
			}
		} else {
			$bg_image = get_background_image();
			$bg_color = get_background_color();
		}

		if ( $bg_image || $bg_color ) {
			$classes[] = $this->body_class_config::CUSTOM_BG;
		} else {
			$classes[] = $this->body_class_config::WITHOUT_BG_SLIDES;
		}
	}

	/**
	 * Add layout classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return void
	 */
	private function add_layout_classes( array &$classes ): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			$classes[] = $this->body_class_config::LAYOUT_BOXER;
		} else {
			$classes[] = $this->body_class_config::LAYOUT_FLUID;
		}
	}

	/**
	 * Add footer classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return void
	 */
	private function add_footer_classes( array &$classes ): void {
		$has_footer = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' )
			|| is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' )
			|| is_active_sidebar( 'footer-5' );

		if ( $has_footer ) {
			$classes[] = $this->body_class_config::SHOW_FOOTER_AREA;
		}
	}

	/**
	 * Add skin classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return void
	 */
	private function add_skin_classes( array &$classes ): void {
		$bridge = new ThemeJsonAppearanceBridge();
		if ( $bridge->is_active() ) {
			$classes[] = $this->body_class_config::GLOBAL_STYLES_BRIDGE;
		}

		$skin = get_theme_mod( 'skin', 'default' );
		if ( $skin ) {
			$classes[] = $this->body_class_config::SKIN_PREFIX . $skin;
		}
	}

	/**
	 * Add header classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return void
	 */
	private function add_header_classes( array &$classes ): void {
		$header_style = get_theme_mod( 'header_style', 'left-right' );
		if ( $header_style ) {
			$classes[] = $this->body_class_config::HEADER_STYLE_PREFIX . $header_style;
		}
	}

	/**
	 * Add sidebar classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return void
	 */
	private function add_sidebar_classes( array &$classes ): void {
		if ( ! ( is_home() || is_archive() || is_single() ) ) {
			return;
		}

		$sidebar_right = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
		if ( ! is_active_sidebar( $sidebar_right ) ) {
			$classes[] = $this->body_class_config::MISSING_SIDEBAR_RIGHT;
		}

		$sidebar_left = apply_filters( 'origamiez_get_current_sidebar', 'left', 'left' );
		if ( ! is_active_sidebar( $sidebar_left ) ) {
			$classes[] = $this->body_class_config::MISSING_SIDEBAR_LEFT;
		}
	}
}
