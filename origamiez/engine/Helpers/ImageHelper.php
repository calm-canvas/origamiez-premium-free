<?php

namespace Origamiez\Engine\Helpers;

class ImageHelper {

	public static function getImageSrc( int $postId = 0, string $size = 'thumbnail' ): string {
		$thumb = get_the_post_thumbnail( $postId, $size );
		if ( ! empty( $thumb ) ) {
			$regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
			preg_match( $regex, $thumb, $_thumb );
			$thumb = $_thumb[2] ?? '';
		}
		return $thumb;
	}

	public static function removeHardcodedDimensions( string $html ): string {
		return preg_replace( '/(width|height)="\d+"\s/', '', $html );
	}

	public static function getImageDimensions( int $postId = 0, string $size = 'thumbnail' ): array {
		$thumbnail_src = self::getImageSrc( $postId, $size );
		if ( empty( $thumbnail_src ) ) {
			return array( 0, 0 );
		}

		$image_size = wp_get_attachment_image_src( get_post_thumbnail_id( $postId ), $size );
		if ( $image_size ) {
			return array( $image_size[1], $image_size[2] );
		}

		return array( 0, 0 );
	}

	public static function hasThumbnail( int $postId = 0 ): bool {
		return has_post_thumbnail( $postId );
	}
}
