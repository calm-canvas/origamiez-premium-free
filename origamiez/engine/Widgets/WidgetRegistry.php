<?php

namespace Origamiez\Engine\Widgets;

class WidgetRegistry {

	private array $widgets         = array();
	private static ?self $instance = null;

	private function __construct() {
	}

	public static function getInstance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function registerWidget( string $widgetClass ): self {
		$this->widgets[] = $widgetClass;
		return $this;
	}

	public function getWidgets(): array {
		return $this->widgets;
	}

	public function register(): void {
		add_action( 'widgets_init', array( $this, 'doRegisterWidgets' ) );
	}

	public function doRegisterWidgets(): void {
		foreach ( $this->widgets as $widget ) {
			register_widget( $widget );
		}
	}
}
