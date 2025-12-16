<?php
/**
 * Css Util Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class CssUtilHelper
 */
class CssUtilHelper {

	/**
	 * Get wrap classes.
	 *
	 * @return string
	 */
	public static function get_wrap_classes(): string {
		if ( 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			return 'container';
		}
		return '';
	}

	/**
	 * Display wrap classes.
	 */
	public static function display_wrap_classes(): void {
		echo esc_attr( self::get_wrap_classes() );
	}

	/**
	 * Get container class.
	 *
	 * @return string
	 */
	public static function get_container_class(): string {
		return 'origamiez-container';
	}

	/**
	 * Get fluid class.
	 *
	 * @return string
	 */
	public static function get_fluid_class(): string {
		if ( 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			return 'origamiez-fluid';
		}
		return 'origamiez-boxer';
	}
}
