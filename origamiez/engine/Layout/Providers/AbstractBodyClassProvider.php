<?php
/**
 * Abstract Body Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

/**
 * Abstract class AbstractBodyClassProvider
 *
 * Base class for body class providers that eliminates duplicate constructor
 * and dependency injection code.
 *
 * @package Origamiez\Engine\Layout\Providers
 */
abstract class AbstractBodyClassProvider implements BodyClassProviderInterface {

	/**
	 * Configuration manager.
	 *
	 * @var ConfigManager
	 */
	protected ConfigManager $config_manager;

	/**
	 * Body class configuration.
	 *
	 * @var BodyClassConfig
	 */
	protected BodyClassConfig $body_class_config;

	/**
	 * AbstractBodyClassProvider constructor.
	 *
	 * @param ConfigManager   $config_manager The config manager.
	 * @param BodyClassConfig $body_class_config The body class config.
	 */
	public function __construct( ConfigManager $config_manager, BodyClassConfig $body_class_config ) {
		$this->config_manager    = $config_manager;
		$this->body_class_config = $body_class_config;
	}
}
