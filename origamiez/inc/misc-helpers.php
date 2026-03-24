<?php
/**
 * Misc Helpers
 *
 * @package Origamiez
 */

use Origamiez\Config\AllowedTagsConfig;
use Origamiez\Helpers\MetadataHelper;

/**
 * Get the metadata prefix.
 *
 * @param bool $display Whether to echo the prefix.
 * @return string The metadata prefix.
 */
function origamiez_get_metadata_prefix( $display = true ) {
	return MetadataHelper::get_metadata_prefix( $display );
}

/**
 * Get allowed HTML tags configuration.
 *
 * @return array Allowed HTML tags.
 */
function origamiez_get_allowed_tags() {
	return AllowedTagsConfig::get_allowed_tags();
}

/**
 * Create a filter callback that returns a static numeric value.
 *
 * Use this factory to generate filter callbacks dynamically without
 * needing individual functions for each numeric value. This replaces
 * the need for multiple origamiez_return_X() functions.
 *
 * @param int $value The numeric value to return.
 * @return callable A function that returns the specified value.
 */
function origamiez_create_value_callback( $value ) {
	return static function () use ( $value ) {
		return $value;
	};
}

/**
 * Get or create a cached numeric filter callback.
 *
 * Caches closures to avoid recreating them repeatedly, improving
 * performance when the same numeric value is used as a filter callback.
 *
 * @param int $value The numeric value to return.
 * @return callable The cached callback function.
 */
function origamiez_get_value_callback( $value ) {
	static $callbacks = array();

	if ( ! isset( $callbacks[ $value ] ) ) {
		$callbacks[ $value ] = origamiez_create_value_callback( $value );
	}

	return $callbacks[ $value ];
}

/**
 * Output paginated post/page navigation for singular views (shared Customizer markup).
 *
 * @param string $separator Value for wp_link_pages 'separator' (single posts often use empty string).
 */
function origamiez_the_singular_wp_link_pages( $separator = ' . ' ) {
	wp_link_pages(
		array(
			'before'           => '<div id="origamiez_singular_pagination" class="clearfix">',
			'after'            => '</div>',
			'next_or_number'   => 'next',
			'separator'        => $separator,
			'nextpagelink'     => esc_attr__( 'Next', 'origamiez' ),
			'previouspagelink' => esc_attr__( 'Previous', 'origamiez' ),
		)
	);
}

/**
 * Resolve the target post ID for related-posts queries.
 *
 * @param int|null $post_id Post ID, or null to use the global $post.
 * @return int Post ID, or 0 when not resolvable.
 */
function origamiez_resolve_related_post_id( $post_id ) {
	global $post;

	if ( $post_id ) {
		return (int) $post_id;
	}

	if ( isset( $post->ID ) ) {
		return (int) $post->ID;
	}

	return 0;
}

/**
 * Build a tag-based tax_query fragment for related posts.
 *
 * @param int $resolved_id Post ID.
 * @return array<int, array<string, mixed>>|null One tax_query clause set, or null when there are no tags.
 */
function origamiez_related_posts_tax_query_for_tags( $resolved_id ) {
	$tags = get_the_tags( $resolved_id );
	if ( empty( $tags ) ) {
		return null;
	}

	$tag_ids = array();
	foreach ( $tags as $t ) {
		$tag_ids[] = $t->term_id;
	}

	return array(
		array(
			'taxonomy' => 'post_tag',
			'field'    => 'id',
			'terms'    => $tag_ids,
		),
	);
}

/**
 * Build a category-based tax_query fragment for related posts.
 *
 * @param int $resolved_id Post ID.
 * @return array<int, array<string, mixed>>|null One tax_query clause set, or null when there are no categories.
 */
function origamiez_related_posts_tax_query_for_categories( $resolved_id ) {
	$categories = get_the_category( $resolved_id );
	if ( empty( $categories ) ) {
		return null;
	}

	$category_id = array();
	foreach ( $categories as $category ) {
		$category_id[] = $category->term_id;
	}

	return array(
		array(
			'taxonomy' => 'category',
			'field'    => 'id',
			'terms'    => $category_id,
		),
	);
}

/**
 * Build WP_Query arguments for related posts (tags or categories per Customizer).
 *
 * @param int|null $post_id        Post ID. Defaults to global $post.
 * @param int      $default_count Fallback for `number_of_related_posts` when the theme mod is unset.
 * @return array<string, mixed> Query arguments; empty if the post ID is invalid.
 */
function origamiez_get_related_posts_query_args( $post_id = null, $default_count = 5 ) {
	$resolved_id = origamiez_resolve_related_post_id( $post_id );
	if ( $resolved_id <= 0 ) {
		return array();
	}

	$get_related_post_by     = get_theme_mod( 'get_related_post_by', 'post_tag' );
	$number_of_related_posts = (int) get_theme_mod( 'number_of_related_posts', $default_count );

	$args = array(
		'post__not_in'   => array( $resolved_id ),
		'posts_per_page' => $number_of_related_posts,
	);

	if ( 'post_tag' === $get_related_post_by ) {
		$tax_query = origamiez_related_posts_tax_query_for_tags( $resolved_id );
		if ( null !== $tax_query ) {
			$args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}
	} else {
		$tax_query = origamiez_related_posts_tax_query_for_categories( $resolved_id );
		if ( null !== $tax_query ) {
			$args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}
	}

	return $args;
}
