<?php
/**
 * Related Carousel
 *
 * @package Origamiez
 */

$args = origamiez_get_related_posts_query_args( null, 5 );
if ( empty( $args ) ) {
	return;
}
$related_posts = new WP_Query( $args );
if ( $related_posts->have_posts() ) :
	?>
	<div id="origamiez-post-related" class="widget">
		<h2 class="widget-title clearfix">
			<span class="widget-title-text pull-left"><?php esc_html_e( 'Related Articles', 'origamiez' ); ?></span>
			<span class="pull-right owl-custom-pagination fa fa-angle-right origamiez-transition-all"></span>
			<span class="pull-right owl-custom-pagination fa fa-angle-left origamiez-transition-all"></span>
		</h2>
		<div class="origamiez-widget-content clearfix">
			<div class="owl-carousel owl-theme">
				<?php
				while ( $related_posts->have_posts() ) :
					$related_posts->the_post();
					?>
					<figure class="post">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'origamiez-square-md', array( 'class' => 'img-responsive' ) ); ?>
						<?php else : ?>
							<img src="http://placehold.it/374x209" class="img-responsive" alt="<?php echo esc_attr( get_the_title() ); ?>">
						<?php endif; ?>
						<figcaption><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></figcaption>
					</figure>
					<?php
				endwhile;
				?>
			</div>
		</div>
	</div>
	<?php
endif;
wp_reset_postdata();
