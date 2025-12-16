<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class ArchiveClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;
	private BodyClassConfig $bodyClassConfig;

	public function __construct( ConfigManager $configManager, BodyClassConfig $bodyClassConfig ) {
		$this->configManager = $configManager;
		$this->bodyClassConfig = $bodyClassConfig;
	}

	public function provide( array $classes ): array {
		if ( ! ( is_archive() || is_home() ) ) {
			return $classes;
		}

		$classes[] = $this->bodyClassConfig::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->bodyClassConfig::LAYOUT_BLOG;

		$thumbnailStyle = get_theme_mod( 'taxonomy_thumbnail_style', 'thumbnail-left' );
		switch ( $thumbnailStyle ) {
			case 'thumbnail-right':
				$classes[] = $this->bodyClassConfig::LAYOUT_BLOG_THUMBNAIL_RIGHT;
				break;
			case 'thumbnail-full-width':
				$classes[] = $this->bodyClassConfig::LAYOUT_BLOG_THUMBNAIL_FULL_WIDTH;
				break;
			default:
				$classes[] = $this->bodyClassConfig::LAYOUT_BLOG_THUMBNAIL_LEFT;
				break;
		}

		if ( is_home() || is_tag() || is_category() || is_author() || is_day() || is_month() || is_year() ) {
			$taxonomyLayout = get_theme_mod( 'taxonomy_layout', 'two-cols' );
			if ( $taxonomyLayout ) {
				$classes[] = $this->bodyClassConfig::TAXONOMY_PREFIX . $taxonomyLayout;
			}
		}

		return $classes;
	}
}
