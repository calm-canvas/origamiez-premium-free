<?php
/**
 * Title: Top Bar
 * Slug: origamiez/top-bar
 * Categories: origamiez, header
 * Keywords: top bar, header, social
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0px","bottom":"0px"}},"color":{"background":"var:preset|color|secondary"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/top-bar' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
