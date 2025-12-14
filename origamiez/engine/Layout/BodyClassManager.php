<?php

namespace Origamiez\Engine\Layout;

use Origamiez\Engine\Config\ConfigManager;

class BodyClassManager {

	private array $providers = [];
	private ConfigManager $configManager;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager = $configManager;
		$this->registerDefaultProviders();
	}

	private function registerDefaultProviders(): void {
		$this->registerProvider( new Providers\SinglePostClassProvider( $this->configManager ) );
		$this->registerProvider( new Providers\PageClassProvider( $this->configManager ) );
		$this->registerProvider( new Providers\ArchiveClassProvider( $this->configManager ) );
		$this->registerProvider( new Providers\SearchClassProvider( $this->configManager ) );
		$this->registerProvider( new Providers\NotFoundClassProvider( $this->configManager ) );
		$this->registerProvider( new Providers\GeneralClassProvider( $this->configManager ) );
	}

	public function registerProvider( BodyClassProviderInterface $provider ): self {
		$this->providers[] = $provider;
		return $this;
	}

	public function getBodyClasses( array $classes = [] ): array {
		foreach ( $this->providers as $provider ) {
			$classes = $provider->provide( $classes );
		}
		return $classes;
	}

	public function register(): void {
		add_filter( 'body_class', [ $this, 'getBodyClasses' ] );
	}
}
