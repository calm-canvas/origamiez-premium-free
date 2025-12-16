<?php

namespace Origamiez\Engine\Customizer\Builders;

use Origamiez\Engine\Customizer\ControlFactory;
use WP_Customize_Manager;

class SettingBuilder {

	private WP_Customize_Manager $wp_customize;
	private ControlFactory $controlFactory;

	public function __construct( WP_Customize_Manager $wp_customize, ControlFactory $controlFactory ) {
		$this->wp_customize   = $wp_customize;
		$this->controlFactory = $controlFactory;
	}

	public function build( string $id, array $args ): void {
		// Prepare arguments for add_setting
		$settingArgs = array(
			'default'           => $args['default'] ?? '',
			'type'              => $args['setting_type'] ?? 'theme_mod',
			'capability'        => $args['capability'] ?? 'edit_theme_options',
			'transport'         => $args['transport'] ?? 'refresh',
			'sanitize_callback' => $args['sanitize_callback'] ?? 'sanitize_text_field',
		);

		$this->wp_customize->add_setting( $id, $settingArgs );

		// Create and add control
		// Ensure the setting ID is passed to the control
		$args['settings'] = $id;

		// If section is not set in args, it might be handled by the caller or default
		if ( ! isset( $args['section'] ) ) {
			// Warning or default? WP requires section for control.
			// We assume it's in $args.
		}

		$control = $this->controlFactory->create( $this->wp_customize, $id, $args );
		$this->wp_customize->add_control( $control );
	}
}
