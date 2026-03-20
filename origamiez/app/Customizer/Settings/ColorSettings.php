<?php
/**
 * Color Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Class ColorSettings
 *
 * Colors are edited in Appearance → Editor (global styles). Phase 3: informational control only.
 */
class ColorSettings implements SettingsInterface {

	/**
	 * Register color settings (Site Editor redirect notice).
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$service->register_setting(
			'origamiez_notice_site_editor_colors',
			array(
				'label'             => esc_html__( 'Colors', 'origamiez' ),
				'description'       => wp_kses_post(
					__( 'Color palette, menu colors, footer colors, and the custom color scheme are now controlled in the Site Editor under <strong>Styles</strong>. Existing Customizer values were migrated when possible. Use the button below to open the editor.', 'origamiez' )
				),
				'default'           => '',
				'type'              => 'origamiez_site_editor_notice',
				'section'           => 'colors',
				'transport'         => 'refresh',
				'sanitize_callback' => '__return_empty_string',
				'priority'          => 1,
			)
		);
	}
}
