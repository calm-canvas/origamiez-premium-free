<?php
/**
 * Custom CSS Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

/**
 * Class CustomCssSettings
 */
class CustomCssSettings implements SettingsInterface {

	/**
	 * Register custom CSS settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$service->register_section(
			'custom_css',
			array(
				'title' => esc_attr__( 'Custom CSS', 'origamiez' ),
			)
		);

		$service->register_setting(
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
