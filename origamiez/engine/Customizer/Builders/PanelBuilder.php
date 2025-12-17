<?php
/**
 * Panel Builder for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Builders;

use WP_Customize_Manager;

/**
 * Class PanelBuilder
 */
class PanelBuilder {

	/**
	 * The customize manager.
	 *
	 * @var WP_Customize_Manager
	 */
	private WP_Customize_Manager $wp_customize;

	/**
	 * PanelBuilder constructor.
	 *
	 * @param WP_Customize_Manager $wp_customize The customize manager.
	 */
	public function __construct( WP_Customize_Manager $wp_customize ) {
		$this->wp_customize = $wp_customize;
	}

	/**
	 * Build a panel.
	 *
	 * @param string $id The panel ID.
	 * @param array  $args The panel arguments.
	 */
	public function build( string $id, array $args ): void {
		$this->wp_customize->add_panel( $id, $args );
	}
}
