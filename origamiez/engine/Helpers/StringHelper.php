<?php
/**
 * String Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class StringHelper
 */
class StringHelper {

	/**
	 * Uglify a string.
	 *
	 * @param string $text The input string.
	 * @return string
	 */
	public static function uglify( string $text ): string {
		$text = preg_replace( '/\s+/', ' ', $text );
		$text = preg_replace( '/[^a-zA-Z0-9\s]/', '', $text );
		return strtolower( str_replace( ' ', '_', $text ) );
	}

	/**
	 * Slugify a string.
	 *
	 * @param string $text The input string.
	 * @return string
	 */
	public static function slugify( string $text ): string {
		$text = preg_replace( '/[^a-zA-Z0-9-\s]/', '', $text );
		return strtolower( str_replace( ' ', '-', trim( $text ) ) );
	}

	/**
	 * Truncate a string.
	 *
	 * @param string $text The input string.
	 * @param int    $length The desired length.
	 * @param string $suffix The suffix to add.
	 * @return string
	 */
	public static function truncate( string $text, int $length = 100, string $suffix = '...' ): string {
		if ( strlen( $text ) <= $length ) {
			return $text;
		}
		return substr( $text, 0, $length ) . $suffix;
	}

	/**
	 * Capitalize a string.
	 *
	 * @param string $text The input string.
	 * @return string
	 */
	public static function capitalize( string $text ): string {
		return ucfirst( strtolower( $text ) );
	}
}
