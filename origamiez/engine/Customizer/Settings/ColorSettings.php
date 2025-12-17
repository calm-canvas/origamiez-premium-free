<?php
/**
 * Color Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

/**
 * Class ColorSettings
 */
class ColorSettings implements SettingsInterface {

	/**
	 * Register color settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$service->register_setting(
			'skin',
			array(
				'label'       => esc_attr__( 'Color Scheme', 'origamiez' ),
				'description' => '',
				'default'     => 'default',
				'type'        => 'radio',
				'section'     => 'colors',
				'transport'   => 'refresh',
				'choices'     => array(
					'default' => esc_attr__( 'Default', 'origamiez' ),
					'custom'  => esc_attr__( 'Custom', 'origamiez' ),
				),
			)
		);

		$service->register_setting(
			'primary_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Primary color', 'origamiez' ),
				'description'     => '',
				'default'         => '#111111',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'secondary_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Secondary color', 'origamiez' ),
				'description'     => '',
				'default'         => '#f5f7fa',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'body_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Body text color', 'origamiez' ),
				'description'     => '',
				'default'         => '#333333',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'heading_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Heading color', 'origamiez' ),
				'description'     => '',
				'default'         => '#111111',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'link_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Link color', 'origamiez' ),
				'description'     => '',
				'default'         => '#111111',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'link_hover_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Link color :hover', 'origamiez' ),
				'description'     => '',
				'default'         => '#00589f',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'main_menu_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Main menu text color', 'origamiez' ),
				'description'     => '',
				'default'         => '#111111',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'main_menu_bg_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Main menu background color', 'origamiez' ),
				'description'     => '',
				'default'         => '#ffffff',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'main_menu_hover_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Main menu hover color', 'origamiez' ),
				'description'     => '',
				'default'         => '#00589f',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'main_menu_active_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Main menu active color', 'origamiez' ),
				'description'     => '',
				'default'         => '#111111',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'line_1_bg_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Line 1 background color', 'origamiez' ),
				'description'     => '',
				'default'         => '#e8ecf1',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'line_2_bg_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Line 2 background color', 'origamiez' ),
				'description'     => '',
				'default'         => '#f0f2f5',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'line_3_bg_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Line 3 background color', 'origamiez' ),
				'description'     => '',
				'default'         => '#f8fafc',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'footer_sidebars_bg_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Footer sidebar background color', 'origamiez' ),
				'description'     => '',
				'default'         => '#222222',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'footer_sidebars_text_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Footer sidebar text color', 'origamiez' ),
				'description'     => '',
				'default'         => '#a0a0a0',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'footer_sidebars_widget_heading_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Footer widget heading color', 'origamiez' ),
				'description'     => '',
				'default'         => '#ffffff',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'footer_end_bg_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Footer end background color', 'origamiez' ),
				'description'     => '',
				'default'         => '#111111',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'footer_end_text_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Footer end text color', 'origamiez' ),
				'description'     => '',
				'default'         => '#a0a0a0',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'black_light_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Black light color', 'origamiez' ),
				'description'     => '',
				'default'         => '#f8fafc',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'metadata_color',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Metadata color', 'origamiez' ),
				'description'     => '',
				'default'         => '#666666',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
		$service->register_setting(
			'color_success',
			array(
				'type'            => 'color',
				'label'           => esc_attr__( 'Success color', 'origamiez' ),
				'description'     => '',
				'default'         => '#27ae60',
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			)
		);
	}
}
