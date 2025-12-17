<?php
/**
 * Metadata Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Post;

/**
 * Class MetadataManager
 *
 * @package Origamiez\Engine\Post
 */
class MetadataManager {

	/**
	 * Meta prefix
	 *
	 * @var string
	 */
	private const META_PREFIX = 'origamiez_';

	/**
	 * Get meta prefix.
	 *
	 * @return string
	 */
	public function get_meta_prefix(): string {
		return self::META_PREFIX;
	}

	/**
	 * Get meta.
	 *
	 * @param int    $post_id The post id.
	 * @param string $key The key.
	 * @param bool   $single The single.
	 *
	 * @return mixed
	 */
	public function get_meta( $post_id, string $key, bool $single = true ) {
		return get_post_meta( $post_id, self::META_PREFIX . $key, $single );
	}

	/**
	 * Set meta.
	 *
	 * @param int    $post_id The post id.
	 * @param string $key The key.
	 * @param mixed  $value The value.
	 *
	 * @return integer
	 */
	public function set_meta( $post_id, string $key, $value ): int {
		return update_post_meta( $post_id, self::META_PREFIX . $key, $value );
	}

	/**
	 * Delete meta.
	 *
	 * @param int    $post_id The post id.
	 * @param string $key The key.
	 * @param mixed  $value The value.
	 *
	 * @return boolean
	 */
	public function delete_meta( $post_id, string $key, $value = '' ): bool {
		return delete_post_meta( $post_id, self::META_PREFIX . $key, $value );
	}

	/**
	 * Get all meta.
	 *
	 * @param int $post_id The post id.
	 *
	 * @return array
	 */
	public function get_all_meta( $post_id ): array {
		$all_meta      = get_post_meta( $post_id );
		$prefixed_meta = array();

		foreach ( $all_meta as $key => $value ) {
			if ( strpos( $key, self::META_PREFIX ) === 0 ) {
				$clean_key                   = substr( $key, strlen( self::META_PREFIX ) );
				$prefixed_meta[ $clean_key ] = $value[0] ?? $value;
			}
		}

		return $prefixed_meta;
	}

	/**
	 * Post has meta.
	 *
	 * @param int    $post_id The post id.
	 * @param string $key The key.
	 *
	 * @return boolean
	 */
	public function post_has_meta( $post_id, string $key ): bool {
		return metadata_exists( 'post', $post_id, self::META_PREFIX . $key );
	}
}
