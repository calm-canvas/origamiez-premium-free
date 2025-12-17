<?php
/**
 * Image Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class ImageHelper
 */
class ImageHelper {

	/**
	 * Get image source.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $size Image size.
	 * @return string
	 */
	public static function get_image_src( int $post_id = 0, string $size = 'thumbnail' ): string {
		$thumb = get_the_post_thumbnail( $post_id, $size );
		if ( ! empty( $thumb ) ) {
			$regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
			preg_match( $regex, $thumb, $_thumb );
			$thumb = $_thumb[2] ?? '';
		}
		return $thumb;
	}

	/**
	 * Remove hardcoded dimensions from HTML.
	 *
	 * @param string $html HTML content.
	 * @return string
	 */
	public static function remove_hardcoded_dimensions( string $html ): string {
		return preg_replace( '/(width|height)="\d+"\s/', '', $html );
	}

	/**
	 * Get image dimensions.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $size Image size.
	 * @return array
	 */
	public static function get_image_dimensions( int $post_id = 0, string $size = 'thumbnail' ): array {
		$thumbnail_src = self::get_image_src( $post_id, $size );
		if ( empty( $thumbnail_src ) ) {
			return array( 0, 0 );
		}

		$image_size = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
		if ( $image_size ) {
			return array( $image_size[1], $image_size[2] );
		}

		return array( 0, 0 );
	}

	/**
	 * Check if post has thumbnail.
	 *
	 * @param int $post_id Post ID.
	 * @return bool
	 */
	public static function has_thumbnail( int $post_id = 0 ): bool {
		return has_post_thumbnail( $post_id );
	}
}
