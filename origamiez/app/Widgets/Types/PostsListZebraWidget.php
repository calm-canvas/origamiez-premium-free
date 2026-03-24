<?php
/**
 * Posts List Zebra Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsListTypeCWidget;
use WP_Query;

/**
 * Class PostsListZebraWidget
 */
class PostsListZebraWidget extends AbstractPostsListTypeCWidget {

	/**
	 * Registration for the zebra-striped posts list widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function widget_registration_config(): array {
		return static::make_widget_registration(
			'origamiez-widget-post-list-zebra',
			esc_attr__( 'Origamiez Posts List Zebra', 'origamiez' ),
			'origamiez-widget-posts-zebra',
			esc_attr__( 'Display posts list like a zebra.', 'origamiez' )
		);
	}

	/**
	 * Delegates to the zebra-striped markup loop.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	protected function render_posts_list_markup( WP_Query $posts, array $instance ): void {
		$this->render_zebra_striped_loop( $posts, $instance );
	}

	/**
	 * Alternating even/odd row styling without thumbnails.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	private function render_zebra_striped_loop( WP_Query $posts, array $instance ): void {
		$d = $this->get_post_list_display_vars( $instance );

		$row = 1;
		while ( $posts->have_posts() ) :
			$posts->the_post();
			$post_title   = get_the_title();
			$post_url     = get_permalink();
			$post_classes = array( 'origamiez-wp-zebra-post', 'clearfix' );
			if ( 1 === $row ) {
				$post_classes[] = 'origamiez-wp-zebra-post-first';
			}
			$post_classes[] = ( 0 === $row % 2 ) ? 'even' : 'odd';
			?>
			<article <?php post_class( $post_classes ); ?>>
				<div class="origamiez-wp-mt-post-detail">
					<h4>
						<a href="<?php echo esc_url( $post_url ); ?>"
							title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_html( $post_title ); ?></a>
					</h4>
					<?php $this->print_metadata( $d['is_show_date'], $d['is_show_comments'], $d['is_show_author'], 'metadata' ); ?>
					<?php $this->print_excerpt( $d['excerpt_words_limit'], 'entry-excerpt clearfix' ); ?>
				</div>
			</article>
			<?php
			++$row;
		endwhile;
	}
}
