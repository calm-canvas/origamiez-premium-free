<?php
/**
 * Posts List With Background Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsListTypeCWidget;
use WP_Query;

/**
 * Class PostsListWithBackgroundWidget
 */
class PostsListWithBackgroundWidget extends AbstractPostsListTypeCWidget {

	/**
	 * Widget id, labels, and body class for WP_Widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function widget_registration_config(): array {
		return static::make_widget_registration(
			'origamiez-widget-posts-with-background',
			esc_attr__( 'Origamiez Posts List With Background Color', 'origamiez' ),
			'origamiez-widget-posts-with-background',
			esc_attr__( 'Display posts list with background color.', 'origamiez' )
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

		$loop_index       = 1;
		$col_left_classes = $d['excerpt_words_limit'] ? 'col-sm-6' : 'col-sm-12';
		while ( $posts->have_posts() ) :
			$posts->the_post();
			$post_title   = get_the_title();
			$post_url     = get_permalink();
			$post_classes = array( 'origamiez-wp-post', 'clearfix' );
			if ( 1 === $loop_index ) {
				$post_classes[] = 'origamiez-wp-post-first';
			}
			?>
			<article <?php post_class( $post_classes ); ?>>
				<div class="row">
					<div class="origamiez-wp-post-title col-xs-12 <?php echo esc_attr( $col_left_classes ); ?>">
						<span class="origamiez-wp-post-index pull-left"><?php echo esc_html( $loop_index ); ?></span>
						<h4 class="entry-title clearfix">
							<a href="<?php echo esc_url( $post_url ); ?>"
								title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_html( $post_title ); ?></a>
						</h4>
						<?php $this->print_metadata( $d['is_show_date'], $d['is_show_comments'], $d['is_show_author'], 'metadata' ); ?>
					</div>
					<?php
					if ( $d['excerpt_words_limit'] ) :
						?>
						<div class="origamiez-wp-post-detail col-xs-12 col-sm-6">
							<?php $this->print_excerpt( $d['excerpt_words_limit'], 'entry-excerpt clearfix' ); ?>
						</div>
						<?php
					endif;
					?>
				</div>
			</article>
			<?php
			++$loop_index;
		endwhile;
	}
}
