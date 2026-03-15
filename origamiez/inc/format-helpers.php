<?php
/**
 * Format Helpers
 *
 * @package Origamiez
 */

use Origamiez\Helpers\FormatHelper;

/**
 * Get format icon
 *
 * @param string $format Post format.
 * @return string
 */
function origamiez_get_format_icon( $format ) {
	return FormatHelper::get_format_icon( $format );
}

/**
 * Get breadcrumb
 */
function origamiez_get_breadcrumb() {
	do_action( 'origamiez_print_breadcrumb' );
}
