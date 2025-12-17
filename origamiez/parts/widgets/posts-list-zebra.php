<?php
/**
 * Widget to display posts list like a zebra.
 *
 * @package Origamiez
 */

add_action( 'widgets_init', array( 'Origamiez_Widget_Posts_List_Zebra', 'register' ) );

/**
 * Class Origamiez_Widget_Posts_List_Zebra
 */
class Origamiez_Widget_Posts_List_Zebra extends Origamiez_Posts_Widget_Type_C {
	/**
	 * Register the widget.
	 */
	public static function register() {
		register_widget( 'Origamiez_Widget_Posts_List_Zebra' );
	}

	/**
	 * Origamiez_Widget_Posts_List_Zebra constructor.
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'origamiez-widget-posts-zebra',
			'description' => esc_attr__( 'Display posts list like a zebra.', 'origamiez' ),
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( 'origamiez-widget-post-list-zebra', esc_attr__( 'Origamiez Posts List Zebra', 'origamiez' ), $widget_ops, $control_ops );
	}

	/**
	 * Display the widget.
	 *
	 * @param array $args     The arguments.
	 * @param array $instance The instance.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		$title    = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo wp_kses( $args['before_widget'], origamiez_get_allowed_tags() );
		if ( ! empty( $title ) ) {
			echo wp_kses( $args['before_title'] . $title . $args['after_title'], origamiez_get_allowed_tags() );
		}
		$query = $this->get_query( $instance );
		$posts = new WP_Query( $query );
		if ( $posts->have_posts() ) :
			?>
			<?php
			$loop_index = 1;
			while ( $posts->have_posts() ) :
				$posts->the_post();
				$post_title   = get_the_title();
				$post_url     = get_permalink();
				$post_classes = array( 'origamiez-wp-zebra-post', 'clearfix' );
				if ( 1 === $loop_index ) {
					$post_classes[] = 'origamiez-wp-zebra-post-first';
				}
				$post_classes[] = ( 0 === $loop_index % 2 ) ? 'even' : 'odd';
				?>
				<article <?php post_class( $post_classes ); ?>>
					<div class="origamiez-wp-mt-post-detail">
						<h4>
							<a href="<?php echo esc_url( $post_url ); ?>"
								title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_html( $post_title ); ?></a>
						</h4>
						<?php
						parent::print_metadata(
							$instance['is_show_date'],
							$instance['is_show_comments'],
							$instance['is_show_author'],
							'metadata'
						);
						parent::print_excerpt( $instance['excerpt_words_limit'], 'entry-excerpt clearfix' );
						?>
					</div>
				</article>
				<?php
				++$loop_index;
			endwhile;
			?>
			<?php
		endif;
		wp_reset_postdata();
		echo wp_kses( $args['after_widget'], origamiez_get_allowed_tags() );
	}
}
