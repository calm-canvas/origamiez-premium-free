<?php
/**
 * Layout Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class LayoutHelper
 */
class LayoutHelper {

	/**
	 * Get wrap classes.
	 *
	 * @param bool $should_echo Whether to echo the classes.
	 * @return string
	 */
	public static function get_wrap_classes( bool $should_echo = true ): string {
		$classes = '';
		if ( 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			$classes = 'container';
		}

		if ( $should_echo ) {
			echo esc_attr( $classes );
		}

		return $classes;
	}
}
