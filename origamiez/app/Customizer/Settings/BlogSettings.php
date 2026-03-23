<?php
/**
 * Blog Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

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
		CustomizerPanelHelper::register_section_under_general( $service, 'blog_posts', esc_attr__( 'Blog posts', 'origamiez' ) );

		$service->register_setting(
			'taxonomy_layout',
			array(
				'label'       => esc_attr__( 'Layout', 'origamiez' ),
				'description' => '',
				'default'     => 'two-cols',
				'type'        => 'radio',
				'choices'     => PostLayoutCustomizerHelper::get_three_column_layout_choices(),
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
