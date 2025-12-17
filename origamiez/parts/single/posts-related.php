<?php
/**
 * The template part for displaying related posts in single posts.
 *
 * @package Origamiez
 */

$related_posts = origamiez_get_related_posts( get_the_ID(), 3 );

if ( $related_posts->have_posts() ) {
	?>
	<div class="related-posts">
		<h3 class="related-posts-title"><?php esc_html_e( 'Related Posts', 'origamiez' ); ?></h3>
		<div class="row">
			<?php
			while ( $related_posts->have_posts() ) {
				$related_posts->the_post();
				?>
				<div class="col-md-4">
					<?php get_template_part( 'template-parts/content', 'related' ); ?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}
wp_reset_postdata();
