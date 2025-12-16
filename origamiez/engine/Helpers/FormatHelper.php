<?php

namespace Origamiez\Engine\Helpers;

class FormatHelper {

	public static function getFormatIcon( string $format ): string {
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
