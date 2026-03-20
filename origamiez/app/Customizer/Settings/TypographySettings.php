<?php
/**
 * Typography Settings
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Customizer/Settings
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Class TypographySettings
 *
 * Typography and Google Fonts are edited in Appearance → Editor. Phase 3: top-level informational sections only.
 */
class TypographySettings implements SettingsInterface {

	/**
	 * Register typography settings (Site Editor redirect notices).
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		// Top-level sections (no panel → sub-section) so notices show in one click.
		$service->register_section(
			'origamiez_typography_site_editor',
			array(
				'title'    => esc_html__( 'Typography', 'origamiez' ),
				'priority' => 50,
			)
		);

		$service->register_setting(
			'origamiez_notice_site_editor_typography',
			array(
				'label'             => '',
				'description'       => wp_kses_post(
					__( 'Body text, headings, navigation, site title, and related typography are configured in the Site Editor: open <strong>Styles</strong> → <strong>Typography</strong> (and block styles where applicable). Customizer typography settings were migrated to your theme’s user styles when possible.', 'origamiez' )
				),
				'default'           => '',
				'type'              => 'origamiez_site_editor_notice',
				'section'           => 'origamiez_typography_site_editor',
				'transport'         => 'refresh',
				'sanitize_callback' => '__return_empty_string',
				'priority'          => 1,
			)
		);

		$service->register_section(
			'origamiez_google_fonts_site_editor',
			array(
				'title'    => esc_html__( 'Google fonts', 'origamiez' ),
				'priority' => 55,
			)
		);

		$service->register_setting(
			'origamiez_notice_site_editor_google_fonts',
			array(
				'label'             => '',
				'description'       => wp_kses_post(
					__( 'Register font families in the Site Editor (<strong>Styles</strong> → <strong>Typography</strong>). Google Fonts stylesheet URLs from the old Customizer were stored in theme JSON where supported; the theme may still enqueue them from that data.', 'origamiez' )
				),
				'default'           => '',
				'type'              => 'origamiez_site_editor_notice',
				'section'           => 'origamiez_google_fonts_site_editor',
				'transport'         => 'refresh',
				'sanitize_callback' => '__return_empty_string',
				'priority'          => 1,
			)
		);
	}
}
