<?php
/**
 * Single Post Settings
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Customizer/Settings
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Class SinglePostSettings
 *
 * @package Origamiez\Customizer\Settings
 */
class SinglePostSettings implements SettingsInterface {

	/**
	 * Register single post settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$this->register_single_post_main( $service );
		$this->register_single_post_adjacent( $service );
		$this->register_single_post_related( $service );
	}

	/**
	 * Main single post section and controls.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	private function register_single_post_main( CustomizerService $service ): void {
		CustomizerPanelHelper::register_section_under_general( $service, 'single_post', esc_attr__( 'Single post', 'origamiez' ) );

		$service->register_setting(
			'single-post-layout',
			array(
				'label'       => esc_attr__( 'Layout', 'origamiez' ),
				'description' => '',
				'default'     => 'two-cols',
				'type'        => 'radio',
				'choices'     => PostLayoutCustomizerHelper::get_three_column_layout_choices(),
				'section'     => 'single_post',
				'transport'   => 'refresh',
			)
		);

		$service->register_checkbox_setting( 'is_show_post_datetime', 'single_post', esc_attr__( 'Show datetime', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_post_comments', 'single_post', esc_attr__( 'Show number of comments', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_post_category', 'single_post', esc_attr__( 'Show category', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_post_category_below_title', 'single_post', esc_attr__( 'Show category (below title)', 'origamiez' ), 0 );
		$service->register_checkbox_setting( 'is_show_post_tag', 'single_post', esc_attr__( 'Show tag', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_post_author_info', 'single_post', esc_attr__( 'Show author information', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_border_for_images', 'single_post', esc_attr__( 'Show border for image inside post-content', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_use_gallery_popup', 'single_post', esc_attr__( 'Use gallery popup', 'origamiez' ) );
	}

	/**
	 * Adjacent posts subsection.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	private function register_single_post_adjacent( CustomizerService $service ): void {
		CustomizerPanelHelper::register_section_under_general( $service, 'single_post_adjacent', esc_attr__( 'Single post - adjacent', 'origamiez' ) );

		$service->register_checkbox_setting( 'is_show_post_adjacent', 'single_post_adjacent', esc_attr__( 'Show next & prev posts', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_post_adjacent_title', 'single_post_adjacent', esc_attr__( 'Show title', 'origamiez' ) );
		$service->register_checkbox_setting( 'is_show_post_adjacent_datetime', 'single_post_adjacent', esc_attr__( 'Show datetime', 'origamiez' ) );

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
	}

	/**
	 * Related posts subsection.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	private function register_single_post_related( CustomizerService $service ): void {
		CustomizerPanelHelper::register_section_under_general( $service, 'single_post_related', esc_attr__( 'Single post - related', 'origamiez' ) );

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

		$service->register_checkbox_setting( 'post_related_layout', 'single_post_related', esc_attr__( 'Show related posts', 'origamiez' ) );

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
