<?php
/**
 * Layout Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Class LayoutSettings
 */
class LayoutSettings implements SettingsInterface {

	/**
	 * Register layout settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		CustomizerPanelHelper::register_section_under_general( $service, 'layout', esc_attr__( 'Layout', 'origamiez' ) );

		$service->register_checkbox_setting( 'use_layout_fullwidth', 'layout', esc_attr__( 'Layout full width', 'origamiez' ), 0 );
		$service->register_checkbox_setting( 'is_display_top_bar', 'layout', esc_attr__( 'Show top bar', 'origamiez' ) );
		$service->register_checkbox_setting(
			'is_display_top_social_links',
			'layout',
			esc_attr__( 'Show top social links', 'origamiez' ),
			1,
			array(
				'active_callback' => 'origamiez_top_bar_enable_callback',
			)
		);
		$service->register_checkbox_setting( 'is_display_breadcrumb', 'layout', esc_attr__( 'Show breadcrumb', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_enable_convert_flat_menus', 'layout', esc_attr__( 'Is convert top(bottom) menu to select box on mobile.', 'origamiez' ) );
	}
}
