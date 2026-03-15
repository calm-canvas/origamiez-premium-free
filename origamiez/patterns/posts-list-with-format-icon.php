<?php
/**
 * Title: Posts List With Format Icon
 * Slug: origamiez/posts-list-with-format-icon
 * Categories: origamiez, query
 * Keywords: format icon, posts, query
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/widgets/posts-list-with-format-icon' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
