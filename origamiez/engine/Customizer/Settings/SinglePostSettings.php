<?php
/**
 * Single Post Settings
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Customizer/Settings
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

/**
 * Class SinglePostSettings
 *
 * @package Origamiez\Engine\Customizer\Settings
 */
class SinglePostSettings implements SettingsInterface {

	/**
	 * Register single post settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		// Single Post Section.
		$service->register_section(
			'single_post',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Single post', 'origamiez' ),
			)
		);

		$service->register_setting(
			'single-post-layout',
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
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_datetime',
			array(
				'label'       => esc_attr__( 'Show datetime', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_comments',
			array(
				'label'       => esc_attr__( 'Show number of comments', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_category',
			array(
				'label'       => esc_attr__( 'Show category', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_category_below_title',
			array(
				'label'       => esc_attr__( 'Show category (below title)', 'origamiez' ),
				'description' => '',
				'default'     => 0,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_tag',
			array(
				'label'       => esc_attr__( 'Show tag', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_author_info',
			array(
				'label'       => esc_attr__( 'Show author information', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_border_for_images',
			array(
				'label'       => esc_attr__( 'Show border for image inside post-content', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_use_gallery_popup',
			array(
				'label'       => esc_attr__( 'Use gallery popup', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		// Single Post Adjacent Section.
		$service->register_section(
			'single_post_adjacent',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Single post - adjacent', 'origamiez' ),
			)
		);

		$service->register_setting(
			'is_show_post_adjacent',
			array(
				'label'       => esc_attr__( 'Show next & prev posts', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post_adjacent',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_adjacent_title',
			array(
				'label'       => esc_attr__( 'Show title', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post_adjacent',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'is_show_post_adjacent_datetime',
			array(
				'label'       => esc_attr__( 'Show datetime', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post_adjacent',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'post_adjacent_arrow_left',
			array(
				'label'       => esc_attr__( 'Arrow left', 'origamiez' ),
				'description' => esc_attr__( 'Upload your arrow left', 'origamiez' ),
				'default'     => '',
				'type'        => 'upload',
				'section'     => 'single_post_adjacent',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'post_adjacent_arrow_right',
			array(
				'label'       => esc_attr__( 'Arrow right', 'origamiez' ),
				'description' => esc_attr__( 'Upload your arrow right', 'origamiez' ),
				'default'     => '',
				'type'        => 'upload',
				'section'     => 'single_post_adjacent',
				'transport'   => 'refresh',
			)
		);

		// Single Post Related Section.
		$service->register_section(
			'single_post_related',
			array(
				'panel' => 'origamiez_general',
				'title' => esc_attr__( 'Single post - related', 'origamiez' ),
			)
		);

		$service->register_setting(
			'single_post_related_layout',
			array(
				'label'       => esc_attr__( 'Layout', 'origamiez' ),
				'description' => '',
				'default'     => 'flat-list',
				'type'        => 'radio',
				'choices'     => array(
					'carousel'  => esc_attr__( 'Carousel thumbnail', 'origamiez' ),
					'flat-list' => esc_attr__( 'Flat list', 'origamiez' ),
				),
				'section'     => 'single_post_related',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'post_related_layout',
			array(
				'label'       => esc_attr__( 'Show related posts', 'origamiez' ),
				'description' => '',
				'default'     => 1,
				'type'        => 'checkbox',
				'section'     => 'single_post_related',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'get_related_post_by',
			array(
				'label'       => esc_attr__( 'Get by:', 'origamiez' ),
				'description' => '',
				'default'     => 'post_tag',
				'type'        => 'radio',
				'choices'     => array(
					'post_tag' => esc_attr__( 'Tags', 'origamiez' ),
					'category' => esc_attr__( 'Categories', 'origamiez' ),
				),
				'section'     => 'single_post_related',
				'transport'   => 'refresh',
			)
		);

		$service->register_setting(
			'number_of_related_posts',
			array(
				'label'       => esc_attr__( 'Number of related posts.', 'origamiez' ),
				'description' => '',
				'default'     => 5,
				'type'        => 'text',
				'section'     => 'single_post_related',
				'transport'   => 'refresh',
			)
		);
	}
}
