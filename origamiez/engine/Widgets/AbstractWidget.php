<?php
/**
 * Abstract Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

/**
 * Class AbstractWidget
 */
abstract class AbstractWidget extends \WP_Widget {

	/**
	 * Widget ID.
	 *
	 * @var string
	 */
	protected string $widget_id;

	/**
	 * Widget name.
	 *
	 * @var string
	 */
	protected string $widget_name;

	/**
	 * Widget description.
	 *
	 * @var string
	 */
	protected string $widget_description = '';

	/**
	 * Default settings.
	 *
	 * @var array
	 */
	protected array $default_settings = array();

	/**
	 * AbstractWidget constructor.
	 *
	 * @param string $id Widget ID.
	 * @param string $name Widget name.
	 * @param string $description Widget description.
	 * @param array  $settings Widget settings.
	 */
	public function __construct( string $id, string $name, string $description = '', array $settings = array() ) {
		$this->widget_id          = $id;
		$this->widget_name        = $name;
		$this->widget_description = $description;
		$this->default_settings   = $settings;

		parent::__construct(
			$id,
			$name,
			array(
				'description'                 => $description,
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Render widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] );
		}

		$this->render_content( $instance );

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Render content.
	 *
	 * @param array $instance Widget instance.
	 */
	abstract protected function render_content( array $instance ): void;

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		$instance = wp_parse_args( $instance, $this->get_default_settings() );

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'origamiez' ) . '</label>';
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $instance['title'] ) . '" />';
		echo '</p>';

		$this->render_form_fields( $instance );
	}

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance          = array();
		$instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $this->sanitize_instance( $new_instance, $instance );
	}

	/**
	 * Render form fields.
	 *
	 * @param array $instance Widget instance.
	 */
	protected function render_form_fields( array $instance ): void {
	}

	/**
	 * Sanitize instance.
	 *
	 * @param array $new_instance New instance.
	 * @param array $instance Instance.
	 * @return array
	 */
	protected function sanitize_instance( array $new_instance, array $instance ): array {
		return $instance;
	}

	/**
	 * Get default settings.
	 *
	 * @return array
	 */
	protected function get_default_settings(): array {
		return array_merge(
			array( 'title' => '' ),
			$this->default_settings
		);
	}
}
