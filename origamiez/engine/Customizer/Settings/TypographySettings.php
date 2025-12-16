<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class TypographySettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		$service->registerPanel(
			'origamiez_typography',
			array(
				'title' => esc_attr__( 'Typography', 'origamiez' ),
			)
		);

		$service->registerPanel(
			'origamiez_google_fonts',
			array(
				'title' => esc_attr__( 'Google fonts', 'origamiez' ),
			)
		);

		$font_objects = array(
			'font_body'          => esc_attr__( 'Body', 'origamiez' ),
			'font_menu'          => esc_attr__( 'Menu', 'origamiez' ),
			'font_site_title'    => esc_attr__( 'Site title', 'origamiez' ),
			'font_site_subtitle' => esc_attr__( 'Site subtitle', 'origamiez' ),
			'font_widget_title'  => esc_attr__( 'Widget title', 'origamiez' ),
			'font_h1'            => esc_attr__( 'Heading 1', 'origamiez' ),
			'font_h2'            => esc_attr__( 'Heading 2', 'origamiez' ),
			'font_h3'            => esc_attr__( 'Heading 3', 'origamiez' ),
			'font_h4'            => esc_attr__( 'Heading 4', 'origamiez' ),
			'font_h5'            => esc_attr__( 'Heading 5', 'origamiez' ),
			'font_h6'            => esc_attr__( 'Heading 6', 'origamiez' ),
		);

		foreach ( $font_objects as $font_slug => $font_title ) {
			$service->registerSection(
				"custom_{$font_slug}",
				array(
					'panel' => 'origamiez_typography',
					'title' => $font_title,
				)
			);

			$service->registerSetting(
				"{$font_slug}_is_enable",
				array(
					'label'       => esc_attr__( 'Check to enable', 'origamiez' ),
					'description' => '',
					'default'     => 0,
					'type'        => 'checkbox',
					'section'     => "custom_{$font_slug}",
					'transport'   => 'refresh',
				)
			);

			$service->registerSetting(
				"{$font_slug}_family",
				array(
					'label'           => esc_attr__( 'Font Family', 'origamiez' ),
					'description'     => '',
					'default'         => '',
					'type'            => 'select',
					'choices'         => origamiez_get_font_families(),
					'section'         => "custom_{$font_slug}",
					'transport'       => 'refresh',
					'active_callback' => "origamiez_{$font_slug}_enable_callback",
				)
			);

			$service->registerSetting(
				"{$font_slug}_size",
				array(
					'label'           => esc_attr__( 'Font Size', 'origamiez' ),
					'description'     => '',
					'default'         => '',
					'type'            => 'select',
					'choices'         => origamiez_get_font_sizes(),
					'section'         => "custom_{$font_slug}",
					'transport'       => 'refresh',
					'active_callback' => "origamiez_{$font_slug}_enable_callback",
				)
			);

			$service->registerSetting(
				"{$font_slug}_style",
				array(
					'label'           => esc_attr__( 'Font Style', 'origamiez' ),
					'description'     => '',
					'default'         => '',
					'type'            => 'select',
					'choices'         => origamiez_get_font_styles(),
					'section'         => "custom_{$font_slug}",
					'transport'       => 'refresh',
					'active_callback' => "origamiez_{$font_slug}_enable_callback",
				)
			);

			$service->registerSetting(
				"{$font_slug}_weight",
				array(
					'label'           => esc_attr__( 'Font Weight', 'origamiez' ),
					'description'     => '',
					'default'         => '',
					'type'            => 'select',
					'choices'         => origamiez_get_font_weights(),
					'section'         => "custom_{$font_slug}",
					'transport'       => 'refresh',
					'active_callback' => "origamiez_{$font_slug}_enable_callback",
				)
			);

			$service->registerSetting(
				"{$font_slug}_line_height",
				array(
					'label'           => esc_attr__( 'Line height', 'origamiez' ),
					'description'     => '',
					'default'         => '',
					'type'            => 'select',
					'choices'         => origamiez_get_font_line_heighs(),
					'section'         => "custom_{$font_slug}",
					'transport'       => 'refresh',
					'active_callback' => "origamiez_{$font_slug}_enable_callback",
				)
			);
		}

		// Google Fonts
		$number_of_google_fonts = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );
		if ( $number_of_google_fonts ) {
			for ( $i = 0; $i < $number_of_google_fonts; $i++ ) {
				$service->registerSection(
					sprintf( 'google_font_%s', $i ),
					array(
						'panel' => 'origamiez_google_fonts',
						'title' => esc_attr__( 'Font #:', 'origamiez' ) . ( $i + 1 ),
					)
				);

				$service->registerSetting(
					sprintf( 'google_font_%s_name', $i ),
					array(
						'label'       => esc_attr__( 'Font family (name)', 'origamiez' ),
						'description' => __( 'Please remove "+" by " ". Ex: <code>Open+Sans</code> to <code>Open Sans</code>', 'origamiez' ),
						'default'     => '',
						'type'        => 'text',
						'section'     => sprintf( 'google_font_%s', $i ),
						'transport'   => 'refresh',
					)
				);

				$service->registerSetting(
					sprintf( 'google_font_%s_src', $i ),
					array(
						'label'       => esc_attr__( 'Path of this font', 'origamiez' ),
						'description' => '',
						'default'     => '',
						'type'        => 'text',
						'section'     => sprintf( 'google_font_%s', $i ),
						'transport'   => 'refresh',
					)
				);
			}
		}
	}
}
