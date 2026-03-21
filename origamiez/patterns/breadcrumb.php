<?php
/**
 * Title: Breadcrumb
 * Slug: origamiez/breadcrumb
 * Categories: origamiez, layout
 * Keywords: breadcrumb, navigation
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<?php get_template_part( 'parts/breadcrumb' ); ?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
