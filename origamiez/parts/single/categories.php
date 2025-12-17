<?php
/**
 * The template part for displaying categories in single posts.
 *
 * @package Origamiez
 */

$categories_list = get_the_category_list( esc_html__( ', ', 'origamiez' ) );
if ( $categories_list && origamiez_categorized_blog() ) {
	/* translators: %1$s: List of categories. */
	printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'origamiez' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
