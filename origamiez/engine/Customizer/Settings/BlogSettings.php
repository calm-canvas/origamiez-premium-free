<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class BlogSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		$service->registerSection(
			'blog_posts',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Blog posts', 'origamiez' ),
			)
		);

		$service->registerSetting(
			'taxonomy_layout',
			array(
				'label'       => esc_attr__( 'Layout', 'origamiez' ),
				'description' => '',
				'default'     => 'two-cols',
				'type'        => 'radio',
				'choices'     => array(
					'two-cols'       => esc_attr__( 'Two column', 'origamiez' ),
					'three-cols'     => esc_attr__( 'Three column - large : small : medium', 'origamiez' ),
					'three-cols-slm' => esc_attr__( 'Three column - small : large : medium', 'origamiez' ),
				),
				'section'     => 'blog_posts',
				'transport'   => 'refresh',
			)
		);

		$service->registerSetting(
			'taxonomy_thumbnail_style',
			array(
				'label'       => esc_attr__( 'Thumbnail position', 'origamiez' ),
				'description' => '',
				'default'     => 'thumbnail-left',
				'type'        => 'radio',
				'choices'     => array(
					'thumbnail-left'       => esc_attr__( 'Thumbnail left', 'origamiez' ),
					'thumbnail-right'      => esc_attr__( 'Thumbnail right', 'origamiez' ),
					'thumbnail-full-width' => esc_attr__( 'Thumbnail full width', 'origamiez' ),
				),
				'section'     => 'blog_posts',
				'transport'   => 'refresh',
			)
		);
	}
}
