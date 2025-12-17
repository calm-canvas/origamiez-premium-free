<?php
/**
 * Format Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class FormatHelper
 *
 * @package Origamiez\Engine\Helpers
 */
class FormatHelper {

	/**
	 * Get format icon.
	 *
	 * @param string $format The format.
	 *
	 * @return string
	 */
	public static function get_format_icon( string $format ): string {
		$icon = 'fa fa-pencil';
		switch ( $format ) {
			case 'video':
				$icon = 'fa fa-play';
				break;
			case 'audio':
				$icon = 'fa fa-headphones';
				break;
			case 'image':
				$icon = 'fa fa-camera';
				break;
			case 'gallery':
				$icon = 'fa fa-picture-o';
				break;
		}

		return apply_filters( 'origamiez_get_format_icon', $icon, $format );
	}
}
