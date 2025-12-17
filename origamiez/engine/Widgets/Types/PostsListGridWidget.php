<?php
/**
 * Posts List Grid Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets\Types;

use Origamiez\Engine\Widgets\AbstractPostsWidgetTypeC;
use WP_Query;

/**
 * Class PostsListGridWidget
 */
class PostsListGridWidget extends AbstractPostsWidgetTypeC {
	/**
	 * Register widget.
	 */
	public static function register(): void {
		register_widget( __CLASS__ );
	}

	/**
	 * PostsListGridWidget constructor.
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'origamiez-widget-posts-grid',
			'description' => esc_attr__( 'Display posts grid with small thumbnail.', 'origamiez' ),
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( 'origamiez-widget-post-grid', esc_attr__( 'Origamiez Posts Grid', 'origamiez' ), $widget_ops, $control_ops );
	}

	/**
	 * Render widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
		$instance            = wp_parse_args( (array) $instance, $this->get_default() );
		$before_widget       = $args['before_widget'];
		$after_widget        = $args['after_widget'];
		$before_title        = $args['before_title'];
		$after_title         = $args['after_title'];
		$is_show_date        = $instance['is_show_date'];
		$is_show_comments    = $instance['is_show_comments'];
		$is_show_author      = $instance['is_show_author'];
		$excerpt_words_limit = $instance['excerpt_words_limit'];

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo wp_kses( $before_widget, origamiez_get_allowed_tags() );
		if ( ! empty( $title ) ) {
			echo wp_kses( $before_title . $title . $after_title, origamiez_get_allowed_tags() );
		}
		$query = $this->get_query( $instance );
		$posts = new WP_Query( $query );
		if ( $posts->have_posts() ) :
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
							<?php parent::print_metadata( $is_show_date, $is_show_comments, $is_show_author, 'metadata' ); ?>
							<?php parent::print_excerpt( $excerpt_words_limit, 'entry-excerpt clearfix' ); ?>
						</div>
					</article>
					<?php
					++$loop_index;
				endwhile;
				?>
			</div>
			<?php
		endif;
		wp_reset_postdata();
		echo wp_kses( $after_widget, origamiez_get_allowed_tags() );
	}

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance                 = parent::update( $new_instance, $old_instance );
		$instance['cols_per_row'] = (int) esc_attr( $new_instance['cols_per_row'] );

		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		parent::form( $instance );
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cols_per_row' ) ); ?>"><?php esc_html_e( 'Cols per row:', 'origamiez' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cols_per_row' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cols_per_row' ) ); ?>">
				<?php
				$cols = array( 3, 4, 6 );
				foreach ( $cols as $col ) {
					?>
					<option value="<?php echo esc_attr( $col ); ?>" <?php selected( $instance['cols_per_row'], $col ); ?>><?php echo esc_html( $col ); ?></option>
					<?php
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default(): array {
		$default                 = parent::get_default();
		$default['cols_per_row'] = 3;

		return $default;
	}
}
