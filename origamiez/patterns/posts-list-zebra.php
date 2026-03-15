<?php
/**
 * Title: Posts List Zebra
 * Slug: origamiez/posts-list-zebra
 * Categories: origamiez, query
 * Keywords: zebra, posts, query
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/widgets/posts-list-zebra' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
