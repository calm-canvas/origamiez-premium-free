<?php

namespace Origamiez\Engine\Helpers;

class ImageSizeManager {

	private static array $imageSizes = array(
		'origamiez-square-xs'         => array( 55, 55, true ),
		'origamiez-lightbox-full'     => array( 960, null, false ),
		'origamiez-blog-full'         => array( 920, 500, true ),
		'origamiez-square-m'          => array( 480, 480, true ),
		'origamiez-square-md'         => array( 480, 320, true ),
		'origamiez-posts-slide-metro' => array( 620, 620, true ),
		'origamiez-grid-l'            => array( 380, 255, true ),
	);

	public static function register(): void {
		foreach ( self::$imageSizes as $size_name => $dimensions ) {
			add_image_size( $size_name, $dimensions[0], $dimensions[1], $dimensions[2] );
		}
	}

	public static function getImageSize( string $sizeName ): ?array {
		return self::$imageSizes[ $sizeName ] ?? null;
	}

	public static function getAllImageSizes(): array {
		return self::$imageSizes;
	}

	public static function addImageSize( string $name, int $width, ?int $height = null, bool $crop = false ): void {
		self::$imageSizes[ $name ] = array( $width, $height, $crop );
		add_image_size( $name, $width, $height, $crop );
	}
}
