<?php
/**
 * Theme Support Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine;

use Origamiez\Engine\Helpers\ImageSizeManager;

/**
 * Class ThemeSupportManager
 *
 * Handles registration of WordPress theme features and support.
 *
 * @package Origamiez\Engine
 */
class ThemeSupportManager {

	/**
	 * Register theme supports.
	 */
	public static function register(): void {
		self::register_theme_supports();
		self::register_image_sizes();
		self::register_editor_style();
		self::set_content_width();
	}

	/**
	 * Register theme supports.
	 */
	private static function register_theme_supports(): void {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );

		add_theme_support(
			'custom-background',
			ORIGAMIEZ_CONFIG['theme_support']['custom_background']
		);

		$custom_header_args = apply_filters(
			'origamiez_custom_header_args',
			ORIGAMIEZ_CONFIG['theme_support']['custom_header']
		);

		add_theme_support( 'custom-header', $custom_header_args );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		add_theme_support(
			'html5',
			array(
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
			)
		);

		add_theme_support( 'loop-pagination' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', ORIGAMIEZ_CONFIG['theme_support']['post_formats'] );
		add_theme_support( 'editor_style' );
	}

	/**
	 * Register image sizes.
	 */
	private static function register_image_sizes(): void {
		ImageSizeManager::register();
	}

	/**
	 * Register editor style.
	 */
	private static function register_editor_style(): void {
		add_editor_style( 'editor-style.css' );
	}

	/**
	 * Set content width.
	 */
	private static function set_content_width(): void {
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = ORIGAMIEZ_CONFIG['theme_support']['content_width'];
		}
	}
}
