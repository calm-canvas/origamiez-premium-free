<?php
/**
 * Related Flat List
 *
 * @package Origamiez
 */

$args = origamiez_get_related_posts_query_args( null, 8 );
if ( empty( $args ) ) {
	return;
}
$related_posts = new WP_Query( $args );
if ( $related_posts->have_posts() ) :
	?>
	<div id="origamiez-post-related" class="widget origamiez-widget-posts-two-cols">
		<h2 class="widget-title clearfix">
			<span class="widget-title-text pull-left"><?php esc_html_e( 'Related Articles', 'origamiez' ); ?></span>
		</h2>
		<div class="origamiez-widget-content clearfix">
			<div class="row">
				<div class="article-col-left col-sm-6 col-xs-12">
				<?php
				$loop_index = 0;
				while ( $related_posts->have_posts() ) :
					$related_posts->the_post();
					$post_title   = get_the_title();
					$post_url     = get_permalink();
					$post_classes = "origamiez-post-{$loop_index} clearfix";
					if ( 0 === $loop_index ) :
						?>
						<article <?php post_class( $post_classes ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a class="link-hover-effect origamiez-post-thumb"
									href="<?php the_permalink(); ?>">
									<?php
									the_post_thumbnail(
										'origamiez-square-m',
										array( 'class' => 'image-effect img-responsive' )
									);
									?>
								</a>
							<?php endif; ?>
							<p class="metadata">
								<?php get_template_part( 'parts/metadata/author' ); ?>
								<?php get_template_part( 'parts/metadata/date' ); ?>
								<?php get_template_part( 'parts/metadata/divider' ); ?>
								<?php get_template_part( 'parts/metadata/comments' ); ?>
							</p>
							<h3>
								<a class="entry-title"
									href="<?php echo esc_url( $post_url ); ?>"
									title="<?php echo esc_attr( $post_title ); ?>">
									<?php echo esc_html( $post_title ); ?>
								</a>
							</h3>
							<?php
							$excerpt_callback = origamiez_get_value_callback( 20 );
							add_filter( 'excerpt_length', $excerpt_callback );
							?>
							<p class="entry-excerpt clearfix"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
							<?php remove_filter( 'excerpt_length', $excerpt_callback ); ?>
						</article>
						<?php
						echo '</div>';
						echo '<div class="article-col-right col-sm-6 col-xs-12">';
					else :
						?>
						<article <?php post_class( $post_classes ); ?>>
							<p class="metadata">
								<?php get_template_part( 'parts/metadata/author' ); ?>
								<?php get_template_part( 'parts/metadata/date' ); ?>
								<?php get_template_part( 'parts/metadata/divider' ); ?>
								<?php get_template_part( 'parts/metadata/comments' ); ?>
							</p>
							<h5>
								<a class="entry-title"
									href="<?php echo esc_url( $post_url ); ?>"
									title="<?php echo esc_attr( $post_title ); ?>">
									<?php echo esc_html( $post_title ); ?>
								</a>
							</h5>
						</article>
						<?php
					endif;
					++$loop_index;
				endwhile;
				?>
			</div>
			</div>
		</div>
	</div>
	<?php
endif;
wp_reset_postdata();
