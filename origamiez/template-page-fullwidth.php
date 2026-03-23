<?php
/**
 * Template Page Fullwidth
 *
 * @package Origamiez
 */

/*
 * Template Name: Page Fullwidth
 */
get_header();
?>
<?php get_template_part( 'parts/breadcrumb' ); ?>
<?php if ( have_posts() ) : ?>
	<div class="clearfix"></div>
	<div id="sidebar-center-bottom" class="clearfix">
		<?php
		while ( have_posts() ) :
			the_post();
			set_query_var( 'origamiez_hide_entry_title', false );
			get_template_part( 'parts/loop/singular-entry' );
		endwhile;
		?>
	</div>
	<?php
else :
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );
endif;
?>
	<div class="clearfix"></div>
<?php

get_footer();
