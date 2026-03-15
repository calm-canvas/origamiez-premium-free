<?php
/**
 * Title: Posts List Slider
 * Slug: origamiez/posts-list-slider
 * Categories: origamiez, query
 * Keywords: slider, posts, query
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/widgets/posts-list-slider' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
