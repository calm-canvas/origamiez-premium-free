<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class CustomCssSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		$service->registerSection( 'custom_css', [
			'title' => esc_attr__( 'Custom CSS', 'origamiez' ),
		] );

		$service->registerSetting( 'custom_css', [
			'label'       => esc_attr__( 'Custom CSS', 'origamiez' ),
			'description' => '',
			'default'     => '',
			'type'        => 'textarea',
			'transport'   => 'refresh',
			'section'     => 'custom_css',
		] );
	}
}
