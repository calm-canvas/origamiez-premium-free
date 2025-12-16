<?php
/**
 * Widget Registry
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

/**
 * Class WidgetRegistry
 */
class WidgetRegistry {

	/**
	 * Widgets.
	 *
	 * @var array
	 */
	private array $widgets = array();

	/**
	 * Instance.
	 *
	 * @var ?self
	 */
	private static ?self $instance = null;

	/**
	 * WidgetRegistry constructor.
	 */
	private function __construct() {
	}

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register widget.
	 *
	 * @param string $widget_class Widget class.
	 * @return self
	 */
	public function register_widget( string $widget_class ): self {
		$this->widgets[] = $widget_class;
		return $this;
	}

	/**
	 * Get widgets.
	 *
	 * @return array
	 */
	public function get_widgets(): array {
		return $this->widgets;
	}

	/**
	 * Register widgets.
	 */
	public function register(): void {
		add_action( 'widgets_init', array( $this, 'do_register_widgets' ) );
	}

	/**
	 * Do register widgets.
	 */
	public function do_register_widgets(): void {
		foreach ( $this->widgets as $widget ) {
			register_widget( $widget );
		}
	}
}
