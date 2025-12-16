<?php

namespace Origamiez\Engine\Widgets;

class WidgetClassManager {

	public function addWidgetOrderClasses(): void {
		global $wp_registered_widgets;
		$sidebars = wp_get_sidebars_widgets();
		if ( empty( $sidebars ) ) {
			return;
		}
		foreach ( $sidebars as $sidebar_id => $widgets ) {
			if ( empty( $widgets ) ) {
				continue;
			}
			$number_of_widgets = count( $widgets );
			foreach ( $widgets as $i => $widget_id ) {
				if ( isset( $wp_registered_widgets[ $widget_id ]['classname'] ) ) {
					$wp_registered_widgets[ $widget_id ]['classname'] .= ' origamiez-widget-order-' . $i;
					if ( 0 === $i ) {
						$wp_registered_widgets[ $widget_id ]['classname'] .= ' origamiez-widget-first';
					}
					if ( ( $i + 1 ) === $number_of_widgets ) {
						$wp_registered_widgets[ $widget_id ]['classname'] .= ' origamiez-widget-last';
					}
				}
			}
		}
	}
}
