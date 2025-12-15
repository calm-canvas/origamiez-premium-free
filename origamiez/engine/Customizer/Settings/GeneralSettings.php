<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class GeneralSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		// Modify existing settings
		$service->modifySetting( 'blogname', [ 'transport' => 'refresh' ] );
		$service->modifySetting( 'blogdescription', [ 'transport' => 'refresh' ] );

		// Register Panel
		$service->registerPanel( 'origamiez_general', [
			'title' => esc_attr__( 'General Setting', 'origamiez' ),
		] );

		// Register Sections
		$service->registerSection( 'header', [
			'panel' => 'origamiez_general',
			'title' => esc_attr__( 'Header', 'origamiez' )
		] );

		$service->registerSection( 'footer', [
			'panel' => 'origamiez_general',
			'title' => esc_attr__( 'Footer', 'origamiez' )
		] );

		// Register Settings
		$service->registerSetting( 'logo', [
			'label'       => esc_attr__( 'Logo', 'origamiez' ),
			'description' => esc_attr__( 'Upload or enter your logo', 'origamiez' ),
			'default'     => '',
			'type'        => 'upload',
			'section'     => 'header',
			'transport'   => 'refresh'
		] );

		$service->registerSetting( 'header_style', [
			'label'       => esc_attr__( 'Header style', 'origamiez' ),
			'description' => '',
			'default'     => 'left-right',
			'type'        => 'radio',
			'choices'     => [
				'left-right' => esc_attr__( 'Logo: left, Banner: right', 'origamiez' ),
				'up-down'    => esc_attr__( 'Logo: up, Banner: down', 'origamiez' ),
			],
			'section'     => 'header',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'footer_information', [
			'label'       => esc_attr__( 'Footer information', 'origamiez' ),
			'description' => esc_attr__( 'Enter your information, e.g. copyright, or Google AdSense code, ...', 'origamiez' ),
			'default'     => esc_attr__( '&copy; 2025 The Calm Canvas Team. All rights reserved.', 'origamiez' ),
			'type'        => 'textarea',
			'section'     => 'footer',
			'transport'   => 'refresh'
		] );

		$service->registerSetting( 'footer_number_of_cols', [
			'label'       => esc_attr__( 'Number of columns', 'origamiez' ),
			'description' => '',
			'default'     => 5,
			'type'        => 'radio',
			'choices'     => [
				5 => esc_attr__( '5 Columns', 'origamiez' ),
				4 => esc_attr__( '4 Columns', 'origamiez' ),
				3 => esc_attr__( '3 Columns', 'origamiez' ),
				2 => esc_attr__( '2 Columns', 'origamiez' ),
				1 => esc_attr__( '1 Column', 'origamiez' ),
			],
			'section'     => 'footer',
			'transport'   => 'refresh',
		] );
	}
}
