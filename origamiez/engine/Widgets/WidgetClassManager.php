<?php
/**
 * Widget Class Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

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
		global $wp_registered_widgets;
		$widget_id = $params[0]['widget_id'];
		$sidebars  = wp_get_sidebars_widgets();
		if ( empty( $sidebars ) ) {
			return $params;
		}
		foreach ( $sidebars as $sidebar_id => $widgets ) {
			if ( empty( $widgets ) || ! is_array( $widgets ) ) {
				continue;
			}
			$number_of_widgets = count( $widgets );
			foreach ( $widgets as $i => $widget ) {
				if ( $widget_id === $widget ) {
					$class = ' origamiez-widget-order-' . $i;
					if ( 0 === $i ) {
						$class .= ' origamiez-widget-first';
					}
					if ( ( $i + 1 ) === $number_of_widgets ) {
						$class .= ' origamiez-widget-last';
					}
					$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$class} ", $params[0]['before_widget'], 1 );
					break 2;
				}
			}
		}
		return $params;
	}
}
