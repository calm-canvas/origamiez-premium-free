<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

class SinglePostSettings implements SettingsInterface {

	public function register( CustomizerService $service ): void {
		// Single Post Section
		$service->registerSection( 'single_post', [
			'panel' => 'origamiez_general',
			'title' => esc_attr__( 'Single post', 'origamiez' ),
		] );

		$service->registerSetting( 'single-post-layout', [
			'label'       => esc_attr__( 'Layout', 'origamiez' ),
			'description' => '',
			'default'     => 'two-cols',
			'type'        => 'radio',
			'choices'     => [
				'two-cols'       => esc_attr__( 'Two column', 'origamiez' ),
				'three-cols'     => esc_attr__( 'Three column - large : small : medium', 'origamiez' ),
				'three-cols-slm' => esc_attr__( 'Three column - small : large : medium', 'origamiez' ),
			],
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_datetime', [
			'label'       => esc_attr__( 'Show datetime', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_comments', [
			'label'       => esc_attr__( 'Show number of comments', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_category', [
			'label'       => esc_attr__( 'Show category', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_category_below_title', [
			'label'       => esc_attr__( 'Show category (below title)', 'origamiez' ),
			'description' => '',
			'default'     => 0,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_tag', [
			'label'       => esc_attr__( 'Show tag', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_author_info', [
			'label'       => esc_attr__( 'Show author information', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_border_for_images', [
			'label'       => esc_attr__( 'Show border for image inside post-content', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_use_gallery_popup', [
			'label'       => esc_attr__( 'Use gallery popup', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post',
			'transport'   => 'refresh',
		] );

		// Single Post Adjacent Section
		$service->registerSection( 'single_post_adjacent', [
			'panel' => 'origamiez_general',
			'title' => esc_attr__( 'Single post - adjacent', 'origamiez' ),
		] );

		$service->registerSetting( 'is_show_post_adjacent', [
			'label'       => esc_attr__( 'Show next & prev posts', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post_adjacent',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_adjacent_title', [
			'label'       => esc_attr__( 'Show title', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post_adjacent',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'is_show_post_adjacent_datetime', [
			'label'       => esc_attr__( 'Show datetime', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post_adjacent',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'post_adjacent_arrow_left', [
			'label'       => esc_attr__( 'Arrow left', 'origamiez' ),
			'description' => esc_attr__( 'Upload your arrow left', 'origamiez' ),
			'default'     => '',
			'type'        => 'upload',
			'section'     => 'single_post_adjacent',
			'transport'   => 'refresh'
		] );

		$service->registerSetting( 'post_adjacent_arrow_right', [
			'label'       => esc_attr__( 'Arrow right', 'origamiez' ),
			'description' => esc_attr__( 'Upload your arrow right', 'origamiez' ),
			'default'     => '',
			'type'        => 'upload',
			'section'     => 'single_post_adjacent',
			'transport'   => 'refresh'
		] );

		// Single Post Related Section
		$service->registerSection( 'single_post_related', [
			'panel' => 'origamiez_general',
			'title' => esc_attr__( 'Single post - related', 'origamiez' ),
		] );

		$service->registerSetting( 'single_post_related_layout', [
			'label'       => esc_attr__( 'Layout', 'origamiez' ),
			'description' => '',
			'default'     => 'flat-list',
			'type'        => 'radio',
			'choices'     => [
				'carousel'  => esc_attr__( 'Carousel thumbnail', 'origamiez' ),
				'flat-list' => esc_attr__( 'Flat list', 'origamiez' ),
			],
			'section'     => 'single_post_related',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'post_related_layout', [
			'label'       => esc_attr__( 'Show related posts', 'origamiez' ),
			'description' => '',
			'default'     => 1,
			'type'        => 'checkbox',
			'section'     => 'single_post_related',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'get_related_post_by', [
			'label'       => esc_attr__( 'Get by:', 'origamiez' ),
			'description' => '',
			'default'     => 'post_tag',
			'type'        => 'radio',
			'choices'     => [
				'post_tag' => esc_attr__( 'Tags', 'origamiez' ),
				'category' => esc_attr__( 'Categories', 'origamiez' ),
			],
			'section'     => 'single_post_related',
			'transport'   => 'refresh',
		] );

		$service->registerSetting( 'number_of_related_posts', [
			'label'       => esc_attr__( 'Number of related posts.', 'origamiez' ),
			'description' => '',
			'default'     => 5,
			'type'        => 'text',
			'section'     => 'single_post_related',
			'transport'   => 'refresh',
		] );
	}
}
