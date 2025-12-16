<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class LayoutSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		$service->registerSection(
			'layout',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Layout', 'origamiez' ),
			)
		);

		$service->registerSetting(
			'use_layout_fullwidth',
			array(
				'label'       => esc_attr__( 'Layout full width', 'origamiez' ),
				'description' => '',
				'default'     => 0,
				'type'        => 'checkbox',
				'section'     => 'layout',
				'transport'   => 'refresh',
			)
		);

		$service->registerSetting(
			'is_display_top_bar',
			array(
				'label'       => esc_attr__( 'Show top bar', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'layout',
				'transport'   => 'refresh',
			)
		);

		$service->registerSetting(
			'is_display_top_social_links',
			array(
				'label'           => esc_attr__( 'Show top social links', 'origamiez' ),
				'description'     => '',
				'default'         => 1,
				'type'            => 'checkbox',
				'section'         => 'layout',
				'transport'       => 'refresh',
				'active_callback' => 'origamiez_top_bar_enable_callback',
			)
		);

		$service->registerSetting(
			'is_display_breadcrumb',
			array(
				'label'       => esc_attr__( 'Show breadcrumb', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'layout',
				'transport'   => 'refresh',
			)
		);

		$service->registerSetting(
			'is_enable_convert_flat_menus',
			array(
				'label'       => esc_attr__( 'Is convert top(bottom) menu to select box on mobile.', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'layout',
				'transport'   => 'refresh',
			)
		);
	}
}
