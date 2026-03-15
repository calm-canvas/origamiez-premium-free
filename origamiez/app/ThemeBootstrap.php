<?php
/**
 * Theme Bootstrap
 *
 * @package Origamiez
 */

namespace Origamiez;

use Origamiez\Assets\AssetManager;
use Origamiez\ThemeSupportManager;
use Origamiez\Config\BodyClassConfig;
use Origamiez\Config\ConfigManager;
use Origamiez\Config\SkinConfig;
use Origamiez\Config\LayoutConfig;
use Origamiez\Config\FontConfig;
use Origamiez\Customizer\CustomizerService;
use Origamiez\Customizer\Settings\BlogSettings;
use Origamiez\Customizer\Settings\ColorSettings;
use Origamiez\Customizer\Settings\CustomCssSettings;
use Origamiez\Customizer\Settings\GeneralSettings;
use Origamiez\Customizer\Settings\LayoutSettings;
use Origamiez\Customizer\Settings\SinglePostSettings;
use Origamiez\Customizer\Settings\SocialSettings;
use Origamiez\Customizer\Settings\TypographySettings;
use Origamiez\Display\Breadcrumb\BreadcrumbGenerator;
use Origamiez\Display\ReadMoreButton;
use Origamiez\Hooks\HookRegistry;
use Origamiez\Hooks\Hooks\ThemeHooks;
use Origamiez\Hooks\Hooks\FrontendHooks;
use Origamiez\Hooks\Hooks\SecurityHooks;
use Origamiez\Hooks\Plugins\BbpressHooks;
use Origamiez\Hooks\Plugins\WoocommerceHooks;
use Origamiez\Layout\BodyClassManager;
use Origamiez\Post\PostClassManager;
use Origamiez\Widgets\WidgetClassManager;
use Origamiez\Widgets\WidgetFactory;
use Origamiez\Widgets\SidebarRegistry;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

/**
 * Class ThemeBootstrap
 *
 * @package Origamiez
 */
class ThemeBootstrap {

	/**
	 * The container instance.
	 *
	 * @var ContainerInterface
	 */
	private ContainerInterface $container;

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
		$builder = new ContainerBuilder();
		$builder->addDefinitions( __DIR__ . '/Core/di-definitions.php' );
		$this->container      = $builder->build();
		$this->config_manager = $this->container->get( 'config_manager' );
		$this->hook_registry  = $this->container->get( 'hook_registry' );
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
		$this->hook_registry->register_hooks( new BbpressHooks() );
		$this->hook_registry->register_hooks( new WoocommerceHooks() );
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
	 * @return ContainerInterface
	 */
	public function get_container(): ContainerInterface {
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
