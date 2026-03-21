<?php
/**
 * Title: Posts List With Background Color
 * Slug: origamiez/posts-list-with-background-color
 * Categories: origamiez, query
 * Keywords: background, posts, query
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/widgets/posts-list-with-background-color' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
