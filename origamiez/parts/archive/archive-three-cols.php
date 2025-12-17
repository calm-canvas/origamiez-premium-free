<?php
/**
 * The template part for displaying archive in three columns.
 *
 * @package Origamiez
 */

?>
<div class="archive-three-cols">
	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
	?>
</div>
