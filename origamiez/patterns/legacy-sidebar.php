<?php
/**
 * Title: Legacy-Look Sidebar
 * Slug: origamiez/legacy-sidebar
 * Categories: origamiez, sidebar
 * Description: A sidebar pattern recreating the classic Origamiez widget style.
 *
 * @package Origamiez
 */

?>
<div class="origamiez-sidebar-wrapper">
	<!-- wp:heading {"level":3,"className":"widget-title"} -->
	<h3 class="wp-block-heading widget-title"><?php esc_html_e( 'Recent Posts', 'origamiez' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:latest-posts {"postsToShow":5,"displayPostDate":true} /-->

	<!-- wp:heading {"level":3,"className":"widget-title"} -->
	<h3 class="wp-block-heading widget-title"><?php esc_html_e( 'Categories', 'origamiez' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:categories /-->
</div>
