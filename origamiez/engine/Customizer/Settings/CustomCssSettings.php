<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class CustomCssSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		$service->registerSection(
			'custom_css',
			array(
				'title' => esc_attr__( 'Custom CSS', 'origamiez' ),
			)
		);

		$service->registerSetting(
			'custom_css',
			array(
				'label'       => esc_attr__( 'Custom CSS', 'origamiez' ),
				'description' => '',
				'default'     => '',
				'type'        => 'textarea',
				'transport'   => 'refresh',
				'section'     => 'custom_css',
			)
		);
	}
}
