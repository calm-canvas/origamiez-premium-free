<?php
/**
 * Posts List Slider Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsWidgetTypeB;
use WP_Query;

/**
 * Class PostsListSliderWidget
 */
class PostsListSliderWidget extends AbstractPostsWidgetTypeB {
	/**
	 * Register widget.
	 */
	public static function register(): void {
		register_widget( __CLASS__ );
	}

	/**
	 * PostsListSliderWidget constructor.
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'origamiez-widget-posts-slider',
			'description' => esc_attr__( 'Display a slider with three blocks: two static small blocks and one dynamic carousel block.', 'origamiez' ),
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( 'origamiez-widget-posts-slider', esc_attr__( 'Origamiez Posts Slider', 'origamiez' ), $widget_ops, $control_ops );
	}

	/**
	 * Render widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
		$instance                = wp_parse_args( (array) $instance, $this->get_default() );
		$is_assign_last_to_small = $instance['is_assign_last_to_small'];
		$title                   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( 1 === (int) $is_assign_last_to_small ) {
			$this->get_layout_last_to_small( $args, $instance );
		} else {
			$this->get_layout_default( $args, $instance );
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance                            = parent::update( $new_instance, $old_instance );
		$instance['is_assign_last_to_small'] = isset( $new_instance['is_assign_last_to_small'] ) ? 1 : 0;

		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		parent::form( $instance );
		$instance                = wp_parse_args( (array) $instance, $this->get_default() );
		$is_assign_last_to_small = $instance['is_assign_last_to_small'];
		?>
		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'is_assign_last_to_small' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'is_assign_last_to_small' ) ); ?>" type="checkbox"
					value="1" <?php checked( 1, (int) $is_assign_last_to_small, true ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_assign_last_to_small' ) ); ?>"><?php esc_html_e( 'Is assign two last posts to small box ?', 'origamiez' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Get layout default.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	protected function get_layout_default( $args, $instance ): void {
		$query = $this->get_query( $instance );

		echo '<div class="row g-0 clearfix">';

		// 1. Left Column: 2 Static Small Posts.
		$posts_small = new WP_Query( array_merge( $query, array( 'posts_per_page' => 2 ) ) );
		if ( $posts_small->have_posts() ) :
			?>
			<div class="col-sm-4 col-4 col-left" style="width: 33.3333% !important; flex: 0 0 33.3333% !important; max-width: 33.3333% !important;">
				<div class="d-flex flex-column h-100" style="aspect-ratio: auto !important;">
					<?php
					$is_first = true;
					while ( $posts_small->have_posts() ) :
						$posts_small->the_post();
						$this->render_post_item( $instance, $is_first ? 'top' : 'bottom' );
						$is_first = false;
					endwhile;
					?>
				</div>
			</div>
			<?php
		endif;
		wp_reset_postdata();

		// 2. Right Column: Carousel Posts.
		$posts_carousel = new WP_Query(
			array_merge(
				$query,
				array(
					'offset'         => 2,
					'posts_per_page' => (int) $instance['posts_per_page'] - 2,
				)
			)
		);
		if ( $posts_carousel->have_posts() ) :
			?>
			<div class="col-sm-8 col-8 col-right" style="width: 66.6666% !important; flex: 0 0 66.6666% !important; max-width: 66.6666% !important;">
				<div class="owl-carousel owl-theme h-100">
					<?php
					while ( $posts_carousel->have_posts() ) :
						$posts_carousel->the_post();
						$this->render_post_item( $instance, 'carousel' );
					endwhile;
					?>
				</div>
			</div>
			<?php
		endif;
		wp_reset_postdata();

		echo '</div>';
	}

	/**
	 * Get layout last to small.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	protected function get_layout_last_to_small( $args, $instance ): void {
		$query = $this->get_query( $instance );

		$all_posts  = new WP_Query( $query );
		$post_count = $all_posts->post_count;
		wp_reset_postdata();

		if ( $post_count < 3 ) {
			$this->get_layout_default( $args, $instance );
			return;
		}

		echo '<div class="row g-0 clearfix">';

		$offset = $post_count - 2;

		// 1. Left Column: 2 Last Posts.
		$posts_small = new WP_Query(
			array_merge(
				$query,
				array(
					'offset'         => $offset,
					'posts_per_page' => 2,
				)
			)
		);
		if ( $posts_small->have_posts() ) :
			?>
			<div class="col-sm-4 col-4 col-left" style="width: 33.3333% !important; flex: 0 0 33.3333% !important; max-width: 33.3333% !important;">
				<div class="d-flex flex-column h-100" style="aspect-ratio: auto !important;">
					<?php
					$is_first = true;
					while ( $posts_small->have_posts() ) :
						$posts_small->the_post();
						$this->render_post_item( $instance, $is_first ? 'top' : 'bottom' );
						$is_first = false;
					endwhile;
					?>
				</div>
			</div>
			<?php
		endif;
		wp_reset_postdata();

		// 2. Right Column: First Posts in Carousel.
		$posts_carousel = new WP_Query( array_merge( $query, array( 'posts_per_page' => $offset ) ) );
		if ( $posts_carousel->have_posts() ) :
			?>
			<div class="col-sm-8 col-8 col-right" style="width: 66.6666% !important; flex: 0 0 66.6666% !important; max-width: 66.6666% !important;">
				<div class="owl-carousel owl-theme h-100">
					<?php
					while ( $posts_carousel->have_posts() ) :
						$posts_carousel->the_post();
						$this->render_post_item( $instance, 'carousel' );
					endwhile;
					?>
				</div>
			</div>
			<?php
		endif;
		wp_reset_postdata();

		echo '</div>';
	}

	/**
	 * Helper to render a single post item.
	 *
	 * @param array  $instance Widget instance settings.
	 * @param string $type     Type of post item ('top', 'bottom', 'carousel').
	 */
	private function render_post_item( array $instance, string $type ): void {
		if ( ! has_post_thumbnail() ) {
			return;
		}

		$is_small            = in_array( $type, array( 'top', 'bottom' ), true );
		$is_show_date        = $instance['is_show_date'];
		$is_show_comments    = $instance['is_show_comments'];
		$is_show_author      = $instance['is_show_author'];
		$excerpt_words_limit = $instance['excerpt_words_limit'];

		$post_title = get_the_title();
		$post_url   = get_permalink();

		if ( $is_small ) :
			$margin_top = ( 'bottom' === $type ) ? '5px' : '0';
			?>
			<div class="item-outer flex-grow-1" style="margin-top: <?php echo esc_attr( $margin_top ); ?>; overflow: hidden; position: relative;">
				<article <?php post_class( array( 'item', 'item-' . $type, 'h-100' ) ); ?> style="margin-top: 0 !important;">
					<?php the_post_thumbnail( 'origamiez-posts-slide-metro', array( 'class' => 'img-responsive w-100 h-100', 'style' => 'object-fit: cover;' ) ); ?>
					<div class="caption">
						<h5>
							<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>" title="<?php echo esc_attr( $post_title ); ?>">
								<?php echo esc_html( $post_title ); ?>
							</a>
						</h5>
						<?php $this->print_metadata( $is_show_date, $is_show_comments, $is_show_author, 'metadata clearfix hidden' ); ?>
						<?php $this->print_excerpt( $excerpt_words_limit, 'entry-excerpt clearfix hidden' ); ?>
					</div>
				</article>
			</div>
			<?php
		else :
			?>
			<article <?php post_class( 'item h-100' ); ?>>
				<?php the_post_thumbnail( 'origamiez-posts-slide-metro', array( 'class' => 'img-responsive w-100 h-100', 'style' => 'object-fit: cover;' ) ); ?>
				<div class="caption">
					<h2>
						<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>" title="<?php echo esc_attr( $post_title ); ?>">
							<?php echo esc_html( $post_title ); ?>
						</a>
					</h2>
					<?php $this->print_metadata( $is_show_date, $is_show_comments, $is_show_author, 'metadata clearfix' ); ?>
					<?php $this->print_excerpt( $excerpt_words_limit, 'entry-excerpt clearfix' ); ?>
				</div>
			</article>
			<?php
		endif;
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default(): array {
		$default                            = parent::get_default();
		$default['is_assign_last_to_small'] = 0;

		return $default;
	}
}
