<?php
/**
 * Widget Class Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets;

/**
 * Class WidgetClassManager
 */
class WidgetClassManager {

	/**
	 * Add widget order classes.
	 */
	public function add_widget_order_classes(): void {
		add_filter( 'dynamic_sidebar_params', array( $this, 'add_widget_classes' ) );
	}

	/**
	 * Add widget classes.
	 *
	 * @param array $params The sidebar parameters.
	 * @return array
	 */
	public function add_widget_classes( $params ): array {
		$widget_id = $params[0]['widget_id'];
		$sidebars  = wp_get_sidebars_widgets();
		if ( empty( $sidebars ) ) {
			return $params;
		}
		foreach ( $sidebars as $widgets ) {
			if ( empty( $widgets ) || ! is_array( $widgets ) ) {
				continue;
			}
			$number_of_widgets = count( $widgets );
			foreach ( $widgets as $i => $widget ) {
				if ( $widget_id !== $widget ) {
					continue;
				}
				return $this->apply_widget_order_class_to_params( $params, $i, $number_of_widgets );
			}
		}
		return $params;
	}

	/**
	 * Append order / first / last classes to the widget wrapper markup.
	 *
	 * @param array $params            Sidebar params.
	 * @param int   $index             Widget index in sidebar.
	 * @param int   $number_of_widgets Total widgets in sidebar.
	 * @return array
	 */
	private function apply_widget_order_class_to_params( array $params, int $index, int $number_of_widgets ): array {
		$class = ' origamiez-widget-order-' . $index;
		if ( 0 === $index ) {
			$class .= ' origamiez-widget-first';
		}
		if ( ( $index + 1 ) === $number_of_widgets ) {
			$class .= ' origamiez-widget-last';
		}
		$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$class} ", $params[0]['before_widget'], 1 );

		return $params;
	}
}
