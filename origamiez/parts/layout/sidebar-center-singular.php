<?php
/**
 * Main column with breadcrumb + singular entry loop + right sidebar (index / page templates).
 *
 * @package Origamiez
 */

?>
<div id="sidebar-center" class="origamiez-size-01 pull-left">
	<?php get_template_part( 'parts/breadcrumb' ); ?>
	<?php if ( have_posts() ) : ?>
		<div class="clearfix"></div>
		<div id="sidebar-center-bottom" class="clearfix">
			<?php
			while ( have_posts() ) :
				the_post();
				set_query_var( 'origamiez_hide_entry_title', true );
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
<?php get_template_part( 'parts/sidebar', 'right' ); ?>
	<div class="clearfix"></div>
