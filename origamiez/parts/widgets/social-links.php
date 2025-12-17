<?php
/**
 * Widget to display social links.
 *
 * @package Origamiez
 */

add_action( 'widgets_init', array( 'Origamiez_Widget_Social_Links', 'register' ) );

/**
 * Class Origamiez_Widget_Social_Links
 */
class Origamiez_Widget_Social_Links extends WP_Widget {
	/**
	 * Register the widget.
	 */
	public static function register() {
		register_widget( 'Origamiez_Widget_Social_Links' );
	}

	/**
	 * Origamiez_Widget_Social_Links constructor.
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'origamiez-widget-social-links',
			'description' => esc_attr__( 'Display your social links. Config on Appearance >> Customize.', 'origamiez' ),
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( 'origamiez-widget-social-links', esc_attr__( 'Origamiez Social Links', 'origamiez' ), $widget_ops, $control_ops );
	}

	/**
	 * Update the widget.
	 *
	 * @param array $new_instance The new instance.
	 * @param array $old_instance The old instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );

		return $instance;
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
		$socials = origamiez_get_socials();
		if ( ! empty( $socials ) ) :
			?>
			<div class="social-link-inner clearfix">
				<?php
				foreach ( $socials as $social_slug => $social ) :
					$url   = get_theme_mod( "{$social_slug}_url", '' );
					$color = get_theme_mod( "{$social_slug}_color", $social['color'] );
					if ( $url ) :
						$style = '';
						if ( $color ) {
							$style = sprintf( 'color:#FFF; background-color:%1$s; border-color: %1$s;', $color );
						}
						if ( 'fa fa-rss' === $social['icon'] && empty( $url ) ) {
							$url = get_bloginfo( 'rss2_url' );
						}
						?>
						<a href="<?php echo esc_url( $url ); ?>"
							data-bs-placement="top"
							data-bs-toggle="tooltip"
							title="<?php echo esc_attr( $social['label'] ); ?>"
							rel="nofollow"
							target="_blank"
							class="social-link social-link-first" style="<?php echo esc_attr( $style ); ?>">
							<span class="<?php echo esc_attr( $social['icon'] ); ?>"></span>
						</a>
						<?php
					endif;
				endforeach;
				?>
			</div>
			<?php
		endif;
		echo wp_kses( $args['after_widget'], origamiez_get_allowed_tags() );
	}

	/**
	 * Display the widget form.
	 *
	 * @param array $instance The instance.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'origamiez' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
					value="<?php echo esc_attr( wp_strip_all_tags( $instance['title'] ) ); ?>"/>
		</p>
		<?php
	}

	/**
	 * Get the default values.
	 *
	 * @return array
	 */
	protected function get_default() {
		return array(
			'title' => esc_attr__( 'Social Links', 'origamiez' ),
		);
	}
}
