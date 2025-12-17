<?php
/**
 * Search Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

/**
 * Class SearchClassProvider
 *
 * @package Origamiez\Engine\Layout\Providers
 */
class SearchClassProvider implements BodyClassProviderInterface {

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
	 * SearchClassProvider constructor.
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
		if ( ! is_search() ) {
			return $classes;
		}

		$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->body_class_config::LAYOUT_BLOG;

		return $classes;
	}
}
