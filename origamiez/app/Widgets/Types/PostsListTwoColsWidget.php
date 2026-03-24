<?php
/**
 * Posts List Two Cols Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsListTypeCWidget;
use WP_Query;

/**
 * Class PostsListTwoColsWidget
 */
class PostsListTwoColsWidget extends AbstractPostsListTypeCWidget {

	/**
	 * Widget id, labels, and body class for WP_Widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function widget_registration_config(): array {
		return static::make_widget_registration(
			'origamiez-widget-posts-two-cols',
			esc_attr__( 'Origamiez Posts List Two Cols', 'origamiez' ),
			'origamiez-widget-posts-two-cols',
			esc_attr__( 'Display posts list with layout two cols.', 'origamiez' )
		);
	}

	/**
	 * Print the posts markup for this widget layout.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	protected function render_posts_list_markup( WP_Query $posts, array $instance ): void {
		$d = $this->get_post_list_display_vars( $instance );

		?>
		<div class="row">
			<div class="article-col-left col-sm-6 col-xs-12">
				<?php
				$loop_index = 0;
				while ( $posts->have_posts() ) :
					$posts->the_post();
					$post_title   = get_the_title();
					$post_url     = get_permalink();
					$post_classes = "origamiez-post-{$loop_index} clearfix";
					if ( 0 === $loop_index ) :
						?>
						<article <?php post_class( $post_classes ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a class="link-hover-effect origamiez-post-thumb" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'origamiez-square-m', array( 'class' => 'image-effect img-responsive' ) ); ?>
								</a>
							<?php endif; ?>
							<?php $this->print_metadata( $d['is_show_date'], $d['is_show_comments'], $d['is_show_author'], 'metadata clearfix' ); ?>
							<h3>
								<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>"
									title="<?php echo esc_attr( $post_title ); ?>">
									<?php echo esc_attr( $post_title ); ?>
								</a>
							</h3>
							<?php $this->print_excerpt( $d['excerpt_words_limit'], 'entry-excerpt clearfix' ); ?>
						</article>
						<?php
						echo '</div>';
						echo '<div class="article-col-right col-sm-6 col-xs-12">';
					else :
						?>
						<article <?php post_class( $post_classes ); ?>>
							<?php $this->print_metadata( $d['is_show_date'], $d['is_show_comments'], $d['is_show_author'], 'metadata clearfix' ); ?>
							<h4>
								<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>"
									title="<?php echo esc_attr( $post_title ); ?>">
									<?php echo esc_attr( $post_title ); ?>
								</a>
							</h4>
						</article>
						<?php
					endif;
					++$loop_index;
				endwhile;
				?>
			</div>
		</div>
		<?php
	}
}
