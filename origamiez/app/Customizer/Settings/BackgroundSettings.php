<?php
/**
 * Background (Customizer) — Site Editor notice only (core Background Image section removed).
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Class BackgroundSettings
 */
class BackgroundSettings implements SettingsInterface {

	/**
	 * Register background notice (body background is edited in the Site Editor).
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$service->register_section(
			'origamiez_site_editor_background',
			array(
				'title'       => esc_html__( 'Background', 'origamiez' ),
				'description' => '',
				'priority'    => 90,
			)
		);

		$service->register_setting(
			'origamiez_notice_site_editor_background',
			array(
				'label'             => '',
				'description'       => wp_kses_post(
					__( 'Site background color and image are configured in the Site Editor under <strong>Styles</strong>. If you had a Customizer background, it was copied into theme styles when migration ran.', 'origamiez' )
				),
				'default'           => '',
				'type'              => 'origamiez_site_editor_notice',
				'section'           => 'origamiez_site_editor_background',
				'transport'         => 'refresh',
				'sanitize_callback' => '__return_empty_string',
				'priority'          => 1,
			)
		);
	}
}
