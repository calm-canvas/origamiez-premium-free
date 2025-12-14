<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class ArchiveClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager = $configManager;
	}

	public function provide( array $classes ): array {
		if ( ! ( is_archive() || is_home() ) ) {
			return $classes;
		}

		$classes[] = 'origamiez-layout-right-sidebar';
		$classes[] = 'origamiez-layout-blog';

		$thumbnailStyle = get_theme_mod( 'taxonomy_thumbnail_style', 'thumbnail-left' );
		switch ( $thumbnailStyle ) {
			case 'thumbnail-right':
				$classes[] = 'origamiez-layout-blog-thumbnail-right';
				break;
			case 'thumbnail-full-width':
				$classes[] = 'origamiez-layout-blog-thumbnail-full-width';
				break;
			default:
				$classes[] = 'origamiez-layout-blog-thumbnail-left';
				break;
		}

		if ( is_home() || is_tag() || is_category() || is_author() || is_day() || is_month() || is_year() ) {
			$taxonomyLayout = get_theme_mod( 'taxonomy_layout', 'two-cols' );
			if ( $taxonomyLayout ) {
				$classes[] = "origamiez-taxonomy-{$taxonomyLayout}";
			}
		}

		return $classes;
	}
}
