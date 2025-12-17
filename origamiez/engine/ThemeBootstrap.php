<?php
/**
 * Theme Bootstrap
 *
 * @package Origamiez
 */

namespace Origamiez\Engine;

use Origamiez\Engine\Assets\AssetManager;
use Origamiez\Engine\ThemeSupportManager;
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
use Origamiez\Engine\Hooks\Hooks\SecurityHooks;
use Origamiez\Engine\Layout\BodyClassManager;
use Origamiez\Engine\Post\PostClassManager;
use Origamiez\Engine\Widgets\WidgetClassManager;
use Origamiez\Engine\Widgets\WidgetFactory;
use Origamiez\Engine\Widgets\SidebarRegistry;
use Psr\Container\NotFoundExceptionInterface;

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
	private ConfigManager $config_manager;

	/**
	 * The hook registry instance.
	 *
	 * @var HookRegistry
	 */
	private HookRegistry $hook_registry;

	/**
	 * ThemeBootstrap constructor.
	 */
	public function __construct() {
		$this->container = Container::get_instance();
		$this->setup_container();
		$this->config_manager = $this->container->get( 'config_manager' );
		$this->hook_registry  = $this->container->get( 'hook_registry' );
	}

	/**
	 * Setup the container.
	 */
	private function setup_container(): void {
		$this->container->singleton(
			'config_manager',
			function () {
				return ConfigManager::get_instance();
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
				return HookRegistry::get_instance();
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
				return WidgetFactory::get_instance();
			}
		);

		$this->container->singleton(
			'sidebar_registry',
			function () {
				return SidebarRegistry::get_instance();
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
		ThemeSupportManager::register();
		$this->register_hooks();
		$this->register_assets();
		$this->register_layout();
		$this->register_display();
		$this->register_customizer();
		$this->register_widgets();
		$this->register_sidebars();

		do_action( 'origamiez_engine_booted' );
	}

	/**
	 * Register hooks.
	 */
	private function register_hooks(): void {
		$this->hook_registry->register_hooks( new ThemeHooks() );
		$this->hook_registry->register_hooks( new FrontendHooks( $this->container ) );
		$this->hook_registry->register_hooks( new SecurityHooks( $this->container ) );
	}

	/**
	 * Register assets.
	 */
	private function register_assets(): void {
		$asset_manager = $this->container->get( 'asset_manager' );
		$asset_manager->register();
	}

	/**
	 * Register layout.
	 */
	private function register_layout(): void {
		$body_class_manager = $this->container->get( 'body_class_manager' );
		$body_class_manager->register();
	}

	/**
	 * Register display.
	 */
	private function register_display(): void {
		$breadcrumb_generator = $this->container->get( 'breadcrumb_generator' );
		$breadcrumb_generator->register();
	}

	/**
	 * Register customizer.
	 */
	private function register_customizer(): void {
		$customizer_service = $this->container->get( 'customizer_service' );

		// Register Settings Classes.
		$customizer_service->add_settings_class( new GeneralSettings() );
		$customizer_service->add_settings_class( new LayoutSettings() );
		$customizer_service->add_settings_class( new BlogSettings() );
		$customizer_service->add_settings_class( new SinglePostSettings() );
		$customizer_service->add_settings_class( new ColorSettings() );
		$customizer_service->add_settings_class( new CustomCssSettings() );
		$customizer_service->add_settings_class( new SocialSettings() );
		$customizer_service->add_settings_class( new TypographySettings() );

		$customizer_service->register();
	}

	/**
	 * Get the container instance.
	 *
	 * @return Container
	 */
	public function get_container(): Container {
		return $this->container;
	}

	/**
	 * Get the config manager instance.
	 *
	 * @return ConfigManager
	 */
	public function get_config_manager(): ConfigManager {
		return $this->config_manager;
	}

	/**
	 * Get the hook registry instance.
	 *
	 * @return HookRegistry
	 */
	public function get_hook_registry(): HookRegistry {
		return $this->hook_registry;
	}

	/**
	 * Register widgets.
	 */
	private function register_widgets(): void {
		$widget_factory = $this->container->get( 'widget_factory' );
		$widget_factory->boot();
	}

	/**
	 * Register sidebars.
	 */
	private function register_sidebars(): void {
		$sidebar_registry = $this->container->get( 'sidebar_registry' );
		$sidebar_registry->register_default_sidebars();
		$sidebar_registry->register();
	}

	/**
	 * Get the widget factory instance.
	 *
	 * @return WidgetFactory
	 * @throws NotFoundExceptionInterface If the service is not found.
	 */
	public function get_widget_factory(): WidgetFactory {
		return $this->container->get( 'widget_factory' );
	}

	/**
	 * Get the sidebar registry instance.
	 *
	 * @return SidebarRegistry
	 * @throws NotFoundExceptionInterface If the service is not found.
	 */
	public function get_sidebar_registry(): SidebarRegistry {
		return $this->container->get( 'sidebar_registry' );
	}
}
