<?php

namespace Origamiez\Engine\Customizer;

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use WP_Customize_Image_Control;

class ControlFactory {

	public function create( WP_Customize_Manager $wp_customize, string $id, array $args ): WP_Customize_Control {
		$type = $args['type'] ?? 'text';

		switch ( $type ) {
			case 'upload':
			case 'image':
				unset( $args['type'] );
				return new WP_Customize_Image_Control( $wp_customize, $id, $args );

			case 'color':
				unset( $args['type'] );
				return new WP_Customize_Color_Control( $wp_customize, $id, $args );

			case 'text':
			case 'textarea':
			case 'checkbox':
			case 'radio':
			case 'select':
			default:
				return new WP_Customize_Control( $wp_customize, $id, $args );
		}
	}
}
