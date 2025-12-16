<?php
/**
 * Setting Builder for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Builders;

use Origamiez\Engine\Customizer\ControlFactory;
use WP_Customize_Manager;

/**
 * Class SettingBuilder
 */
class SettingBuilder {

	/**
	 * The customize manager.
	 *
	 * @var WP_Customize_Manager
	 */
	private WP_Customize_Manager $wp_customize;

	/**
	 * The control factory.
	 *
	 * @var ControlFactory
	 */
	private ControlFactory $control_factory;

	/**
	 * SettingBuilder constructor.
	 *
	 * @param WP_Customize_Manager $wp_customize The customize manager.
	 * @param ControlFactory       $control_factory The control factory.
	 */
	public function __construct( WP_Customize_Manager $wp_customize, ControlFactory $control_factory ) {
		$this->wp_customize    = $wp_customize;
		$this->control_factory = $control_factory;
	}

	/**
	 * Build a setting and its control.
	 *
	 * @param string $id The setting ID.
	 * @param array  $args The setting arguments.
	 */
	public function build( string $id, array $args ): void {
		// Prepare arguments for add_setting.
		$setting_args = array(
			'default'           => $args['default'] ?? '',
			'type'              => $args['setting_type'] ?? 'theme_mod',
			'capability'        => $args['capability'] ?? 'edit_theme_options',
			'transport'         => $args['transport'] ?? 'refresh',
			'sanitize_callback' => $args['sanitize_callback'] ?? 'sanitize_text_field',
		);

		$this->wp_customize->add_setting( $id, $setting_args );

		// Create and add control.
		// Ensure the setting ID is passed to the control.
		$args['settings'] = $id;

		// If section is not set in args, it might be handled by the caller or default.
		if ( ! isset( $args['section'] ) ) {
			// Warning or default? WP requires section for control.
			// We assume it's in $args.
		}

		$control = $this->control_factory->create( $this->wp_customize, $id, $args );
		$this->wp_customize->add_control( $control );
	}
}
