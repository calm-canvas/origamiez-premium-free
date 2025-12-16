<?php

namespace Origamiez\Engine\Config;

class BodyClassConfig {

	public const CUSTOM_BG = 'origamiez_custom_bg';
	public const WITHOUT_BG_SLIDES = 'without_bg_slides';
	public const LAYOUT_BOXER = 'origamiez-boxer';
	public const LAYOUT_FLUID = 'origamiez-fluid';
	public const SHOW_FOOTER_AREA = 'origamiez-show-footer-area';
	public const SKIN_PREFIX = 'origamiez-skin-';
	public const HEADER_STYLE_PREFIX = 'origamiez-header-style-';
	public const MISSING_SIDEBAR_RIGHT = 'origamiez-missing-sidebar-right';
	public const MISSING_SIDEBAR_LEFT = 'origamiez-missing-sidebar-left';

	public const LAYOUT_RIGHT_SIDEBAR = 'origamiez-layout-right-sidebar';
	public const LAYOUT_SINGLE = 'origamiez-layout-single';
	public const SHOW_BORDER_FOR_IMAGES = 'origamiez-show-border-for-images';
	public const SINGLE_POST_LAYOUT_PREFIX = 'origamiez-single-post-';

	public const LAYOUT_FULL_WIDTH = 'origamiez-layout-full-width';
	public const PAGE_MAGAZINE = 'origamiez-page-magazine';
	public const LAYOUT_STATIC_PAGE = 'origamiez-layout-static-page';

	public const LAYOUT_BLOG = 'origamiez-layout-blog';
	public const LAYOUT_BLOG_THUMBNAIL_RIGHT = 'origamiez-layout-blog-thumbnail-right';
	public const LAYOUT_BLOG_THUMBNAIL_FULL_WIDTH = 'origamiez-layout-blog-thumbnail-full-width';
	public const LAYOUT_BLOG_THUMBNAIL_LEFT = 'origamiez-layout-blog-thumbnail-left';
	public const TAXONOMY_PREFIX = 'origamiez-taxonomy-';

	public function getClasses(): array {
		return [
			'custom_bg'                          => self::CUSTOM_BG,
			'without_bg_slides'                  => self::WITHOUT_BG_SLIDES,
			'layout_boxer'                       => self::LAYOUT_BOXER,
			'layout_fluid'                       => self::LAYOUT_FLUID,
			'show_footer_area'                   => self::SHOW_FOOTER_AREA,
			'skin_prefix'                        => self::SKIN_PREFIX,
			'header_style_prefix'                => self::HEADER_STYLE_PREFIX,
			'missing_sidebar_right'              => self::MISSING_SIDEBAR_RIGHT,
			'missing_sidebar_left'               => self::MISSING_SIDEBAR_LEFT,
			'layout_right_sidebar'               => self::LAYOUT_RIGHT_SIDEBAR,
			'layout_single'                      => self::LAYOUT_SINGLE,
			'show_border_for_images'             => self::SHOW_BORDER_FOR_IMAGES,
			'single_post_layout_prefix'          => self::SINGLE_POST_LAYOUT_PREFIX,
			'layout_full_width'                  => self::LAYOUT_FULL_WIDTH,
			'page_magazine'                      => self::PAGE_MAGAZINE,
			'layout_static_page'                 => self::LAYOUT_STATIC_PAGE,
			'layout_blog'                        => self::LAYOUT_BLOG,
			'layout_blog_thumbnail_right'        => self::LAYOUT_BLOG_THUMBNAIL_RIGHT,
			'layout_blog_thumbnail_full_width'   => self::LAYOUT_BLOG_THUMBNAIL_FULL_WIDTH,
			'layout_blog_thumbnail_left'         => self::LAYOUT_BLOG_THUMBNAIL_LEFT,
			'taxonomy_prefix'                    => self::TAXONOMY_PREFIX,
		];
	}
}
