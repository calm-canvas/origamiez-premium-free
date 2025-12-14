<?php

namespace Origamiez\Engine\Post;

class PostClassManager {

	public function getPostClasses( array $classes = [] ): array {
		if ( ! in_the_loop() ) {
			return $classes;
		}

		global $post;

		if ( ! $post ) {
			return $classes;
		}

		$classes[] = 'origamiez-post';
		$classes[] = 'origamiez-post-' . $post->post_type;
		$classes[] = 'origamiez-post-' . $post->ID;

		$postFormat = get_post_format( $post->ID );
		if ( $postFormat && 'standard' !== $postFormat ) {
			$classes[] = 'origamiez-post-format-' . $postFormat;
		}

		if ( has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'origamiez-has-thumbnail';
		}

		return $classes;
	}

	public function register(): void {
		add_filter( 'post_class', [ $this, 'getPostClasses' ] );
	}
}
