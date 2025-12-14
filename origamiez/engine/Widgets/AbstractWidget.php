<?php

namespace Origamiez\Engine\Widgets;

abstract class AbstractWidget extends \WP_Widget {

	protected string $widgetId;
	protected string $widgetName;
	protected string $widgetDescription = '';
	protected array $defaultSettings = [];

	public function __construct( string $id, string $name, string $description = '', array $settings = [] ) {
		$this->widgetId = $id;
		$this->widgetName = $name;
		$this->widgetDescription = $description;
		$this->defaultSettings = $settings;

		parent::__construct(
			$id,
			$name,
			[
				'description' => $description,
				'customize_selective_refresh' => true,
			]
		);
	}

	public function widget( $args, $instance ): void {
		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] );
		}

		$this->renderContent( $instance );

		echo wp_kses_post( $args['after_widget'] );
	}

	abstract protected function renderContent( array $instance ): void;

	public function form( $instance ): void {
		$instance = wp_parse_args( $instance, $this->getDefaultSettings() );

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'origamiez' ) . '</label>';
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $instance['title'] ) . '" />';
		echo '</p>';

		$this->renderFormFields( $instance );
	}

	public function update( $newInstance, $oldInstance ): array {
		$instance = [];
		$instance['title'] = ! empty( $newInstance['title'] ) ? sanitize_text_field( $newInstance['title'] ) : '';

		return $this->sanitizeInstance( $newInstance, $instance );
	}

	protected function renderFormFields( array $instance ): void {
	}

	protected function sanitizeInstance( array $newInstance, array $instance ): array {
		return $instance;
	}

	protected function getDefaultSettings(): array {
		return array_merge(
			[ 'title' => '' ],
			$this->defaultSettings
		);
	}
}
