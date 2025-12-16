<?php
/**
 * Theme Bootstrap
 *
 * @package Origamiez
 */

namespace Origamiez\Engine;

use Origamiez\Engine\Assets\AssetManager;
use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Config\SkinConfig;
use Origamiez\Engine\Config\LayoutConfig;
use Origamiez\Engine\Config\FontConfig;
use Origamiez\Engine\Customizer\CustomizerService;
use Origamiez\Engine\Customizer\Settings\BlogSettings;
use Origamiez\Engine\Customizer\Settings\ColorSettings;
use Origamiez\Engine\Customizer\Settings\CustomCssSettings;
use Origamiez\Engine\Customizer\Settings\GeneralSettings;
use Origamiez\Engine\Customizer\Settings\LayoutSettings;
use Origamiez\Engine\Customizer\Settings\SinglePostSettings;
use Origamiez\Engine\Customizer\Settings\SocialSettings;
use Origamiez\Engine\Customizer\Settings\TypographySettings;
use Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator;
use Origamiez\Engine\Display\ReadMoreButton;
use Origamiez\Engine\Hooks\HookRegistry;
use Origamiez\Engine\Hooks\Hooks\ThemeHooks;
use Origamiez\Engine\Hooks\Hooks\FrontendHooks;
use Origamiez\Engine\Layout\BodyClassManager;
use Origamiez\Engine\Post\PostClassManager;
use Origamiez\Engine\Widgets\WidgetClassManager;
use Origamiez\Engine\Widgets\WidgetFactory;
use Origamiez\Engine\Widgets\SidebarRegistry;

/**
 * Class ThemeBootstrap
 *
 * @package Origamiez\Engine
 */
class ThemeBootstrap {

	/**
	 * The container instance.
	 *
	 * @var Container
	 */
	private Container $container;

	/**
	 * The config manager instance.
	 *
	 * @var ConfigManager
	 */
	private ConfigManager $configManager;

	/**
	 * The hook registry instance.
	 *
	 * @var HookRegistry
	 */
	private HookRegistry $hookRegistry;

	/**
	 * ThemeBootstrap constructor.
	 */
	public function __construct() {
		$this->container = Container::getInstance();
		$this->setupContainer();
		$this->configManager = $this->container->get( 'config_manager' );
		$this->hookRegistry  = $this->container->get( 'hook_registry' );
	}

	/**
	 * Setup the container.
	 */
	private function setupContainer(): void {
		$this->container->singleton(
			'config_manager',
			function () {
				return ConfigManager::getInstance();
			}
		);

		$this->container->singleton(
			'skin_config',
			function () {
				return new SkinConfig();
			}
		);

		$this->container->singleton(
			'layout_config',
			function () {
				return new LayoutConfig();
			}
		);

		$this->container->singleton(
			'font_config',
			function () {
				return new FontConfig();
			}
		);

		$this->container->singleton(
			'body_class_config',
			function () {
				return new BodyClassConfig();
			}
		);

		$this->container->singleton(
			'hook_registry',
			function () {
				return HookRegistry::getInstance();
			}
		);

		$this->container->singleton(
			'asset_manager',
			function ( $container ) {
				return new AssetManager( $container->get( 'config_manager' ) );
			}
		);

		$this->container->singleton(
			'body_class_manager',
			function ( $container ) {
				return new BodyClassManager( $container->get( 'config_manager' ), $container->get( 'body_class_config' ) );
			}
		);

		$this->container->singleton(
			'breadcrumb_generator',
			function () {
				return new BreadcrumbGenerator();
			}
		);

		$this->container->singleton(
			'customizer_service',
			function () {
				return new CustomizerService();
			}
		);

		$this->container->singleton(
			'widget_factory',
			function () {
				return WidgetFactory::getInstance();
			}
		);

		$this->container->singleton(
			'sidebar_registry',
			function () {
				return SidebarRegistry::getInstance();
			}
		);

		$this->container->singleton(
			'widget_class_manager',
			function () {
				return new WidgetClassManager();
			}
		);

		$this->container->bind(
			'post_class_manager',
			function () {
				return new PostClassManager();
			}
		);

		$this->container->bind(
			'read_more_button',
			function () {
				return new ReadMoreButton();
			}
		);
	}

	/**
	 * Boot the theme.
	 */
	public function boot(): void {
		$this->registerHooks();
		$this->registerAssets();
		$this->registerLayout();
		$this->registerDisplay();
		$this->registerCustomizer();
		$this->registerWidgets();
		$this->registerSidebars();

		do_action( 'origamiez_engine_booted' );
	}

	/**
	 * Register hooks.
	 */
	private function registerHooks(): void {
		$this->hookRegistry->registerHooks( new ThemeHooks() );
		$this->hookRegistry->registerHooks( new FrontendHooks( $this->container ) );
	}

	/**
	 * Register assets.
	 */
	private function registerAssets(): void {
		$assetManager = $this->container->get( 'asset_manager' );
		$assetManager->register();
	}

	/**
	 * Register layout.
	 */
	private function registerLayout(): void {
		$bodyClassManager = $this->container->get( 'body_class_manager' );
		$bodyClassManager->register();
	}

	/**
	 * Register display.
	 */
	private function registerDisplay(): void {
		$breadcrumbGenerator = $this->container->get( 'breadcrumb_generator' );
		$breadcrumbGenerator->register();
	}

	/**
	 * Register customizer.
	 */
	private function registerCustomizer(): void {
		$customizerService = $this->container->get( 'customizer_service' );

		// Register Settings Classes
		$customizerService->addSettingsClass( new GeneralSettings() );
		$customizerService->addSettingsClass( new LayoutSettings() );
		$customizerService->addSettingsClass( new BlogSettings() );
		$customizerService->addSettingsClass( new SinglePostSettings() );
		$customizerService->addSettingsClass( new ColorSettings() );
		$customizerService->addSettingsClass( new CustomCssSettings() );
		$customizerService->addSettingsClass( new SocialSettings() );
		$customizerService->addSettingsClass( new TypographySettings() );

		$customizerService->register();
	}

	/**
	 * Get the container instance.
	 *
	 * @return Container
	 */
	public function getContainer(): Container {
		return $this->container;
	}

	/**
	 * Get the config manager instance.
	 *
	 * @return ConfigManager
	 */
	public function getConfigManager(): ConfigManager {
		return $this->configManager;
	}

	/**
	 * Get the hook registry instance.
	 *
	 * @return HookRegistry
	 */
	public function getHookRegistry(): HookRegistry {
		return $this->hookRegistry;
	}

	/**
	 * Register widgets.
	 */
	private function registerWidgets(): void {
		$widgetFactory = $this->container->get( 'widget_factory' );
		$widgetFactory->boot();
	}

	/**
	 * Register sidebars.
	 */
	private function registerSidebars(): void {
		$sidebarRegistry = $this->container->get( 'sidebar_registry' );
		$sidebarRegistry->registerDefaultSidebars();
		$sidebarRegistry->register();
	}

	/**
	 * Get the widget factory instance.
	 *
	 * @return WidgetFactory
	 */
	public function getWidgetFactory(): WidgetFactory {
		return $this->container->get( 'widget_factory' );
	}

	/**
	 * Get the sidebar registry instance.
	 *
	 * @return SidebarRegistry
	 */
	public function getSidebarRegistry(): SidebarRegistry {
		return $this->container->get( 'sidebar_registry' );
	}
}
