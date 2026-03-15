<?php
/**
 * Theme Support Manager
 *
 * @package Origamiez
 */

namespace Origamiez;

use Origamiez\Helpers\ImageSizeManager;

/**
 * Class ThemeSupportManager
 *
 * Handles registration of WordPress theme features and support.
 *
 * @package Origamiez
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
		self::register_block_patterns();
	}

	/**
	 * Register block patterns.
	 */
	private static function register_block_patterns(): void {
		add_action(
			'init',
			function () {
				$pattern_dir = get_template_directory() . '/patterns';
				if ( ! is_dir( $pattern_dir ) ) {
					return;
				}

				$files = glob( $pattern_dir . '/*.php' );
				if ( empty( $files ) ) {
					return;
				}

				// Register a dedicated category for our theme patterns.
				register_block_pattern_category(
					'origamiez',
					array( 'label' => __( 'Origamiez', 'origamiez' ) )
				);

				foreach ( $files as $file ) {
					$pattern_data = get_file_data(
						$file,
						array(
							'title'       => 'Title',
							'slug'        => 'Slug',
							'categories'  => 'Categories',
							'keywords'    => 'Keywords',
							'description' => 'Description',
						)
					);

					if ( empty( $pattern_data['slug'] ) ) {
						continue;
					}

					ob_start();
					include $file;
					$content = ob_get_clean();

					if ( empty( trim( $content ) ) ) {
						continue;
					}

					register_block_pattern(
						$pattern_data['slug'],
						array(
							'title'       => $pattern_data['title'],
							'content'     => $content,
							'categories'  => array_map( 'trim', explode( ',', $pattern_data['categories'] ) ),
							'keywords'    => array_map( 'trim', explode( ',', $pattern_data['keywords'] ) ),
							'description' => $pattern_data['description'],
						)
					);

					// Optimization: Enqueue pattern-specific CSS only if the pattern is registered.
					$pattern_name = basename( $file, '.php' );
					$css_file     = get_template_directory() . '/css/patterns/' . $pattern_name . '.css';
					if ( file_exists( $css_file ) && function_exists( 'wp_enqueue_block_style' ) ) {
						// We use a specific handle to avoid collisions.
						wp_enqueue_block_style(
							'core/group', // We attach to core/group as most patterns use it as a wrapper.
							array(
								'handle' => 'origamiez-pattern-' . str_replace( '/', '-', $pattern_data['slug'] ),
								'src'    => get_template_directory_uri() . '/css/patterns/' . $pattern_name . '.css',
								'path'   => $css_file,
							)
						);
					}
				}
			},
			20
		);
	}

	/**
	 * Register theme supports.
	 */
	private static function register_theme_supports(): void {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'widgets-block-editor' );
		add_theme_support( 'appearance-tools' );
		add_theme_support( 'block-templates' );

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
		add_theme_support( 'editor-styles' );
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
