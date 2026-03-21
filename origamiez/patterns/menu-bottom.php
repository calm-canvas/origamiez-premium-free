<?php
/**
 * Title: Bottom Menu
 * Slug: origamiez/menu-bottom
 * Categories: origamiez, footer
 * Keywords: menu, footer
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/menu-bottom' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
