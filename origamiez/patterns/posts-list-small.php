<?php
/**
 * Title: Post List Small
 * Slug: origamiez/posts-list-small
 * Categories: origamiez, sidebar, query
 * Description: A list of posts with small thumbnails, ideal for sidebars.
 *
 * @package Origamiez
 */

$args = array(
	'posts_per_page'      => 5,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);

$query = new WP_Query( $args );
?>
<div class="origamiez-widget-posts-small-thumbnail">
	<?php if ( $query->have_posts() ) : ?>
		<div class="origamiez-posts-small-list">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
				<div <?php post_class( 'origamiez-wp-mt-post clearfix' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
							class="link-hover-effect origamiez-post-thumb pull-left">
							<?php the_post_thumbnail( 'origamiez-square-xs', array( 'class' => 'image-effect img-responsive' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="origamiez-wp-mt-post-detail">
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
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	<?php endif; ?>
</div>
