<?php
/**
 * Section Builder for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Builders;

use WP_Customize_Manager;

/**
 * Class SectionBuilder
 */
class SectionBuilder {

	/**
	 * The customize manager.
	 *
	 * @var WP_Customize_Manager
	 */
	private WP_Customize_Manager $wp_customize;

	/**
	 * SectionBuilder constructor.
	 *
	 * @param WP_Customize_Manager $wp_customize The customize manager.
	 */
	public function __construct( WP_Customize_Manager $wp_customize ) {
		$this->wp_customize = $wp_customize;
	}

	/**
	 * Build a section.
	 *
	 * @param string $id The section ID.
	 * @param array  $args The section arguments.
	 */
	public function build( string $id, array $args ): void {
		$this->wp_customize->add_section( $id, $args );
	}
}
