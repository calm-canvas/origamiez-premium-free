<?php

use Origamiez\Engine\Helpers\StringHelper;
use Origamiez\Engine\Helpers\ImageHelper;
use Origamiez\Engine\Helpers\DateTimeHelper;
use Origamiez\Engine\Helpers\MetadataHelper;
use Origamiez\Engine\Helpers\CssUtilHelper;
use Origamiez\Engine\Helpers\ImageSizeManager;
use Origamiez\Engine\Helpers\OptionsSyncHelper;
use Origamiez\Engine\Config\SocialConfig;
use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Helpers\FormatHelper;

if ( ! function_exists( 'origamiez_get_str_uglify' ) ) {
	function origamiez_get_str_uglify( string $string ): string {
		return StringHelper::uglify( $string );
	}
}

if ( ! function_exists( 'origamiez_get_image_src' ) ) {
	function origamiez_get_image_src( int $postId = 0, string $size = 'thumbnail' ): string {
		return ImageHelper::get_image_src( $postId, $size );
	}
}

if ( ! function_exists( 'origamiez_remove_hardcoded_image_size' ) ) {
	function origamiez_remove_hardcoded_image_size( string $html ): string {
		return ImageHelper::remove_hardcoded_dimensions( $html );
	}
}

if ( ! function_exists( 'origamiez_human_time_diff' ) ) {
	function origamiez_human_time_diff( int $from ): string {
		return DateTimeHelper::human_time_diff( $from );
	}
}

if ( ! function_exists( 'origamiez_get_metadata_prefix' ) ) {
	function origamiez_get_metadata_prefix( bool $echo = true ): string {
		return MetadataHelper::get_metadata_prefix( $echo );
	}
}

if ( ! function_exists( 'origamiez_get_wrap_classes' ) ) {
	function origamiez_get_wrap_classes(): string {
		return CssUtilHelper::get_wrap_classes();
	}
}

if ( ! function_exists( 'origamiez_register_new_image_sizes' ) ) {
	function origamiez_register_new_image_sizes(): void {
		ImageSizeManager::register();
	}
}

if ( ! function_exists( 'origamiez_get_socials' ) ) {
	function origamiez_get_socials(): array {
		return SocialConfig::get_socials();
	}
}

if ( ! function_exists( 'origamiez_get_allowed_tags' ) ) {
	function origamiez_get_allowed_tags(): array {
		return AllowedTagsConfig::get_allowed_tags();
	}
}

if ( ! function_exists( 'origamiez_sanitize_content' ) ) {
	function origamiez_sanitize_content( string $content ): string {
		return AllowedTagsConfig::sanitize_content( $content );
	}
}

if ( ! function_exists( 'origamiez_get_format_icon' ) ) {
	function origamiez_get_format_icon( string $format ): string {
		return FormatHelper::get_format_icon( $format );
	}
}
