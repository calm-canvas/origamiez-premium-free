<?php
/**
 * Title: Posts Grid
 * Slug: origamiez/posts-grid
 * Categories: origamiez, query
 * Keywords: grid, posts, query
 *
 * @package Origamiez
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<div class="origamiez-widget-posts-grid">
		<?php
		$args  = array(
			'posts_per_page'      => 6,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) :
			?>
			<div class="o_grid row row-first clearfix">
				<?php
				$cols_per_row = 3;
				$loop_index   = 0;
				while ( $query->have_posts() ) :
					$query->the_post();
					if ( $loop_index > 0 && ( 0 === $loop_index % $cols_per_row ) ) {
						echo '</div><div class="o_grid row clearfix">';
					}
					?>
					<article <?php post_class( 'origamiez-wp-grid-post col-xs-12 col-sm-4' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
								class="link-hover-effect origamiez-post-thumb">
								<?php the_post_thumbnail( 'origamiez-grid-l', array( 'class' => 'image-effect img-responsive' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="origamiez-wp-grid-detail clearfix">
							<h4>
								<a class="entry-title" href="<?php the_permalink(); ?>"
									title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h4>
							<p class="metadata">
								<?php get_template_part( 'parts/metadata/date' ); ?>
								<?php get_template_part( 'parts/metadata/divider' ); ?>
								<?php get_template_part( 'parts/metadata/comments' ); ?>
							</p>
						</div>
					</article>
					<?php
					++$loop_index;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
