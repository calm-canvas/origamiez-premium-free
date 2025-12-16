<?php

namespace Origamiez\Engine\Helpers;

class MetadataHelper {

	public static function getMetadataPrefix( bool $echo = true ): string {
		$prefix = apply_filters( 'origamiez_get_metadata_prefix', '&horbar;' );
		if ( $echo ) {
			echo $prefix;
		}
		return $prefix;
	}

	public static function displayMetadataPrefix(): void {
		echo self::getMetadataPrefix( false );
	}
}
