<?php
/**
 * Title: Header Left Right
 * Slug: origamiez/header-left-right
 * Categories: origamiez, header
 * Keywords: header, logo, banner
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}},"color":{"background":"var:preset|color|white"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/header/header-left-right' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
