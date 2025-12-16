<?php

namespace Origamiez\Engine\Layout;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;

class BodyClassManager {

	private array $providers = array();
	private ConfigManager $configManager;
	private BodyClassConfig $bodyClassConfig;

	public function __construct( ConfigManager $configManager, BodyClassConfig $bodyClassConfig ) {
		$this->configManager   = $configManager;
		$this->bodyClassConfig = $bodyClassConfig;
		$this->registerDefaultProviders();
	}

	private function registerDefaultProviders(): void {
		$this->registerProvider( new Providers\SinglePostClassProvider( $this->configManager, $this->bodyClassConfig ) );
		$this->registerProvider( new Providers\PageClassProvider( $this->configManager, $this->bodyClassConfig ) );
		$this->registerProvider( new Providers\ArchiveClassProvider( $this->configManager, $this->bodyClassConfig ) );
		$this->registerProvider( new Providers\SearchClassProvider( $this->configManager, $this->bodyClassConfig ) );
		$this->registerProvider( new Providers\NotFoundClassProvider( $this->configManager, $this->bodyClassConfig ) );
		$this->registerProvider( new Providers\GeneralClassProvider( $this->configManager, $this->bodyClassConfig ) );
	}

	public function registerProvider( BodyClassProviderInterface $provider ): self {
		$this->providers[] = $provider;
		return $this;
	}

	public function getBodyClasses( array $classes = array() ): array {
		foreach ( $this->providers as $provider ) {
			$classes = $provider->provide( $classes );
		}
		return $classes;
	}

	public function register(): void {
		add_filter( 'body_class', array( $this, 'getBodyClasses' ) );
	}
}
