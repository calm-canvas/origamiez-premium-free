<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class ColorSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		$service->registerSetting( 'skin', [
			'label'       => esc_attr__( 'Color Scheme', 'origamiez' ),
			'description' => '',
			'default'     => 'default',
			'type'        => 'radio',
			'section'     => 'colors',
			'transport'   => 'refresh',
			'choices'     => [
				'default' => esc_attr__( 'Default', 'origamiez' ),
				'custom'  => esc_attr__( 'Custom', 'origamiez' ),
			]
		] );

		$colors = [
			'primary_color'                      => [ 'label' => 'Primary color', 'default' => '#111111' ],
			'secondary_color'                    => [ 'label' => 'Secondary color', 'default' => '#f5f7fa' ],
			'body_color'                         => [ 'label' => 'Body text color', 'default' => '#333333' ],
			'heading_color'                      => [ 'label' => 'Heading color', 'default' => '#111111' ],
			'link_color'                         => [ 'label' => 'Link color', 'default' => '#111111' ],
			'link_hover_color'                   => [ 'label' => 'Link color :hover', 'default' => '#00589f' ],
			'main_menu_color'                    => [ 'label' => 'Main menu text color', 'default' => '#111111' ],
			'main_menu_bg_color'                 => [ 'label' => 'Main menu background color', 'default' => '#ffffff' ],
			'main_menu_hover_color'              => [ 'label' => 'Main menu hover color', 'default' => '#00589f' ],
			'main_menu_active_color'             => [ 'label' => 'Main menu active color', 'default' => '#111111' ],
			'line_1_bg_color'                    => [ 'label' => 'Line 1 background color', 'default' => '#e8ecf1' ],
			'line_2_bg_color'                    => [ 'label' => 'Line 2 background color', 'default' => '#f0f2f5' ],
			'line_3_bg_color'                    => [ 'label' => 'Line 3 background color', 'default' => '#f8fafc' ],
			'footer_sidebars_bg_color'           => [ 'label' => 'Footer sidebar background color', 'default' => '#222222' ],
			'footer_sidebars_text_color'         => [ 'label' => 'Footer sidebar text color', 'default' => '#a0a0a0' ],
			'footer_sidebars_widget_heading_color' => [ 'label' => 'Footer widget heading color', 'default' => '#ffffff' ],
			'footer_end_bg_color'                => [ 'label' => 'Footer end background color', 'default' => '#111111' ],
			'footer_end_text_color'              => [ 'label' => 'Footer end text color', 'default' => '#a0a0a0' ],
			'black_light_color'                  => [ 'label' => 'Black light color', 'default' => '#f8fafc' ],
			'metadata_color'                     => [ 'label' => 'Metadata color', 'default' => '#666666' ],
			'color_success'                      => [ 'label' => 'Success color', 'default' => '#27ae60' ],
		];

		foreach ( $colors as $id => $args ) {
			$service->registerSetting( $id, [
				'type'            => 'color',
				'label'           => esc_attr__( $args['label'], 'origamiez' ),
				'description'     => '',
				'default'         => $args['default'],
				'section'         => 'colors',
				'active_callback' => 'origamiez_skin_custom_callback',
				'transport'       => 'refresh',
			] );
		}
	}
}
