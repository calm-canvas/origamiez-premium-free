<?php

namespace Origamiez\Engine\Customizer\Builders;

use WP_Customize_Manager;

class PanelBuilder {

	private WP_Customize_Manager $wp_customize;

	public function __construct( WP_Customize_Manager $wp_customize ) {
		$this->wp_customize = $wp_customize;
	}

	public function build( string $id, array $args ): void {
		$this->wp_customize->add_panel( $id, $args );
	}
}
