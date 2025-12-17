<?php
/**
 * Backward Compatibility Functions
 *
 * @package Origamiez
 */

use Origamiez\Engine\Helpers\StringHelper;
use Origamiez\Engine\Helpers\ImageHelper;
use Origamiez\Engine\Helpers\DateTimeHelper;
use Origamiez\Engine\Helpers\MetadataHelper;
use Origamiez\Engine\Helpers\CssUtilHelper;
use Origamiez\Engine\Helpers\ImageSizeManager;
use Origamiez\Engine\Config\SocialConfig;
use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Helpers\FormatHelper;

if ( ! function_exists( 'origamiez_get_str_uglify' ) ) {
	/**
	 * Get string uglify.
	 *
	 * @param string $string The string.
	 * @return string
	 */
	function origamiez_get_str_uglify( string $string ): string {
		return StringHelper::uglify( $string );
	}
}

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

if ( ! function_exists( 'origamiez_get_metadata_prefix' ) ) {
	/**
	 * Get metadata prefix.
	 *
	 * @param bool $echo Whether to echo.
	 * @return string
	 */
	function origamiez_get_metadata_prefix( bool $echo = true ): string {
		return MetadataHelper::get_metadata_prefix( $echo );
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

if ( ! function_exists( 'origamiez_register_new_image_sizes' ) ) {
	/**
	 * Register new image sizes.
	 */
	function origamiez_register_new_image_sizes(): void {
		ImageSizeManager::register();
	}
}

if ( ! function_exists( 'origamiez_get_socials' ) ) {
	/**
	 * Get socials.
	 *
	 * @return array
	 */
	function origamiez_get_socials(): array {
		return SocialConfig::get_socials();
	}
}

if ( ! function_exists( 'origamiez_get_allowed_tags' ) ) {
	/**
	 * Get allowed tags.
	 *
	 * @return array
	 */
	function origamiez_get_allowed_tags(): array {
		return AllowedTagsConfig::get_allowed_tags();
	}
}

if ( ! function_exists( 'origamiez_sanitize_content' ) ) {
	/**
	 * Sanitize content.
	 *
	 * @param string $content Content.
	 * @return string
	 */
	function origamiez_sanitize_content( string $content ): string {
		return AllowedTagsConfig::sanitize_content( $content );
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
