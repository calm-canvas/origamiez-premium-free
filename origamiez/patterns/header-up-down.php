<?php
/**
 * Title: Header Up Down
 * Slug: origamiez/header-up-down
 * Categories: origamiez, header
 * Keywords: header, logo, banner
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}},"color":{"background":"var:preset|color|white"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/header/header-up-down' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
