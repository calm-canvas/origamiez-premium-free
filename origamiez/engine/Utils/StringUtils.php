<?php

namespace Origamiez\Engine\Utils;

class StringUtils {

	public static function slugify( string $str ): string {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', $str ) );
	}

	public static function truncate( string $str, int $length = 100, string $suffix = '...' ): string {
		if ( strlen( $str ) <= $length ) {
			return $str;
		}
		return substr( $str, 0, $length ) . $suffix;
	}

	public static function humanTimeDiff( $from = 0, $to = 0 ): string {
		$from = (int) $from;
		$to   = (int) $to;

		$absDiff = abs( $to - $from );

		if ( $absDiff < 1 ) {
			return __( 'just now', 'origamiez' );
		}

		if ( $absDiff < 60 ) {
			return sprintf( _n( '%s second', '%s seconds', $absDiff, 'origamiez' ), $absDiff );
		}

		if ( $absDiff < 3600 ) {
			$minutes = round( $absDiff / 60 );
			return sprintf( _n( '%s minute', '%s minutes', $minutes, 'origamiez' ), $minutes );
		}

		if ( $absDiff < 86400 ) {
			$hours = round( $absDiff / 3600 );
			return sprintf( _n( '%s hour', '%s hours', $hours, 'origamiez' ), $hours );
		}

		if ( $absDiff < 604800 ) {
			$days = round( $absDiff / 86400 );
			return sprintf( _n( '%s day', '%s days', $days, 'origamiez' ), $days );
		}

		if ( $absDiff < 2592000 ) {
			$weeks = round( $absDiff / 604800 );
			return sprintf( _n( '%s week', '%s weeks', $weeks, 'origamiez' ), $weeks );
		}

		if ( $absDiff < 31536000 ) {
			$months = round( $absDiff / 2592000 );
			return sprintf( _n( '%s month', '%s months', $months, 'origamiez' ), $months );
		}

		$years = round( $absDiff / 31536000 );
		return sprintf( _n( '%s year', '%s years', $years, 'origamiez' ), $years );
	}

	public static function sanitizeInput( string $input ): string {
		return sanitize_text_field( $input );
	}

	public static function escapeHtml( string $text ): string {
		return esc_html( $text );
	}

	public static function escapeUrl( string $url ): string {
		return esc_url( $url );
	}

	public static function startsWith( string $haystack, string $needle ): bool {
		return strpos( $haystack, $needle ) === 0;
	}

	public static function endsWith( string $haystack, string $needle ): bool {
		return substr( $haystack, -strlen( $needle ) ) === $needle;
	}

	public static function contains( string $haystack, string $needle ): bool {
		return strpos( $haystack, $needle ) !== false;
	}
}
