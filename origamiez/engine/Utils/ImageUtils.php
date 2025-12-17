<?php
/**
 * Image Utils
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Utils;

/**
 * Class ImageUtils
 *
 * @package Origamiez\Engine\Utils
 */
class ImageUtils {

	/**
	 * Get image src.
	 *
	 * @param int    $image_id The image id.
	 * @param string $size The size.
	 *
	 * @return string|null
	 */
	public static function get_image_src( $image_id, string $size = 'medium' ): ?string {
		$src = wp_get_attachment_image_src( $image_id, $size );
		return $src ? $src[0] : null;
	}

	/**
	 * Get post thumbnail.
	 *
	 * @param int    $post_id The post id.
	 * @param string $size The size.
	 * @param mixed  $default The default.
	 *
	 * @return mixed
	 */
	public static function get_post_thumbnail( $post_id = 0, string $size = 'post-thumbnail', $default = null ) {
		if ( ! has_post_thumbnail( $post_id ) ) {
			return $default;
		}

		return get_the_post_thumbnail( $post_id, $size );
	}

	/**
	 * Get post thumbnail id.
	 *
	 * @param int $post_id The post id.
	 *
	 * @return integer
	 */
	public static function get_post_thumbnail_id( $post_id = 0 ): int {
		return (int) get_post_thumbnail_id( $post_id );
	}

	/**
	 * Remove hardcoded image size.
	 *
	 * @param string $html The html.
	 *
	 * @return string
	 */
	public static function remove_hardcoded_image_size( string $html ): string {
		return preg_replace( '/\s*height="\d+"\s*/', ' ', preg_replace( '/\s*width="\d+"\s*/', ' ', $html ) );
	}

	/**
	 * Get attachment url.
	 *
	 * @param int $attachment_id The attachment id.
	 *
	 * @return string|null
	 */
	public static function get_attachment_url( $attachment_id ): ?string {
		$url = wp_get_attachment_url( $attachment_id );
		return $url ?: null;
	}

	/**
	 * Get image dimensions.
	 *
	 * @param string $url The url.
	 *
	 * @return array|null
	 */
	public static function get_image_dimensions( string $url ): ?array {
		if ( function_exists( 'getimagesize' ) ) {
			return getimagesize( $url );
		}

		return null;
	}

	/**
	 * Register image size.
	 *
	 * @param string  $name The name.
	 * @param integer $width The width.
	 * @param integer $height The height.
	 * @param boolean $crop The crop.
	 *
	 * @return void
	 */
	public static function register_image_size( string $name, int $width, int $height, bool $crop = false ): void {
		add_image_size( $name, $width, $height, $crop );
	}

	/**
	 * Get image sizes.
	 *
	 * @return array
	 */
	public static function get_image_sizes(): array {
		global $_wp_additional_image_sizes;

		$builtin = array(
			'thumbnail'    => array(
				'width'  => get_option( 'thumbnail_size_w' ),
				'height' => get_option( 'thumbnail_size_h' ),
				'crop'   => get_option( 'thumbnail_crop' ),
			),
			'medium'       => array(
				'width'  => get_option( 'medium_size_w' ),
				'height' => get_option( 'medium_size_h' ),
			),
			'medium_large' => array(
				'width'  => get_option( 'medium_large_size_w' ),
				'height' => get_option( 'medium_large_size_h' ),
			),
			'large'        => array(
				'width'  => get_option( 'large_size_w' ),
				'height' => get_option( 'large_size_h' ),
			),
		);

		return array_merge( $builtin, $_wp_additional_image_sizes ?? array() );
	}

	/**
	 * Has image size.
	 *
	 * @param string $name The name.
	 *
	 * @return boolean
	 */
	public static function has_image_size( string $name ): bool {
		return isset( wp_get_registered_image_subsizes()[ $name ] );
	}
}
