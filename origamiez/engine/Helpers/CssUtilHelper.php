<?php

namespace Origamiez\Engine\Helpers;

class CssUtilHelper {

	public static function getWrapClasses(): string {
		if ( 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			return 'container';
		}
		return '';
	}

	public static function displayWrapClasses(): void {
		echo self::getWrapClasses();
	}

	public static function getContainerClass(): string {
		return 'origamiez-container';
	}

	public static function getFluidClass(): string {
		if ( 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			return 'origamiez-fluid';
		}
		return 'origamiez-boxer';
	}
}
