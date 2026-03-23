<?php
/**
 * Template Page Three Cols Slm
 *
 * @package Origamiez
 */

/*
 * Template Name: Page Three Column - SLM
 */
get_header();
?>
<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'middle' ); ?>
	<div id="sidebar-center" class="origamiez-size-01 pull-left">
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
<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'middle-clone' ); ?>
<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'right' ); ?>
	<div class="clearfix"></div>
<?php

get_footer();
