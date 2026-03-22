<?php
/**
 * Origamiez Social Links Widget
 *
 * @package Origamiez
 */

add_action( 'widgets_init', array( 'Origamiez_Widget_Social_Links', 'register' ) );

/**
 * Class Origamiez_Widget_Social_Links
 */
class Origamiez_Widget_Social_Links extends WP_Widget {
	/**
	 * Register widget
	 */
	public static function register(): void {
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
	 * Update widget
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance          = $old_instance;
		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Widget output
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
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
				foreach ( $socials as $social_slug => $social ) {
					$this->render_widget_social_link( $social_slug, $social );
				}
				?>
			</div>
			<?php
		endif;
		echo wp_kses( $args['after_widget'], origamiez_get_allowed_tags() );
	}

	/**
	 * Render a single configured social link.
	 *
	 * @param string $social_slug Social key.
	 * @param array  $social      Social config.
	 */
	private function render_widget_social_link( string $social_slug, array $social ): void {
		$url   = get_theme_mod( "{$social_slug}_url", '' );
		$color = get_theme_mod( "{$social_slug}_color", $social['color'] );
		if ( ! $url ) {
			return;
		}
		$style = '';
		if ( $color ) {
			$style = sprintf( 'color:#FFF; background-color:%1$s; border-color: %1$s;', $color );
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
	}

	/**
	 * Widget form
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
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
	 * Get default settings
	 *
	 * @return array
	 */
	protected function get_default(): array {
		return array(
			'title' => esc_attr__( 'Social Links', 'origamiez' ),
		);
	}
}
