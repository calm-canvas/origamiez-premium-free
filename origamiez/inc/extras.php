<?php
/**
 * Miscellaneous Helper Functions
 *
 * @package Origamiez
 */

use Origamiez\Engine\Helpers\StringHelper;
use Origamiez\Engine\Helpers\ImageSizeManager;
use Origamiez\Engine\Config\SocialConfig;
use Origamiez\Engine\Config\AllowedTagsConfig;

if ( ! function_exists( 'origamiez_get_str_uglify' ) ) {
	/**
	 * Get string uglify.
	 *
	 * @param string $str The string.
	 * @return string
	 */
	function origamiez_get_str_uglify( string $str ): string {
		return StringHelper::uglify( $str );
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
