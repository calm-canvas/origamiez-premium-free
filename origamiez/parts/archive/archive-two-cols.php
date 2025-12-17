<?php
/**
 * The template part for displaying archive in two columns.
 *
 * @package Origamiez
 */

?>
<div class="archive-two-cols">
	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
	?>
</div>
