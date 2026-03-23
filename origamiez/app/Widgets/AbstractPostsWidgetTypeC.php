<?php
/**
 * Abstract Posts Widget Type C
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets;

use WP_Query;

/**
 * Class AbstractPostsWidgetTypeC
 */
abstract class AbstractPostsWidgetTypeC extends AbstractPostsWidgetTypeB {

	/**
	 * Output grid rows for the posts grid widget (shared by PSR-4 and legacy widget classes).
	 *
	 * @param WP_Query $posts    Query with posts to render.
	 * @param array    $instance Widget instance (expects cols_per_row and excerpt fields).
	 */
	protected function render_posts_grid_widget_content( WP_Query $posts, array $instance ): void {
		if ( ! $posts->have_posts() ) {
			return;
		}
		?>
		<div class="o_grid row row-first cleardix">
			<?php
			$cols_per_row = (int) $instance['cols_per_row'];
			$post_classes = array( 'origamiez-wp-grid-post', 'col-xs-12' );
			$image_size   = 'origamiez-grid-l';
			switch ( $cols_per_row ) {
				case 4:
					$post_classes[] = 'col-sm-3';
					break;
				case 6:
					$post_classes[] = 'col-sm-2';
					break;
				default:
					$post_classes[] = 'col-sm-4';
					break;
			}
			$is_show_date        = $instance['is_show_date'];
			$is_show_comments    = $instance['is_show_comments'];
			$is_show_author      = $instance['is_show_author'];
			$excerpt_words_limit = $instance['excerpt_words_limit'];

			$loop_index = 0;
			while ( $posts->have_posts() ) :
				$posts->the_post();
				$post_title = get_the_title();
				$post_url   = get_permalink();
				$classes    = $post_classes;
				if ( $loop_index && ( 0 === $loop_index % $cols_per_row ) ) {
					echo '</div><div class="o_grid row cleardix">';
					$classes[] = 'o_item origamiez-wp-grid-post-first';
				} else {
					$classes[] = 'o_item origamiez-wp-grid-post-last';
				}
				?>
				<article <?php post_class( $classes ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url( $post_url ); ?>" title="<?php echo esc_attr( $post_title ); ?>"
							class="link-hover-effect origamiez-post-thumb">
							<?php the_post_thumbnail( $image_size, array( 'class' => 'image-effect img-responsive' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="origamiez-wp-grid-detail clearfix">
						<h4>
							<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>"
								title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_html( $post_title ); ?></a>
						</h4>
						<?php $this->print_metadata( $is_show_date, $is_show_comments, $is_show_author, 'metadata' ); ?>
						<?php $this->print_excerpt( $excerpt_words_limit, 'entry-excerpt clearfix' ); ?>
					</div>
				</article>
				<?php
				++$loop_index;
			endwhile;
			?>
		</div>
		<?php
	}

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance           = parent::update( $new_instance, $old_instance );
		$instance['offset'] = isset( $new_instance['offset'] ) ? (int) $new_instance['offset'] : 0;
		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		$offset   = $instance['offset'];
		parent::form( $instance );
		?>
		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" value="<?php echo esc_attr( $offset ); ?>"/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset. Number of post to displace or pass over.', 'origamiez' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default(): array {
		$default           = parent::get_default();
		$default['offset'] = 0;
		return $default;
	}

	/**
	 * Get query.
	 *
	 * @param array $instance Widget instance.
	 * @param array $args_extra Extra arguments.
	 * @return array
	 */
	public function get_query( $instance, $args_extra = array() ): array {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		$offset   = $instance['offset'];

		$args = parent::get_query( $instance, $args_extra );

		if ( $offset ) {
			$args['offset'] = $offset;
		}

		return $args;
	}
}
