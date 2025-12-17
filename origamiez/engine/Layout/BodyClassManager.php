<?php
/**
 * Body Class Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;

/**
 * Class BodyClassManager
 *
 * @package Origamiez\Engine\Layout
 */
class BodyClassManager {

	/**
	 * Providers.
	 *
	 * @var array
	 */
	private array $providers = array();
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
	 * BodyClassManager constructor.
	 *
	 * @param ConfigManager   $config_manager The config manager.
	 * @param BodyClassConfig $body_class_config The body class config.
	 */
	public function __construct( ConfigManager $config_manager, BodyClassConfig $body_class_config ) {
		$this->config_manager    = $config_manager;
		$this->body_class_config = $body_class_config;
		$this->register_default_providers();
	}

	/**
	 * Register default providers.
	 *
	 * @return void
	 */
	private function register_default_providers(): void {
		$this->register_provider( new Providers\SinglePostClassProvider( $this->config_manager, $this->body_class_config ) );
		$this->register_provider( new Providers\PageClassProvider( $this->config_manager, $this->body_class_config ) );
		$this->register_provider( new Providers\ArchiveClassProvider( $this->config_manager, $this->body_class_config ) );
		$this->register_provider( new Providers\SearchClassProvider( $this->config_manager, $this->body_class_config ) );
		$this->register_provider( new Providers\NotFoundClassProvider( $this->config_manager, $this->body_class_config ) );
		$this->register_provider( new Providers\GeneralClassProvider( $this->config_manager, $this->body_class_config ) );
	}

	/**
	 * Register provider.
	 *
	 * @param BodyClassProviderInterface $provider The provider.
	 *
	 * @return self
	 */
	public function register_provider( BodyClassProviderInterface $provider ): self {
		$this->providers[] = $provider;
		return $this;
	}

	/**
	 * Get body classes.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function get_body_classes( array $classes = array() ): array {
		foreach ( $this->providers as $provider ) {
			$classes = $provider->provide( $classes );
		}
		return $classes;
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register(): void {
		add_filter( 'body_class', array( $this, 'get_body_classes' ) );
	}
}
