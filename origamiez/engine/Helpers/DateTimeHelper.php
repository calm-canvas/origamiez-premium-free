<?php

namespace Origamiez\Engine\Helpers;

class DateTimeHelper {

	public static function humanTimeDiff( int $from, int $to = 0 ): string {
		if ( 0 === $to ) {
			$to = current_time( 'timestamp' );
		}

		$periods = array(
			esc_attr__( 'second', 'origamiez' ),
			esc_attr__( 'minute', 'origamiez' ),
			esc_attr__( 'hour', 'origamiez' ),
			esc_attr__( 'day', 'origamiez' ),
			esc_attr__( 'week', 'origamiez' ),
			esc_attr__( 'month', 'origamiez' ),
			esc_attr__( 'year', 'origamiez' ),
			esc_attr__( 'decade', 'origamiez' ),
		);

		$lengths = array( '60', '60', '24', '7', '4.35', '12', '10' );

		if ( $to > $from ) {
			$difference = $to - $from;
			$tense      = esc_attr__( 'ago', 'origamiez' );
		} else {
			$difference = $from - $to;
			$tense      = esc_attr__( 'from now', 'origamiez' );
		}

		for ( $j = 0; ( $difference >= $lengths[ $j ] && $j < count( $lengths ) - 1 ); $j++ ) {
			$difference /= $lengths[ $j ];
		}

		$difference = round( $difference );

		if ( 1 !== $difference ) {
			$periods[ $j ] .= esc_attr__( 's', 'origamiez' );
		}

		return "$difference $periods[$j] {$tense}";
	}

	public static function getFormattedDate( int $postId = 0, string $format = '' ): string {
		if ( 0 === $postId ) {
			$postId = get_the_ID();
		}

		if ( empty( $format ) ) {
			$format = get_option( 'date_format' );
		}

		$timestamp = get_the_time( 'U', $postId );
		return date_i18n( $format, $timestamp );
	}

	public static function getFormattedTime( int $postId = 0, string $format = '' ): string {
		if ( 0 === $postId ) {
			$postId = get_the_ID();
		}

		if ( empty( $format ) ) {
			$format = get_option( 'time_format' );
		}

		$timestamp = get_the_time( 'U', $postId );
		return date_i18n( $format, $timestamp );
	}
}
