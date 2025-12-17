<?php
/**
 * DateTime Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class DateTimeHelper
 */
class DateTimeHelper {

	/**
	 * Get human-readable time difference.
	 *
	 * @param int $from From time.
	 * @param int $to To time.
	 * @return string
	 */
	public static function human_time_diff( int $from, int $to = 0 ): string {
		if ( 0 === $to ) {
			$to = time();
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

		$lengths_count = count( $lengths );
		for ( $j = 0; ( $difference >= $lengths[ $j ] && $j < $lengths_count - 1 ); $j++ ) {
			$difference /= $lengths[ $j ];
		}

		$difference = round( $difference );

		if ( 1 !== $difference ) {
			$periods[ $j ] .= esc_attr__( 's', 'origamiez' );
		}

		return "$difference $periods[$j] {$tense}";
	}

	/**
	 * Get formatted date.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $format Date format.
	 * @return string
	 */
	public static function get_formatted_date( int $post_id = 0, string $format = '' ): string {
		if ( 0 === $post_id ) {
			$post_id = get_the_ID();
		}

		if ( empty( $format ) ) {
			$format = get_option( 'date_format' );
		}

		$timestamp = get_the_time( 'U', $post_id );
		return date_i18n( $format, $timestamp );
	}

	/**
	 * Get formatted time.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $format Time format.
	 * @return string
	 */
	public static function get_formatted_time( int $post_id = 0, string $format = '' ): string {
		if ( 0 === $post_id ) {
			$post_id = get_the_ID();
		}

		if ( empty( $format ) ) {
			$format = get_option( 'time_format' );
		}

		$timestamp = get_the_time( 'U', $post_id );
		return date_i18n( $format, $timestamp );
	}
}
