<?php

namespace Origamiez\Engine\Widgets;

class WidgetRegistry {

	private array $widgets = [];

	public function registerWidget( string $widgetClass ): self {
		if ( ! class_exists( $widgetClass ) ) {
			return $this;
		}

		add_action( 'widgets_init', function () use ( $widgetClass ) {
			register_widget( $widgetClass );
		} );

		$this->widgets[] = $widgetClass;

		return $this;
	}

	public function getRegisteredWidgets(): array {
		return $this->widgets;
	}

	public function isWidgetRegistered( string $widgetClass ): bool {
		return in_array( $widgetClass, $this->widgets, true );
	}

	public static function getInstance(): self {
		static $instance = null;
		if ( $instance === null ) {
			$instance = new self();
		}
		return $instance;
	}
}
