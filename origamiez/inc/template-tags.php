<?php
/**
 * Template Tags and Display Functions
 *
 * @package Origamiez
 */

use Origamiez\Engine\Helpers\ImageHelper;
use Origamiez\Engine\Helpers\MetadataHelper;
use Origamiez\Engine\Helpers\CssUtilHelper;
use Origamiez\Engine\Helpers\DateTimeHelper;
use Origamiez\Engine\Helpers\FormatHelper;

if ( ! function_exists( 'origamiez_get_image_src' ) ) {
	/**
	 * Get image source.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $size    Image size.
	 * @return string
	 */
	function origamiez_get_image_src( int $post_id = 0, string $size = 'thumbnail' ): string {
		return ImageHelper::get_image_src( $post_id, $size );
	}
}

if ( ! function_exists( 'origamiez_remove_hardcoded_image_size' ) ) {
	/**
	 * Remove hardcoded image size.
	 *
	 * @param string $html HTML content.
	 * @return string
	 */
	function origamiez_remove_hardcoded_image_size( string $html ): string {
		return ImageHelper::remove_hardcoded_dimensions( $html );
	}
}

if ( ! function_exists( 'origamiez_get_metadata_prefix' ) ) {
	/**
	 * Get metadata prefix.
	 *
	 * @param bool $should_echo Whether to echo.
	 * @return string
	 */
	function origamiez_get_metadata_prefix( bool $should_echo = true ): string {
		return MetadataHelper::get_metadata_prefix( $should_echo );
	}
}

if ( ! function_exists( 'origamiez_get_wrap_classes' ) ) {
	/**
	 * Get wrap classes.
	 *
	 * @return string
	 */
	function origamiez_get_wrap_classes(): string {
		return CssUtilHelper::get_wrap_classes();
	}
}

if ( ! function_exists( 'origamiez_human_time_diff' ) ) {
	/**
	 * Get human time diff.
	 *
	 * @param int $from From time.
	 * @return string
	 */
	function origamiez_human_time_diff( int $from ): string {
		return DateTimeHelper::human_time_diff( $from );
	}
}

if ( ! function_exists( 'origamiez_get_format_icon' ) ) {
	/**
	 * Get format icon.
	 *
	 * @param string $format Format.
	 * @return string
	 */
	function origamiez_get_format_icon( string $format ): string {
		return FormatHelper::get_format_icon( $format );
	}
}
