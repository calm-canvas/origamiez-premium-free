<?php
/**
 * Template Page Three Cols
 *
 * @package Origamiez
 */

/*
 * Template Name: Page Three Column
 */
get_header();
?>
	<div id="sidebar-center" class="pull-left origamiez-size-01">
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
			get_template_part( 'content', 'none' );
		endif;
		?>
	</div>
<?php get_template_part( 'parts/sidebar', 'middle' ); ?>
<?php get_template_part( 'parts/sidebar', 'right' ); ?>
	<div class="clearfix"></div>
<?php

get_footer();
