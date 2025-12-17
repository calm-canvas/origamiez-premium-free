<?php
/**
 * Single Post Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

/**
 * Class SinglePostClassProvider
 *
 * @package Origamiez\Engine\Layout\Providers
 */
class SinglePostClassProvider implements BodyClassProviderInterface {

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
	 * SinglePostClassProvider constructor.
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
		if ( ! is_single() ) {
			return $classes;
		}

		$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->body_class_config::LAYOUT_SINGLE;

		if ( 1 === (int) get_theme_mod( 'is_show_border_for_images', 1 ) ) {
			$classes[] = $this->body_class_config::SHOW_BORDER_FOR_IMAGES;
		}

		$single_post_layout = get_theme_mod( 'single-post-layout', 'two-cols' );
		$classes[]          = $this->body_class_config::SINGLE_POST_LAYOUT_PREFIX . $single_post_layout;

		return $classes;
	}
}
