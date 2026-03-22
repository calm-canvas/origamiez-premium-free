<?php
/**
 * String Utils
 *
 * @package Origamiez
 */

namespace Origamiez\Utils;

/**
 * Class StringUtils
 *
 * @package Origamiez\Utils
 */
class StringUtils {

	/**
	 * Slugify.
	 *
	 * @param string $str The string.
	 *
	 * @return string
	 */
	public static function slugify( string $str ): string {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', $str ) );
	}

	/**
	 * Truncate.
	 *
	 * @param string  $str The string.
	 * @param integer $length The length.
	 * @param string  $suffix The suffix.
	 *
	 * @return string
	 */
	public static function truncate( string $str, int $length = 100, string $suffix = '...' ): string {
		if ( strlen( $str ) <= $length ) {
			return $str;
		}
		return substr( $str, 0, $length ) . $suffix;
	}

	/**
	 * Human time diff.
	 *
	 * @param integer $from The from.
	 * @param integer $to The to.
	 *
	 * @return string
	 */
	public static function human_time_diff( $from = 0, $to = 0 ): string {
		$from = (int) $from;
		$to   = (int) $to;

		$abs_diff = abs( $to - $from );

		$result = '';
		if ( $abs_diff < 1 ) {
			$result = __( 'just now', 'origamiez' );
		} elseif ( $abs_diff < 60 ) {
			// translators: %s is the number of seconds.
			$result = sprintf( _n( '%s second', '%s seconds', $abs_diff, 'origamiez' ), $abs_diff );
		} elseif ( $abs_diff < 3600 ) {
			$minutes = round( $abs_diff / 60 );
			// translators: %s is the number of minutes.
			$result = sprintf( _n( '%s minute', '%s minutes', $minutes, 'origamiez' ), $minutes );
		} elseif ( $abs_diff < 86400 ) {
			$hours = round( $abs_diff / 3600 );
			// translators: %s is the number of hours.
			$result = sprintf( _n( '%s hour', '%s hours', $hours, 'origamiez' ), $hours );
		} elseif ( $abs_diff < 604800 ) {
			$days = round( $abs_diff / 86400 );
			// translators: %s is the number of days.
			$result = sprintf( _n( '%s day', '%s days', $days, 'origamiez' ), $days );
		} elseif ( $abs_diff < 2592000 ) {
			$weeks = round( $abs_diff / 604800 );
			// translators: %s is the number of weeks.
			$result = sprintf( _n( '%s week', '%s weeks', $weeks, 'origamiez' ), $weeks );
		} elseif ( $abs_diff < 31536000 ) {
			$months = round( $abs_diff / 2592000 );
			// translators: %s is the number of months.
			$result = sprintf( _n( '%s month', '%s months', $months, 'origamiez' ), $months );
		} else {
			$years = round( $abs_diff / 31536000 );
			// translators: %s is the number of years.
			$result = sprintf( _n( '%s year', '%s years', $years, 'origamiez' ), $years );
		}

		return $result;
	}

	/**
	 * Sanitize input.
	 *
	 * @param string $input The input.
	 *
	 * @return string
	 */
	public static function sanitize_input( string $input ): string {
		return sanitize_text_field( $input );
	}

	/**
	 * Escape html.
	 *
	 * @param string $text The text.
	 *
	 * @return string
	 */
	public static function escape_html( string $text ): string {
		return esc_html( $text );
	}

	/**
	 * Escape url.
	 *
	 * @param string $url The url.
	 *
	 * @return string
	 */
	public static function escape_url( string $url ): string {
		return esc_url( $url );
	}

	/**
	 * Starts with.
	 *
	 * @param string $haystack The haystack.
	 * @param string $needle The needle.
	 *
	 * @return boolean
	 */
	public static function starts_with( string $haystack, string $needle ): bool {
		return strpos( $haystack, $needle ) === 0;
	}

	/**
	 * Ends with.
	 *
	 * @param string $haystack The haystack.
	 * @param string $needle The needle.
	 *
	 * @return boolean
	 */
	public static function ends_with( string $haystack, string $needle ): bool {
		return substr( $haystack, -strlen( $needle ) ) === $needle;
	}

	/**
	 * Contains.
	 *
	 * @param string $haystack The haystack.
	 * @param string $needle The needle.
	 *
	 * @return boolean
	 */
	public static function contains( string $haystack, string $needle ): bool {
		return strpos( $haystack, $needle ) !== false;
	}
}
