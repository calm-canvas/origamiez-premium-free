<?php
/**
 * Post Class Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Post;

/**
 * Class PostClassManager
 *
 * @package Origamiez\Engine\Post
 */
class PostClassManager {

	/**
	 * Get post classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function get_post_classes( array $classes = array() ): array {
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

		$post_format = get_post_format( $post->ID );
		if ( $post_format && 'standard' !== $post_format ) {
			$classes[] = 'origamiez-post-format-' . $post_format;
		}

		if ( has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'origamiez-has-thumbnail';
		}

		return $classes;
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register(): void {
		add_filter( 'post_class', array( $this, 'get_post_classes' ) );
	}
}
