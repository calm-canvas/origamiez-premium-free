<?php
/**
 * General Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

/**
 * Class GeneralSettings
 */
class GeneralSettings implements SettingsInterface {

	/**
	 * Register general settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		// Modify existing settings.
		$service->modify_setting( 'blogname', array( 'transport' => 'refresh' ) );
		$service->modify_setting( 'blogdescription', array( 'transport' => 'refresh' ) );

		// Register Panel.
		$service->register_panel(
			'origamiez_general',
			array(
				'title' => esc_attr__( 'General Setting', 'origamiez' ),
			)
		);

		// Register Sections.
		$service->register_section(
			'header',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Header', 'origamiez' ),
			)
		);

		$service->register_section(
			'footer',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Footer', 'origamiez' ),
			)
		);

		// Register Settings.
		$service->register_setting(
			'logo',
			array(
				'label'       => esc_attr__( 'Logo', 'origamiez' ),
				'description' => esc_attr__( 'Upload or enter your logo', 'origamiez' ),
				'default'     => '',
				'type'        => 'upload',
				'section'     => 'header',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'header_style',
			array(
				'label'       => esc_attr__( 'Header style', 'origamiez' ),
				'description' => '',
				'default'     => 'left-right',
				'type'        => 'radio',
				'choices'     => array(
					'left-right' => esc_attr__( 'Logo: left, Banner: right', 'origamiez' ),
					'up-down'    => esc_attr__( 'Logo: up, Banner: down', 'origamiez' ),
				),
				'section'     => 'header',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'footer_information',
			array(
				'label'       => esc_attr__( 'Footer information', 'origamiez' ),
				'description' => esc_attr__( 'Enter your information, e.g. copyright, or Google AdSense code, ...', 'origamiez' ),
				'default'     => esc_attr__( '&copy; 2025 The Calm Canvas Team. All rights reserved.', 'origamiez' ),
				'type'        => 'textarea',
				'section'     => 'footer',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'footer_number_of_cols',
			array(
				'label'       => esc_attr__( 'Number of columns', 'origamiez' ),
				'description' => '',
				'default'     => 5,
				'type'        => 'radio',
				'choices'     => array(
					5 => esc_attr__( '5 Columns', 'origamiez' ),
					4 => esc_attr__( '4 Columns', 'origamiez' ),
					3 => esc_attr__( '3 Columns', 'origamiez' ),
					2 => esc_attr__( '2 Columns', 'origamiez' ),
					1 => esc_attr__( '1 Column', 'origamiez' ),
				),
				'section'     => 'footer',
				'transport'   => 'refresh',
			)
		);
	}
}
