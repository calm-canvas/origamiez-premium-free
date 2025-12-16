<?php
/**
 * Blog Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

/**
 * Class BlogSettings
 */
class BlogSettings implements SettingsInterface {

	/**
	 * Register blog settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$service->register_section(
			'blog_posts',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Blog posts', 'origamiez' ),
			)
		);

		$service->register_setting(
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

		$service->register_setting(
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
