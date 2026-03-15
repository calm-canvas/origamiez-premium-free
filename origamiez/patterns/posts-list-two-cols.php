<?php
/**
 * Title: Post List TwoCols
 * Slug: origamiez/posts-list-two-cols
 * Categories: origamiez, query
 * Description: One featured post on the left and a list of post titles on the right.
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
<div class="origamiez-widget-posts-two-cols">
	<?php if ( $query->have_posts() ) : ?>
		<div class="row">
			<?php
			$loop_index = 0;
			while ( $query->have_posts() ) :
				$query->the_post();
				if ( 0 === $loop_index ) :
					?>
				<div class="article-col-left col-sm-6 col-xs-12">
					<article <?php post_class( 'origamiez-post-0 clearfix' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="link-hover-effect origamiez-post-thumb" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'origamiez-square-m', array( 'class' => 'image-effect img-responsive' ) ); ?>
							</a>
						<?php endif; ?>
						<p class="metadata clearfix">
							<?php get_template_part( 'parts/metadata/date' ); ?>
							<?php get_template_part( 'parts/metadata/divider' ); ?>
							<?php get_template_part( 'parts/metadata/comments' ); ?>
						</p>
						<h3>
							<a class="entry-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>
					</article>
				</div>
				<div class="article-col-right col-sm-6 col-xs-12">
			<?php else : ?>
				<article <?php post_class( "origamiez-post-{$loop_index} clearfix" ); ?>>
					<p class="metadata clearfix">
						<?php get_template_part( 'parts/metadata/date' ); ?>
					</p>
					<h4>
						<a class="entry-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_title(); ?>
						</a>
					</h4>
				</article>
				<?php
				endif;
				++$loop_index;
			endwhile;
			wp_reset_postdata();
			?>
			</div>
		</div>
	<?php endif; ?>
</div>
