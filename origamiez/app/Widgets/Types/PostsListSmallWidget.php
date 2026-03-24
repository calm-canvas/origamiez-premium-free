<?php
/**
 * Posts List Small Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsListTypeCWidget;
use WP_Query;

/**
 * Class PostsListSmallWidget
 */
class PostsListSmallWidget extends AbstractPostsListTypeCWidget {

	/**
	 * Registration for the small-thumbnail posts list widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function widget_registration_config(): array {
		return static::make_widget_registration(
			'origamiez-widget-post-list-small',
			esc_attr__( 'Origamiez Posts List Small', 'origamiez' ),
			'origamiez-widget-posts-small-thumbnail',
			esc_attr__( 'Display posts list with small thumbnail.', 'origamiez' )
		);
	}

	/**
	 * Delegates to the small-thumbnail markup loop.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	protected function render_posts_list_markup( WP_Query $posts, array $instance ): void {
		$this->render_small_thumbnail_loop( $posts, $instance );
	}

	/**
	 * Small thumbnail + excerpt loop.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	private function render_small_thumbnail_loop( WP_Query $posts, array $instance ): void {
		$d = $this->get_post_list_display_vars( $instance );

		$loop_index = 0;
		while ( $posts->have_posts() ) :
			$posts->the_post();
			$post_title   = get_the_title();
			$post_url     = get_permalink();
			$post_classes = array( 'origamiez-wp-mt-post', 'clearfix' );
			if ( 0 === $loop_index ) {
				$post_classes[] = 'origamiez-wp-mt-post-first';
			}
			?>
			<div <?php post_class( $post_classes ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php echo esc_url( $post_url ); ?>" title="<?php echo esc_attr( $post_title ); ?>"
						class="link-hover-effect origamiez-post-thumb pull-left">
						<?php the_post_thumbnail( 'origamiez-square-xs', array( 'class' => 'image-effect img-responsive' ) ); ?>
					</a>
				<?php endif; ?>
				<div class="origamiez-wp-mt-post-detail">
					<h4>
						<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>"
							title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_html( $post_title ); ?></a>
					</h4>
					<?php $this->print_metadata( $d['is_show_date'], $d['is_show_comments'], $d['is_show_author'], 'metadata' ); ?>
					<?php $this->print_excerpt( $d['excerpt_words_limit'], 'entry-excerpt clearfix' ); ?>
				</div>
			</div>
			<?php
			++$loop_index;
		endwhile;
	}
}
