<?php
/**
 * Search
 *
 * @package Origamiez
 */

get_header(); ?>
	<div id="sidebar-center" class="origamiez-size-01 pull-left">
		<?php origamiez_get_breadcrumb(); ?>
		<div class="clearfix"></div>
		<div id="sidebar-center-bottom" class="row clearfix">
			<ul id="origamiez-blogposts">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<li <?php post_class( array( 'clearfix' ) ); ?>>
							<article class="entry-item row clearfix">
								<div class="entry-summary col-sm-12">
									<h3 class="clearfix">
										<a href="<?php the_permalink(); ?>"
											class="entry-content"><?php the_title(); ?></a>
									</h3>
									<?php get_template_part( 'parts/metadata/taxonomy-loop' ); ?>
									<div class="entry-content"><?php the_excerpt(); ?></div>
								</div>
							</article>
						</li>
						<?php
					endwhile;
				else :
					get_template_part( 'content', 'none' );
				endif;
				?>
			</ul>
			<?php get_template_part( 'pagination' ); ?>
		</div>
	</div>
<?php get_template_part( 'parts/sidebar', 'right' ); ?>
	<div class="clearfix"></div>
<?php

get_footer();
