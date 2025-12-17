<?php
/**
 * Archive Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

/**
 * Class ArchiveClassProvider
 *
 * @package Origamiez\Engine\Layout\Providers
 */
class ArchiveClassProvider implements BodyClassProviderInterface {

	/**
	 * Config manager.
	 *
	 * @var ConfigManager
	 */
	private ConfigManager $config_manager;
	/**
	 * Body class config.
	 *
	 * @var BodyClassConfig
	 */
	private BodyClassConfig $body_class_config;

	/**
	 * ArchiveClassProvider constructor.
	 *
	 * @param ConfigManager   $config_manager The config manager.
	 * @param BodyClassConfig $body_class_config The body class config.
	 */
	public function __construct( ConfigManager $config_manager, BodyClassConfig $body_class_config ) {
		$this->config_manager    = $config_manager;
		$this->body_class_config = $body_class_config;
	}

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array {
		if ( ! ( is_archive() || is_home() ) ) {
			return $classes;
		}

		$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->body_class_config::LAYOUT_BLOG;

		$thumbnail_style = get_theme_mod( 'taxonomy_thumbnail_style', 'thumbnail-left' );
		switch ( $thumbnail_style ) {
			case 'thumbnail-right':
				$classes[] = $this->body_class_config::LAYOUT_BLOG_THUMBNAIL_RIGHT;
				break;
			case 'thumbnail-full-width':
				$classes[] = $this->body_class_config::LAYOUT_BLOG_THUMBNAIL_FULL_WIDTH;
				break;
			default:
				$classes[] = $this->body_class_config::LAYOUT_BLOG_THUMBNAIL_LEFT;
				break;
		}

		if ( is_home() || is_tag() || is_category() || is_author() || is_day() || is_month() || is_year() ) {
			$taxonomy_layout = get_theme_mod( 'taxonomy_layout', 'two-cols' );
			if ( $taxonomy_layout ) {
				$classes[] = $this->body_class_config::TAXONOMY_PREFIX . $taxonomy_layout;
			}
		}

		return $classes;
	}
}
