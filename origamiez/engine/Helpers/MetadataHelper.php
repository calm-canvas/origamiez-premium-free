<?php
/**
 * Metadata Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class MetadataHelper
 */
class MetadataHelper {

	/**
	 * Get metadata prefix.
	 *
	 * @param bool $display Whether to display or return.
	 * @return string
	 */
	public static function get_metadata_prefix( bool $display = true ): string {
		$prefix = apply_filters( 'origamiez_get_metadata_prefix', '–' );
		if ( $display ) {
			echo wp_kses_post( $prefix );
		}
		return $prefix;
	}

	/**
	 * Display metadata prefix.
	 */
	public static function display_metadata_prefix(): void {
		echo wp_kses_post( self::get_metadata_prefix( false ) );
	}
}
