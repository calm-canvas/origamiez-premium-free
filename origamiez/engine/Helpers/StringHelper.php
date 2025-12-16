<?php

namespace Origamiez\Engine\Helpers;

class StringHelper {

	public static function uglify( string $string ): string {
		$string = preg_replace( '/\s+/', ' ', $string );
		$string = preg_replace( '/[^a-zA-Z0-9\s]/', '', $string );
		return strtolower( str_replace( ' ', '_', $string ) );
	}

	public static function slugify( string $string ): string {
		$string = preg_replace( '/[^a-zA-Z0-9-\s]/', '', $string );
		return strtolower( str_replace( ' ', '-', trim( $string ) ) );
	}

	public static function truncate( string $text, int $length = 100, string $suffix = '...' ): string {
		if ( strlen( $text ) <= $length ) {
			return $text;
		}
		return substr( $text, 0, $length ) . $suffix;
	}

	public static function capitalize( string $text ): string {
		return ucfirst( strtolower( $text ) );
	}
}
