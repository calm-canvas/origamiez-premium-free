<?php
/**
 * Body Class Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class BodyClassConfig
 *
 * Configuration class that defines all CSS body class constants used throughout
 * the theme for layout, styling, and feature toggling.
 *
 * These constants should be used directly instead of storing in arrays.
 */
class BodyClassConfig {

	public const CUSTOM_BG             = 'origamiez_custom_bg';
	public const WITHOUT_BG_SLIDES     = 'without_bg_slides';
	public const LAYOUT_BOXER          = 'origamiez-boxer';
	public const LAYOUT_FLUID          = 'origamiez-fluid';
	public const SHOW_FOOTER_AREA      = 'origamiez-show-footer-area';
	public const SKIN_PREFIX           = 'origamiez-skin-';
	public const HEADER_STYLE_PREFIX   = 'origamiez-header-style-';
	public const MISSING_SIDEBAR_RIGHT = 'origamiez-missing-sidebar-right';
	public const MISSING_SIDEBAR_LEFT  = 'origamiez-missing-sidebar-left';

	public const LAYOUT_RIGHT_SIDEBAR      = 'origamiez-layout-right-sidebar';
	public const LAYOUT_SINGLE             = 'origamiez-layout-single';
	public const SHOW_BORDER_FOR_IMAGES    = 'origamiez-show-border-for-images';
	public const SINGLE_POST_LAYOUT_PREFIX = 'origamiez-single-post-';

	public const LAYOUT_FULL_WIDTH  = 'origamiez-layout-full-width';
	public const PAGE_MAGAZINE      = 'origamiez-page-magazine';
	public const LAYOUT_STATIC_PAGE = 'origamiez-layout-static-page';

	public const LAYOUT_BLOG                      = 'origamiez-layout-blog';
	public const LAYOUT_BLOG_THUMBNAIL_RIGHT      = 'origamiez-layout-blog-thumbnail-right';
	public const LAYOUT_BLOG_THUMBNAIL_FULL_WIDTH = 'origamiez-layout-blog-thumbnail-full-width';
	public const LAYOUT_BLOG_THUMBNAIL_LEFT       = 'origamiez-layout-blog-thumbnail-left';
	public const TAXONOMY_PREFIX                  = 'origamiez-taxonomy-';
}
