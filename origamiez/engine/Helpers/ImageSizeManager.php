<?php
/**
 * Image Size Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class ImageSizeManager
 */
class ImageSizeManager {

	/**
	 * Image sizes
	 *
	 * @var array
	 */
	private static array $image_sizes = array(
		'origamiez-square-xs'         => array( 55, 55, true ),
		'origamiez-lightbox-full'     => array( 960, null, false ),
		'origamiez-blog-full'         => array( 920, 500, true ),
		'origamiez-square-m'          => array( 480, 480, true ),
		'origamiez-square-md'         => array( 480, 320, true ),
		'origamiez-posts-slide-metro' => array( 620, 620, true ),
		'origamiez-grid-l'            => array( 380, 255, true ),
	);

	/**
	 * Register image sizes
	 */
	public static function register(): void {
		foreach ( self::$image_sizes as $size_name => $dimensions ) {
			add_image_size( $size_name, $dimensions[0], $dimensions[1], $dimensions[2] );
		}
	}

	/**
	 * Get image size
	 *
	 * @param string $size_name The size name.
	 * @return array|null
	 */
	public static function get_image_size( string $size_name ): ?array {
		return self::$image_sizes[ $size_name ] ?? null;
	}

	/**
	 * Get all image sizes
	 *
	 * @return array
	 */
	public static function get_all_image_sizes(): array {
		return self::$image_sizes;
	}

	/**
	 * Add image size
	 *
	 * @param string   $name The name.
	 * @param int      $width The width.
	 * @param int|null $height The height.
	 * @param bool     $crop The crop.
	 */
	public static function add_image_size( string $name, int $width, ?int $height = null, bool $crop = false ): void {
		self::$image_sizes[ $name ] = array( $width, $height, $crop );
		add_image_size( $name, $width, $height, $crop );
	}
}
