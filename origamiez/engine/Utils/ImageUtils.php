<?php

namespace Origamiez\Engine\Utils;

class ImageUtils {

	public static function getImageSrc( $imageId, string $size = 'medium' ): ?string {
		$src = wp_get_attachment_image_src( $imageId, $size );
		return $src ? $src[0] : null;
	}

	public static function getPostThumbnail( $postId = 0, string $size = 'post-thumbnail', $default = null ) {
		if ( ! has_post_thumbnail( $postId ) ) {
			return $default;
		}

		return get_the_post_thumbnail( $postId, $size );
	}

	public static function getPostThumbnailId( $postId = 0 ): int {
		return (int) get_post_thumbnail_id( $postId );
	}

	public static function removeHardcodedImageSize( string $html ): string {
		return preg_replace( '/\s*height="\d+"\s*/', ' ', preg_replace( '/\s*width="\d+"\s*/', ' ', $html ) );
	}

	public static function getAttachmentUrl( $attachmentId ): ?string {
		$url = wp_get_attachment_url( $attachmentId );
		return $url ? $url : null;
	}

	public static function getImageDimensions( string $url ): ?array {
		$filesize = filesize( get_template_directory() . $url );

		if ( function_exists( 'getimagesize' ) ) {
			return getimagesize( $url );
		}

		return null;
	}

	public static function registerImageSize( string $name, int $width, int $height, bool $crop = false ): void {
		add_image_size( $name, $width, $height, $crop );
	}

	public static function getImageSizes(): array {
		global $_wp_additional_image_sizes;

		$builtin = [
			'thumbnail' => [
				'width'  => get_option( 'thumbnail_size_w' ),
				'height' => get_option( 'thumbnail_size_h' ),
				'crop'   => get_option( 'thumbnail_crop' ),
			],
			'medium'    => [
				'width'  => get_option( 'medium_size_w' ),
				'height' => get_option( 'medium_size_h' ),
			],
			'medium_large' => [
				'width'  => get_option( 'medium_large_size_w' ),
				'height' => get_option( 'medium_large_size_h' ),
			],
			'large'     => [
				'width'  => get_option( 'large_size_w' ),
				'height' => get_option( 'large_size_h' ),
			],
		];

		return array_merge( $builtin, $_wp_additional_image_sizes ?? [] );
	}

	public static function hasImageSize( string $name ): bool {
		return isset( wp_get_registered_image_subsizes()[ $name ] );
	}
}
