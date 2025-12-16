<?php

namespace Origamiez\Engine\Post;

class MetadataManager {

	private const META_PREFIX = 'origamiez_';

	public function getMetaPrefix(): string {
		return self::META_PREFIX;
	}

	public function getMeta( $postId, string $key, bool $single = true ) {
		return get_post_meta( $postId, self::META_PREFIX . $key, $single );
	}

	public function setMeta( $postId, string $key, $value ): int {
		return update_post_meta( $postId, self::META_PREFIX . $key, $value );
	}

	public function deleteMeta( $postId, string $key, $value = '' ): bool {
		return delete_post_meta( $postId, self::META_PREFIX . $key, $value );
	}

	public function getAllMeta( $postId ): array {
		$allMeta      = get_post_meta( $postId );
		$prefixedMeta = array();

		foreach ( $allMeta as $key => $value ) {
			if ( strpos( $key, self::META_PREFIX ) === 0 ) {
				$cleanKey                  = substr( $key, strlen( self::META_PREFIX ) );
				$prefixedMeta[ $cleanKey ] = $value[0] ?? $value;
			}
		}

		return $prefixedMeta;
	}

	public function postHasMeta( $postId, string $key ): bool {
		return metadata_exists( 'post', $postId, self::META_PREFIX . $key );
	}
}
