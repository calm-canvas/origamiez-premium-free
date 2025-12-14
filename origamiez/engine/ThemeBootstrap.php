<?php

namespace Origamiez\Engine;

use Origamiez\Engine\Assets\AssetManager;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Config\SkinConfig;
use Origamiez\Engine\Config\LayoutConfig;
use Origamiez\Engine\Config\FontConfig;
use Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator;
use Origamiez\Engine\Hooks\HookRegistry;
use Origamiez\Engine\Hooks\Hooks\ThemeHooks;
use Origamiez\Engine\Hooks\Hooks\FrontendHooks;
use Origamiez\Engine\Layout\BodyClassManager;

class ThemeBootstrap {

	private Container $container;
	private ConfigManager $configManager;
	private HookRegistry $hookRegistry;

	public function __construct() {
		$this->container = Container::getInstance();
		$this->setupContainer();
		$this->configManager = $this->container->get( 'config_manager' );
		$this->hookRegistry = $this->container->get( 'hook_registry' );
	}

	private function setupContainer(): void {
		$this->container->singleton( 'config_manager', function () {
			return ConfigManager::getInstance();
		} );

		$this->container->singleton( 'skin_config', function () {
			return new SkinConfig();
		} );

		$this->container->singleton( 'layout_config', function () {
			return new LayoutConfig();
		} );

		$this->container->singleton( 'font_config', function () {
			return new FontConfig();
		} );

		$this->container->singleton( 'hook_registry', function () {
			return HookRegistry::getInstance();
		} );

		$this->container->singleton( 'asset_manager', function ( $container ) {
			return new AssetManager( $container->get( 'config_manager' ) );
		} );

		$this->container->singleton( 'body_class_manager', function ( $container ) {
			return new BodyClassManager( $container->get( 'config_manager' ) );
		} );

		$this->container->singleton( 'breadcrumb_generator', function () {
			return new BreadcrumbGenerator();
		} );
	}

	public function boot(): void {
		$this->registerHooks();
		$this->registerAssets();
		$this->registerLayout();
		$this->registerDisplay();

		do_action( 'origamiez_engine_booted' );
	}

	private function registerHooks(): void {
		$this->hookRegistry->registerHooks( new ThemeHooks() );
		$this->hookRegistry->registerHooks( new FrontendHooks() );
	}

	private function registerAssets(): void {
		$assetManager = $this->container->get( 'asset_manager' );
		$assetManager->register();
	}

	private function registerLayout(): void {
		$bodyClassManager = $this->container->get( 'body_class_manager' );
		$bodyClassManager->register();
	}

	private function registerDisplay(): void {
		$breadcrumbGenerator = $this->container->get( 'breadcrumb_generator' );
		$breadcrumbGenerator->register();
	}

	public function getContainer(): Container {
		return $this->container;
	}

	public function getConfigManager(): ConfigManager {
		return $this->configManager;
	}

	public function getHookRegistry(): HookRegistry {
		return $this->hookRegistry;
	}
}
