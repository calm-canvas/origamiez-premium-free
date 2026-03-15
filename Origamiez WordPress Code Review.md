## User

Act as an Expert WordPress & Modern PHP Engineer. I need you to conduct a comprehensive code review and propose a detailed refactoring plan for the source code located in the `./origamiez` directory.

### 🎯 Objective
Identify code smells, hidden bugs, redundant logic, and architectural inconsistencies. Create a structured, step-by-step refactoring plan to elevate the codebase to modern engineering standards.

### 🔎 Scope
- **FOCUS ONLY ON:** PHP files, WordPress core integration, and theme architecture.
- **IGNORE:** Frontend assets (CSS, SCSS, JS, TS) and UI design.

### ⚖️ Review Criteria & Rules
You must strictly evaluate the code against the principles of Clean Code (DRY, SOLID, no overlapping logic) and the project's specific `AGENTS.md` rules:

1. **Architecture & Patterns:**
   - Verify that core logic resides in `app/` and utilizes **PSR-4 autoloading**.
   - Check if **Dependency Injection** (via `php-di`) is being correctly used instead of tightly coupled classes or global singletons.
   - Ensure hooks are centralized through the `HookRegistry`. Flag any manual, scattered `add_action` or `add_filter` calls outside of this system.
   - Verify that UI components properly use `get_template_part()` and reside in `parts/`.

2. **Coding Standards & Naming (WPCS):**
   - Classes must be `PascalCase`; Methods/Variables must be `snake_case`.
   - Global functions and constants must be prefixed with `origamiez_`.
   - Ensure compliance with WordPress Coding Standards (WPCS).

3. **Performance & Modernization:**
   - PHP code should be optimized for **PHP 8.3+** (while maintaining 7.4+ compatibility). Look for deprecated PHP functions or outdated WP practices.
   - Check for redundant database queries, N+1 query problems, and missing caching mechanisms.

4. **Code Quality & Security:**
   - Spot hidden bugs, edge-case failures, and logic conflicts.
   - Ensure rigorous WordPress security practices (proper data sanitization, escaping, and nonce verification).

### 📋 Expected Output Format
Please structure your response into the following sections:

1. **🚨 Critical Issues & Hidden Bugs:** (Security risks, fatal errors, PHP 8.3 incompatibilities).
2. **🏗️ Architectural Violations:** (Places where `AGENTS.md` rules like DI, HookRegistry, or PSR-4 are broken).
3. **👃 Code Smells & Clean Code Suggestions:** (Redundant code, violations of DRY, bloated classes/methods).
4. **🛠️ Step-by-Step Refactoring Plan:** Provide a logical, prioritized roadmap to fix the findings. Break it down into phases (e.g., Phase 1: Security & Bugs, Phase 2: Architectural Alignment, Phase 3: Cleanup & DRY). Include short code snippets showing the "Before" and "After" for complex refactoring points.

Please start your review by scanning the PHP files in `./origamiez`. Ask me to provide specific file contents if you need to deep-dive into certain directories.

**Tool Call: List the `origamiez-premium-free/origamiez` directory's contents**
Status: Completed

# Folders:
origamiez-premium-free/origamiez/blocks
origamiez-premium-free/origamiez/css
origamiez-premium-free/origamiez/engine
origamiez-premium-free/origamiez/images
origamiez-premium-free/origamiez/inc
origamiez-premium-free/origamiez/js
origamiez-premium-free/origamiez/languages
origamiez-premium-free/origamiez/parts
origamiez-premium-free/origamiez/patterns
origamiez-premium-free/origamiez/plugins
origamiez-premium-free/origamiez/templates
origamiez-premium-free/origamiez/vendor
origamiez-premium-free/origamiez/webfonts

# Files:
origamiez-premium-free/origamiez/404.php
origamiez-premium-free/origamiez/archive.php
origamiez-premium-free/origamiez/comments.php
origamiez-premium-free/origamiez/composer.json
origamiez-premium-free/origamiez/composer.lock
origamiez-premium-free/origamiez/content-none.php
origamiez-premium-free/origamiez/content.php
origamiez-premium-free/origamiez/editor-style.css
origamiez-premium-free/origamiez/footer-1.php
origamiez-premium-free/origamiez/footer-2.php
origamiez-premium-free/origamiez/footer-3.php
origamiez-premium-free/origamiez/footer-4.php
origamiez-premium-free/origamiez/footer-shop.php
origamiez-premium-free/origamiez/footer.php
origamiez-premium-free/origamiez/functions.php
origamiez-premium-free/origamiez/header-shop.php
origamiez-premium-free/origamiez/header.php
origamiez-premium-free/origamiez/home.php
origamiez-premium-free/origamiez/index.php
origamiez-premium-free/origamiez/license.txt
origamiez-premium-free/origamiez/page.php
origamiez-premium-free/origamiez/pagination.php
origamiez-premium-free/origamiez/readme.txt
origamiez-premium-free/origamiez/screenshot.png
origamiez-premium-free/origamiez/search.php
origamiez-premium-free/origamiez/searchform.php
origamiez-premium-free/origamiez/sidebar-bottom.php
origamiez-premium-free/origamiez/sidebar-footer-1.php
origamiez-premium-free/origamiez/sidebar-footer-2.php
origamiez-premium-free/origamiez/sidebar-footer-3.php
origamiez-premium-free/origamiez/sidebar-footer-4.php
origamiez-premium-free/origamiez/sidebar-footer-5.php
origamiez-premium-free/origamiez/sidebar-left.php
origamiez-premium-free/origamiez/sidebar-main-bottom.php
origamiez-premium-free/origamiez/sidebar-main-center-bottom.php
origamiez-premium-free/origamiez/sidebar-main-center-left.php
origamiez-premium-free/origamiez/sidebar-main-center-right.php
origamiez-premium-free/origamiez/sidebar-main-center-top.php
origamiez-premium-free/origamiez/sidebar-main-top.php
origamiez-premium-free/origamiez/sidebar-middle-clone.php
origamiez-premium-free/origamiez/sidebar-middle.php
origamiez-premium-free/origamiez/sidebar-right.php
origamiez-premium-free/origamiez/sidebar.php
origamiez-premium-free/origamiez/single.php
origamiez-premium-free/origamiez/style.css
origamiez-premium-free/origamiez/template-page-fullwidth-centered.php
origamiez-premium-free/origamiez/template-page-fullwidth.php
origamiez-premium-free/origamiez/template-page-magazine.php
origamiez-premium-free/origamiez/template-page-three-cols-slm.php
origamiez-premium-free/origamiez/template-page-three-cols.php
origamiez-premium-free/origamiez/theme.json


## Assistant



**Tool Call: List the `origamiez-premium-free` directory's contents**
Status: Completed

# Folders:
origamiez-premium-free/.idea
origamiez-premium-free/.zencoder
origamiez-premium-free/.zenflow
origamiez-premium-free/assets
origamiez-premium-free/bin
origamiez-premium-free/docker
origamiez-premium-free/docs
origamiez-premium-free/node_modules
origamiez-premium-free/origamiez
origamiez-premium-free/plugins
origamiez-premium-free/vendor

# Files:
origamiez-premium-free/.dockerignore
origamiez-premium-free/.eslintignore
origamiez-premium-free/.eslintrc.json
origamiez-premium-free/.gitignore
origamiez-premium-free/.gitmodules
origamiez-premium-free/.phpactor.json
origamiez-premium-free/.phpcs.xml.dist
origamiez-premium-free/.prettierignore
origamiez-premium-free/.prettierrc.cjs
origamiez-premium-free/AGENTS.md
origamiez-premium-free/LICENSE.md
origamiez-premium-free/Makefile
origamiez-premium-free/README.md
origamiez-premium-free/composer.json
origamiez-premium-free/composer.lock
origamiez-premium-free/docker-compose.override.yml
origamiez-premium-free/docker-compose.yml
origamiez-premium-free/package-lock.json
origamiez-premium-free/package.json
origamiez-premium-free/pnpm-lock.yaml
origamiez-premium-free/style.scss
origamiez-premium-free/vite.config.js


## Assistant



**Tool Call: grep -rnw 'origamiez' -e 'Container' -e 'app/Core' -e 'HookRegistry' -e 'php-di'**
Status: Completed

Terminal:
```
origamiez/composer.lock:34:                    "Psr\\Container\\": "src/"
origamiez/composer.lock:47:            "description": "Common Container Interface (PHP FIG PSR-11)",
origamiez/engine/ThemeBootstrap.php:28:use Origamiez\Engine\Hooks\HookRegistry;
origamiez/engine/ThemeBootstrap.php:37:use Psr\Container\NotFoundExceptionInterface;
origamiez/engine/ThemeBootstrap.php:49:	 * @var Container
origamiez/engine/ThemeBootstrap.php:51:	private Container $container;
origamiez/engine/ThemeBootstrap.php:63:	 * @var HookRegistry
origamiez/engine/ThemeBootstrap.php:65:	private HookRegistry $hook_registry;
origamiez/engine/ThemeBootstrap.php:71:		$this->container = Container::get_instance();
origamiez/engine/ThemeBootstrap.php:119:			return HookRegistry::get_instance();
origamiez/engine/ThemeBootstrap.php:258:	 * @return Container
origamiez/engine/ThemeBootstrap.php:260:	public function get_container(): Container {
origamiez/engine/ThemeBootstrap.php:276:	 * @return HookRegistry
origamiez/engine/ThemeBootstrap.php:278:	public function get_hook_registry(): HookRegistry {
origamiez/engine/Container.php:3: * PSR-11 Container
origamiez/engine/Container.php:11:use Psr\Container\ContainerInterface;
origamiez/engine/Container.php:12:use Psr\Container\NotFoundExceptionInterface;
origamiez/engine/Container.php:13:use Psr\Container\ContainerExceptionInterface;
origamiez/engine/Container.php:20:class Container implements ContainerInterface {
origamiez/engine/Container.php:44:	 * Container constructor.
origamiez/engine/Layout/LayoutContainer.php:3: * Layout Container
origamiez/engine/Hooks/HookProviderInterface.php:20:	 * @param HookRegistry $registry The registry.
origamiez/engine/Hooks/HookProviderInterface.php:24:	public function register( HookRegistry $registry ): void;
origamiez/engine/Hooks/HookRegistry.php:11: * Class HookRegistry
origamiez/engine/Hooks/HookRegistry.php:15:class HookRegistry {
origamiez/engine/Hooks/Hooks/SecurityHooks.php:10:use Origamiez\Engine\Container;
origamiez/engine/Hooks/Hooks/SecurityHooks.php:12:use Origamiez\Engine\Hooks\HookRegistry;
origamiez/engine/Hooks/Hooks/SecurityHooks.php:22:	 * Container
origamiez/engine/Hooks/Hooks/SecurityHooks.php:24:	 * @var Container
origamiez/engine/Hooks/Hooks/SecurityHooks.php:26:	private Container $container;
origamiez/engine/Hooks/Hooks/SecurityHooks.php:31:	 * @param Container $container The container.
origamiez/engine/Hooks/Hooks/SecurityHooks.php:33:	public function __construct( Container $container ) {
origamiez/engine/Hooks/Hooks/SecurityHooks.php:40:	 * @param HookRegistry $registry The registry.
origamiez/engine/Hooks/Hooks/SecurityHooks.php:44:	public function register( HookRegistry $registry ): void {
origamiez/engine/Hooks/Hooks/FrontendHooks.php:10:use Origamiez\Engine\Container;
origamiez/engine/Hooks/Hooks/FrontendHooks.php:12:use Origamiez\Engine\Hooks\HookRegistry;
origamiez/engine/Hooks/Hooks/FrontendHooks.php:22:	 * Container
origamiez/engine/Hooks/Hooks/FrontendHooks.php:24:	 * @var Container
origamiez/engine/Hooks/Hooks/FrontendHooks.php:26:	private Container $container;
origamiez/engine/Hooks/Hooks/FrontendHooks.php:31:	 * @param Container $container The container.
origamiez/engine/Hooks/Hooks/FrontendHooks.php:33:	public function __construct( Container $container ) {
origamiez/engine/Hooks/Hooks/FrontendHooks.php:40:	 * @param HookRegistry $registry The registry.
origamiez/engine/Hooks/Hooks/FrontendHooks.php:44:	public function register( HookRegistry $registry ): void {
origamiez/engine/Hooks/Hooks/ThemeHooks.php:11:use Origamiez\Engine\Hooks\HookRegistry;
origamiez/engine/Hooks/Hooks/ThemeHooks.php:23:	 * @param HookRegistry $registry The registry.
origamiez/engine/Hooks/Hooks/ThemeHooks.php:27:	public function register( HookRegistry $registry ): void {
origamiez/vendor/composer/autoload_psr4.php:9:    'Psr\\Container\\' => array($vendorDir . '/psr/container/src'),
origamiez/vendor/composer/autoload_static.php:12:            'Psr\\Container\\' => 14,
origamiez/vendor/composer/autoload_static.php:22:        'Psr\\Container\\' =>
origamiez/vendor/composer/installed.json:31:                    "Psr\\Container\\": "src/"
origamiez/vendor/composer/installed.json:44:            "description": "Common Container Interface (PHP FIG PSR-11)",
origamiez/vendor/psr/container/README.md:1:Container interface
origamiez/vendor/psr/container/README.md:4:This repository holds all interfaces related to [PSR-11 (Container Interface)][psr-url].
origamiez/vendor/psr/container/README.md:6:Note that this is not a Container implementation of its own. It is merely abstractions that describe the components of a Dependency Injection Container.
origamiez/vendor/psr/container/composer.json:4:    "description": "Common Container Interface (PHP FIG PSR-11)",
origamiez/vendor/psr/container/composer.json:19:            "Psr\\Container\\": "src/"
origamiez/vendor/psr/container/src/NotFoundExceptionInterface.php:3:namespace Psr\Container;
origamiez/vendor/psr/container/src/ContainerInterface.php:5:namespace Psr\Container;
origamiez/vendor/psr/container/src/ContainerExceptionInterface.php:3:namespace Psr\Container;

```


## Assistant



**Tool Call: Read file `origamiez/composer.json`**
Status: Completed

```origamiez-premium-free/origamiez/composer.json
{
	"name": "tranthethang/origamiez",
	"type": "project",
	"license": "GPL v3",
	"authors": [
		{
			"name": "tranthethang",
			"email": "tranthethang@gmail.com"
		}
	],
	"require": {
		"psr/container": "^2.0"
	},
	"autoload": {
		"psr-4": {
			"Origamiez\\": "app/",
			"Origamiez\\Engine\\": "engine/"
		}
	}
}

```


## Assistant



**Tool Call: Read file `origamiez/engine/Container.php`**
Status: Completed

```origamiez-premium-free/origamiez/engine/Container.php
<?php
/**
 * PSR-11 Container
 *
 * @package Origamiez
 */

namespace Origamiez\Engine;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use ReflectionClass;
use ReflectionException;

/**
 * A simple PSR-11 container.
 */
class Container implements ContainerInterface {

	/**
	 * The container's services.
	 *
	 * @var array
	 */
	private array $services = array();

	/**
	 * The container's singletons.
	 *
	 * @var array
	 */
	private array $singletons = array();

	/**
	 * The container's instance.
	 *
	 * @var self|null
	 */
	private static ?self $instance = null;

	/**
	 * Container constructor.
	 */
	private function __construct() {
	}

	/**
	 * Get the container instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Set a service.
	 *
	 * @param string $id The service ID.
	 * @param mixed  $definition The service definition.
	 */
	public function set( string $id, mixed $definition ): void {
		$this->services[ $id ] = $definition;
		unset( $this->singletons[ $id ] );
	}

	/**
	 * Get a service.
	 *
	 * @param string $id The service ID.
	 * @return mixed
	 * @throws Exception If the service is not found.
	 */
	public function get( string $id ): mixed {
		if ( ! $this->has( $id ) ) {
			// translators: %s is the service ID.
			$message = sprintf( esc_html__( 'Service %s not found in container', 'origamiez' ), esc_html( $id ) );
			$e       = new class( $message ) extends Exception implements NotFoundExceptionInterface {
			};
			throw $e;
		}

		if ( isset( $this->singletons[ $id ] ) && true !== $this->singletons[ $id ] ) {
			return $this->singletons[ $id ];
		}

		$definition = $this->services[ $id ];

		if ( is_callable( $definition ) ) {
			$instance = $definition( $this );
		} else {
			$instance = $definition;
		}

		if ( $this->isSingleton( $id ) ) {
			$this->singletons[ $id ] = $instance;
		}

		return $instance;
	}

	/**
	 * Check if a service exists.
	 *
	 * @param string $id The service ID.
	 * @return bool
	 */
	public function has( string $id ): bool {
		return isset( $this->services[ $id ] );
	}

	/**
	 * Set a singleton service.
	 *
	 * @param string $id The service ID.
	 * @param mixed  $definition The service definition.
	 */
	public function singleton( string $id, mixed $definition ): void {
		$this->set( $id, $definition );
		$this->singletons[ $id ] = true;
	}

	/**
	 * Check if a service is a singleton.
	 *
	 * @param string $id The service ID.
	 * @return bool
	 */
	private function isSingleton( string $id ): bool {
		return isset( $this->singletons[ $id ] ) && true === $this->singletons[ $id ];
	}

	/**
	 * Bind a service.
	 *
	 * @param string $id The service ID.
	 * @param mixed  $implementation The service implementation.
	 */
	public function bind( string $id, $implementation ): void {
		if ( is_string( $implementation ) && class_exists( $implementation ) ) {
			$this->set(
				$id,
				function () use ( $implementation ) {
					return new $implementation();
				}
			);
		} else {
			$this->set( $id, $implementation );
		}
	}

	/**
	 * Make a service.
	 *
	 * @param string $id The service ID.
	 * @param array  $parameters The service parameters.
	 * @return mixed
	 * @throws ContainerExceptionInterface If there is an error while making the service.
	 * @throws NotFoundExceptionInterface If the service is not found.
	 * @throws ReflectionException If the class does not exist.
	 */
	public function make( string $id, array $parameters = array() ): mixed {
		if ( ! class_exists( $id ) ) {
			return $this->get( $id );
		}

		if ( empty( $parameters ) ) {
			return new $id();
		}

		$reflection = new ReflectionClass( $id );
		return $reflection->newInstanceArgs( $parameters );
	}
}

```


## Assistant



**Tool Call: Read file `origamiez/functions.php`**
Status: Completed

```origamiez-premium-free/origamiez/functions.php
<?php
/**
 * Origamiez functions and definitions
 *
 * @package Origamiez
 */

use Origamiez\Engine\ThemeBootstrap;

const ORIGAMIEZ_PREFIX  = 'origamiez_';
const ORIGAMIEZ_VERSION = '4.0.0';
$dir                    = trailingslashit( get_template_directory() );

require_once $dir . '/vendor/autoload.php';

add_action(
	'after_setup_theme',
	function () {
		$bootstrap = new ThemeBootstrap();
		$bootstrap->boot();
	}
);

/*
HOOK CALLBACK
--------------------
All callback functions for action hooks & filter hooks.
--------------------
*/
require_once $dir . 'inc/config.php';
require $dir . 'inc/functions.php';

/*
PLUGINS
--------------------
Setup - config for compatible plugins.
--------------------
*/
require $dir . 'plugins/bbpress/index.php';

require $dir . 'plugins/woocommerce/index.php';

```


## Assistant



**Tool Call: Read file `origamiez/engine/ThemeBootstrap.php`**
Status: Completed

```origamiez-premium-free/origamiez/engine/ThemeBootstrap.php
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

```


## Assistant



**Tool Call: List the `origamiez-premium-free/origamiez/app` directory's contents**
Status: Failed

Path not found: origamiez-premium-free/origamiez/app

## Assistant



**Tool Call: Read file `origamiez/inc/functions.php`**
Status: Completed

```origamiez-premium-free/origamiez/inc/functions.php
<?php // phpcs:ignore WordPress.Commenting.FileComment.Missing
/**
 * Origamiez functions and definitions
 *
 * @package Origamiez
 */

require_once __DIR__ . '/customizer-callbacks.php';
require_once __DIR__ . '/format-helpers.php';
require_once __DIR__ . '/author-social.php';
require_once __DIR__ . '/font-customizer.php';
require_once __DIR__ . '/footer-helpers.php';
require_once __DIR__ . '/misc-helpers.php';

```


## Assistant



**Tool Call: List the `origamiez-premium-free/origamiez/inc` directory's contents**
Status: Completed


# Files:
origamiez-premium-free/origamiez/inc/author-social.php
origamiez-premium-free/origamiez/inc/config.php
origamiez-premium-free/origamiez/inc/customizer-callbacks.php
origamiez-premium-free/origamiez/inc/font-customizer.php
origamiez-premium-free/origamiez/inc/footer-helpers.php
origamiez-premium-free/origamiez/inc/format-helpers.php
origamiez-premium-free/origamiez/inc/functions.php
origamiez-premium-free/origamiez/inc/misc-helpers.php


## Assistant



**Tool Call: Read file `origamiez/inc/config.php`**
Status: Completed

```origamiez-premium-free/origamiez/inc/config.php
<?php
/**
 * Central Configuration
 *
 * @package Origamiez
 */

if ( ! defined( 'ORIGAMIEZ_CONFIG' ) ) {
	define(
		'ORIGAMIEZ_CONFIG',
		array(
			'theme_support' => array(
				'custom_background' => array(
					'default-color'      => '',
					'default-attachment' => 'fixed',
				),
				'custom_header'     => array(
					'header-text' => false,
					'width'       => 468,
					'height'      => 60,
					'flex-height' => true,
					'flex-width'  => true,
				),
				'content_width'     => 817,
				'post_formats'      => array( 'gallery', 'video', 'audio' ),
			),
			'sidebars'      => array(
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">',
				'after_title'   => '</span></h2><div class="origamiez-widget-content clearfix">',
			),
			'security'      => array(
				'headers' => array(
					'X-Content-Type-Options' => 'nosniff',
					'X-Frame-Options'        => 'SAMEORIGIN',
					'X-XSS-Protection'       => '1; mode=block',
					'Referrer-Policy'        => 'strict-origin-when-cross-origin',
				),
				'csp'     => array(
					'default-src' => "'self'",
					'script-src'  => "'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com",
					'style-src'   => "'self' 'unsafe-inline' *.googleapis.com *.gstatic.com",
					'img-src'     => "'self' data: *.gravatar.com *.wp.com",
					'font-src'    => "'self' *.googleapis.com *.gstatic.com",
					'connect-src' => "'self'",
					'frame-src'   => "'self' *.youtube.com *.vimeo.com",
					'object-src'  => "'none'",
					'base-uri'    => "'self'",
				),
			),
			'socials'       => array(
				'behance'        => array(
					'icon'  => 'fa-brands fa-behance',
					'label' => 'Behance',
					'color' => '#1769ff',
				),
				'bitbucket'      => array(
					'icon'  => 'fa-brands fa-bitbucket',
					'label' => 'Bitbucket',
					'color' => '#0052cc',
				),
				'codepen'        => array(
					'icon'  => 'fa-brands fa-codepen',
					'label' => 'CodePen',
					'color' => '#000000',
				),
				'deviantart'     => array(
					'icon'  => 'fa-brands fa-deviantart',
					'label' => 'DeviantArt',
					'color' => '#05cc47',
				),
				'digg'           => array(
					'icon'  => 'fa-brands fa-digg',
					'label' => 'Digg',
					'color' => '#0d5b7a',
				),
				'dribbble'       => array(
					'icon'  => 'fa-brands fa-dribbble',
					'label' => 'Dribbble',
					'color' => '#ea4c89',
				),
				'email'          => array(
					'icon'  => 'fa-solid fa-envelope',
					'label' => 'Email',
					'color' => '#0078d4',
				),
				'flickr'         => array(
					'icon'  => 'fa-brands fa-flickr',
					'label' => 'Flickr',
					'color' => '#0063dc',
				),
				'foursquare'     => array(
					'icon'  => 'fa-brands fa-foursquare',
					'label' => 'Foursquare',
					'color' => '#fa7343',
				),
				'git'            => array(
					'icon'  => 'fa-brands fa-git',
					'label' => 'Git',
					'color' => '#f1502f',
				),
				'github'         => array(
					'icon'  => 'fa-brands fa-github',
					'label' => 'Github',
					'color' => '#333333',
				),
				'google-plus'    => array(
					'icon'  => 'fa-brands fa-google-plus',
					'label' => 'Google Plus',
					'color' => '#ea4335',
				),
				'instagram'      => array(
					'icon'  => 'fa-brands fa-instagram',
					'label' => 'Instagram',
					'color' => '#e4405f',
				),
				'jsfiddle'       => array(
					'icon'  => 'fa-brands fa-jsfiddle',
					'label' => 'JsFiddle',
					'color' => '#007bb6',
				),
				'linkedin'       => array(
					'icon'  => 'fa-brands fa-linkedin',
					'label' => 'LinkedIn',
					'color' => '#0a66c2',
				),
				'pinterest'      => array(
					'icon'  => 'fa-brands fa-pinterest',
					'label' => 'Pinterest',
					'color' => '#e60023',
				),
				'reddit'         => array(
					'icon'  => 'fa-brands fa-reddit',
					'label' => 'Reddit',
					'color' => '#ff4500',
				),
				'soundcloud'     => array(
					'icon'  => 'fa-brands fa-soundcloud',
					'label' => 'Soundcloud',
					'color' => '#ff5500',
				),
				'spotify'        => array(
					'icon'  => 'fa-brands fa-spotify',
					'label' => 'Spotify',
					'color' => '#1db954',
				),
				'stack-exchange' => array(
					'icon'  => 'fa-brands fa-stack-exchange',
					'label' => 'Stack Exchange',
					'color' => '#f48024',
				),
				'stack-overflow' => array(
					'icon'  => 'fa-brands fa-stack-overflow',
					'label' => 'Stack Overflow',
					'color' => '#f48024',
				),
				'stumbleupon'    => array(
					'icon'  => 'fa-brands fa-stumbleupon',
					'label' => 'Stumbleupon',
					'color' => '#eb4823',
				),
				'tumblr'         => array(
					'icon'  => 'fa-brands fa-tumblr',
					'label' => 'Tumblr',
					'color' => '#36465d',
				),
				'twitter'        => array(
					'icon'  => 'fa-brands fa-twitter',
					'label' => 'Twitter',
					'color' => '#1da1f2',
				),
				'vimeo'          => array(
					'icon'  => 'fa-brands fa-vimeo-square',
					'label' => 'Vimeo',
					'color' => '#1ab7ea',
				),
				'youtube'        => array(
					'icon'  => 'fa-brands fa-youtube',
					'label' => 'Youtube',
					'color' => '#ff0000',
				),
				'rss'            => array(
					'icon'  => 'fa-brands fa-rss',
					'label' => 'Rss',
					'color' => '#FA9B39',
				),
			),
			'layouts'       => array(
				'default'            => array(
					'name'    => 'Default Layout',
					'sidebar' => 'right',
					'columns' => 2,
				),
				'fullwidth'          => array(
					'name'    => 'Full Width',
					'sidebar' => 'none',
					'columns' => 1,
				),
				'fullwidth-centered' => array(
					'name'     => 'Full Width Centered',
					'sidebar'  => 'none',
					'columns'  => 1,
					'centered' => true,
				),
				'magazine'           => array(
					'name'    => 'Magazine',
					'sidebar' => 'right',
					'columns' => 2,
					'feature' => 'magazine',
				),
				'three-cols'         => array(
					'name'    => 'Three Columns',
					'sidebar' => 'both',
					'columns' => 3,
				),
				'three-cols-slm'     => array(
					'name'    => 'Three Columns - Small Left/Middle',
					'sidebar' => 'both',
					'columns' => 3,
					'slim'    => true,
				),
			),
		)
	);
}

```


## Assistant



**Tool Call: Read file `origamiez/inc/misc-helpers.php`**
Status: Completed

```origamiez-premium-free/origamiez/inc/misc-helpers.php
<?php
/**
 * Misc Helpers
 *
 * @package Origamiez
 */

use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Helpers\MetadataHelper;

/**
 * Get the metadata prefix.
 *
 * @param bool $display Whether to echo the prefix.
 * @return string The metadata prefix.
 */
function origamiez_get_metadata_prefix( $display = true ) {
	return MetadataHelper::get_metadata_prefix( $display );
}

/**
 * Get allowed HTML tags configuration.
 *
 * @return array Allowed HTML tags.
 */
function origamiez_get_allowed_tags() {
	return AllowedTagsConfig::get_allowed_tags();
}

/**
 * Create a filter callback that returns a static numeric value.
 *
 * Use this factory to generate filter callbacks dynamically without
 * needing individual functions for each numeric value. This replaces
 * the need for multiple origamiez_return_X() functions.
 *
 * @param int $value The numeric value to return.
 * @return callable A function that returns the specified value.
 */
function origamiez_create_value_callback( $value ) {
	return static function () use ( $value ) {
		return $value;
	};
}

/**
 * Get or create a cached numeric filter callback.
 *
 * Caches closures to avoid recreating them repeatedly, improving
 * performance when the same numeric value is used as a filter callback.
 *
 * @param int $value The numeric value to return.
 * @return callable The cached callback function.
 */
function origamiez_get_value_callback( $value ) {
	static $callbacks = array();

	if ( ! isset( $callbacks[ $value ] ) ) {
		$callbacks[ $value ] = origamiez_create_value_callback( $value );
	}

	return $callbacks[ $value ];
}

```


## Assistant



**Tool Call: cat origamiez/index.php origamiez/header.php origamiez/footer.php**
Status: Completed

Terminal:
```
<?php
/**
 * Index
 *
 * @package Origamiez
 */

get_header();
?>
	<div id="sidebar-center" class="origamiez-size-01 pull-left">
		<?php get_template_part( 'parts/breadcrumb' ); ?>
		<?php if ( have_posts() ) : ?>
			<div class="clearfix"></div>
			<div id="sidebar-center-bottom" class="clearfix">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="origamiez-post-wrap" <?php post_class( 'clearfix' ); ?>>
						<h1 class="entry-title" style="display: none;"><?php the_title(); ?></h1>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
						<?php
						wp_link_pages(
							array(
								     'before'           => '<div id="origamiez_singular_pagination" class="clearfix">',
								     'after'            => '</div>',
								     'next_or_number'   => 'next',
								     'separator'        => ' . ',
								     'nextpagelink'     => esc_attr__( 'Next', 'origamiez' ),
								     'previouspagelink' => esc_attr__( 'Previous', 'origamiez' ),
							)
						);
						?>
					</article>
					<?php comments_template(); ?>
				<?php endwhile; ?>
			</div>
			<?php
		else :
			// If no content, include the "No posts found" template.
			get_template_part( 'content', 'none' );
		endif;
		?>
	</div>
<?php get_template_part( 'sidebar-right' ); ?>
	<div class="clearfix"></div>
<?php
$footer_number_of_cols = (int) get_theme_mod( 'footer_number_of_cols', 5 );
get_footer( $footer_number_of_cols );
<?php
/**
 * Header
 *
 * @package Origamiez
 */

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action( 'origamiez_after_body_open' ); ?>
<?php get_template_part( 'parts/menu', 'mobile' ); ?>
<div id="sb-site">
	<header id="origamiez-header">
		<?php get_template_part( 'parts/top-bar' ); ?>
		<?php
		$header_style = get_theme_mod( 'header_style', 'left-right' );
		get_template_part( 'parts/header/header', $header_style );
		?>
		<?php if ( has_nav_menu( 'main-nav' ) ) : ?>
			<div id="origamiez-header-bottom" class="clearfix">
				<nav id="main-nav">
					<div id="origamiez-mobile-wrap" class="clearfix">
						<span id="origamiez-mobile-menu-icon" class="origamiez-mobile-icon sb-toggle-left"><span
								     	     class="fa fa-bars"></span><span><?php esc_html_e( 'Menu', 'origamiez' ); ?></span></span>
					</div>
					<div id="main-nav-inner" class="<?php \Origamiez\Engine\Helpers\LayoutHelper::get_wrap_classes(); ?>">
						<?php
						wp_nav_menu(
							array(
								     'theme_location' => 'main-nav',
								     'container'      => false,
								     'menu_id'        => 'main-menu',
								     'menu_class'     => 'clearfix',
							)
						);
						?>
					</div>
				</nav><!-- end: main-nav-->
			</div> <!-- end: header-bottom -->
		<?php endif; ?>
	</header>
	<div id="origamiez-body" class="<?php \Origamiez\Engine\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
		<div id="origamiez-body-inner" class="clearfix">
<?php do_action( 'origamiez_after_body_inner_open' ); ?><?php
/**
 * Footer
 *
 * @package Origamiez
 */

?>
</div> <!-- end #origamiez-body > container > #origamiez-boby-inner -->
</div> <!-- end #origamiez-body-->
<footer id="origamiez-footer" class="clearfix">
	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) ) : ?>
		<div id="origamiez-footer-sidebars" class="clearfix">
			<div id="origamiez-footer-sidebars-inner" class="<?php \Origamiez\Engine\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
				<div class="row clearfix">
					<div id="origamiez-footer-right" class="col-md-8 col-sm-12 col-xs-12 widget-area"
						role="complementary">
						<div class="row clearfix">
							<?php get_sidebar( 'footer-1' ); ?>
							<?php get_sidebar( 'footer-2' ); ?>
							<?php get_sidebar( 'footer-3' ); ?>
							<?php get_sidebar( 'footer-4' ); ?>
						</div>
					</div>
					<?php get_sidebar( 'footer-5' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div id="origamiez-footer-end" class="clearfix">
		<div class="<?php \Origamiez\Engine\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
			<?php get_template_part( 'parts/menu', 'bottom' ); ?>
			<?php get_template_part( 'parts/copyright' ); ?>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
<?php do_action( 'origamiez_before_body_close' ); ?>
</body>
</html>

```


## Assistant



**Tool Call: ls origamiez/*.php**
Status: Completed

Terminal:
```
origamiez/404.php				origamiez/sidebar-footer-2.php
origamiez/archive.php				origamiez/sidebar-footer-3.php
origamiez/comments.php				origamiez/sidebar-footer-4.php
origamiez/content-none.php			origamiez/sidebar-footer-5.php
origamiez/content.php				origamiez/sidebar-left.php
origamiez/footer-1.php				origamiez/sidebar-main-bottom.php
origamiez/footer-2.php				origamiez/sidebar-main-center-bottom.php
origamiez/footer-3.php				origamiez/sidebar-main-center-left.php
origamiez/footer-4.php				origamiez/sidebar-main-center-right.php
origamiez/footer-shop.php			origamiez/sidebar-main-center-top.php
origamiez/footer.php				origamiez/sidebar-main-top.php
origamiez/functions.php				origamiez/sidebar-middle-clone.php
origamiez/header-shop.php			origamiez/sidebar-middle.php
origamiez/header.php				origamiez/sidebar-right.php
origamiez/home.php				origamiez/sidebar.php
origamiez/index.php				origamiez/single.php
origamiez/page.php				origamiez/template-page-fullwidth-centered.php
origamiez/pagination.php			origamiez/template-page-fullwidth.php
origamiez/search.php				origamiez/template-page-magazine.php
origamiez/searchform.php			origamiez/template-page-three-cols-slm.php
origamiez/sidebar-bottom.php			origamiez/template-page-three-cols.php
origamiez/sidebar-footer-1.php

```


## Assistant



**Tool Call: cat origamiez/functions.php**
Status: Completed

Terminal:
```
<?php
/**
 * Origamiez functions and definitions
 *
 * @package Origamiez
 */

use Origamiez\Engine\ThemeBootstrap;

const ORIGAMIEZ_PREFIX  = 'origamiez_';
const ORIGAMIEZ_VERSION = '4.0.0';
$dir                    = trailingslashit( get_template_directory() );

require_once $dir . '/vendor/autoload.php';

add_action(
	'after_setup_theme',
	function () {
		$bootstrap = new ThemeBootstrap();
		$bootstrap->boot();
	}
);

/*
HOOK CALLBACK
--------------------
All callback functions for action hooks & filter hooks.
--------------------
*/
require_once $dir . 'inc/config.php';
require $dir . 'inc/functions.php';

/*
PLUGINS
--------------------
Setup - config for compatible plugins.
--------------------
*/
require $dir . 'plugins/bbpress/index.php';

require $dir . 'plugins/woocommerce/index.php';

```


## Assistant



**Tool Call: cat origamiez/plugins/woocommerce/index.php**
Status: Completed

Terminal:
```
<?php
/**
 * Index
 *
 * @package Origamiez
 */

if ( class_exists( 'WooCommerce' ) ) {

	add_action( 'after_setup_theme', 'origamiez_woocommerce_setup', 20 );

	/**
	 * Sets up WooCommerce theme support.
	 */
	function origamiez_woocommerce_setup() {
		add_theme_support( 'woocommerce' );

		if ( ! is_admin() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_filter( 'loop_shop_columns', 'origamiez_woocommerce_loop_shop_columns' );
			add_filter( 'loop_shop_per_page', 'origamiez_woocommerce_loop_shop_per_page' );
			add_filter( 'woocommerce_cart_item_quantity', 'origamiez_woocommerce_cart_item_quantity' );
			add_action( 'wp_enqueue_scripts', 'origamiez_woocommerce_enqueue_scripts', 20 );
		}
	}

	/**
	 * Filters WooCommerce cart item quantity.
	 *
	 * @param string $product_quantity The product quantity.
	 * @return string The filtered product quantity.
	 */
	function origamiez_woocommerce_cart_item_quantity( $product_quantity ) {
		$product_quantity = str_replace( 'number', 'text', $product_quantity );
		return $product_quantity;
	}

	/**
	 * Enqueues WooCommerce scripts.
	 */
	function origamiez_woocommerce_enqueue_scripts() {
		global $wp_styles, $is_IE;
		$dir = get_template_directory_uri();

		wp_enqueue_script( ORIGAMIEZ_PREFIX . 'touchspin', "{$dir}/plugins/woocommerce/js/touchspin.js", array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * Filters WooCommerce shop loop columns.
	 *
	 * @return int The number of columns.
	 */
	function origamiez_woocommerce_loop_shop_columns() {
		return 3;
	}

	/**
	 * Filters WooCommerce shop loop per page.
	 *
	 * @return int The number of items per page.
	 */
	function origamiez_woocommerce_loop_shop_per_page() {
		return 12;
	}
}

```


## Assistant



**Tool Call: cat origamiez/plugins/bbpress/index.php**
Status: Completed

Terminal:
```
<?php
/**
 * Index
 *
 * @package Origamiez
 */

if ( class_exists( 'bbPress' ) ) {

	/**
	 * Registers the bbPress sidebar.
	 */
	function origamiez_bbpress_register_sidebar() {
		register_sidebar(
			array(
				'id'            => 'bbpress_right_sidebar',
				'name'          => esc_attr__( 'Right (bbPress)', 'origamiez' ),
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget origamiez-bbpress-widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">',
				'after_title'   => '</span></h2><div class="origamiez-widget-content clearfix">',
			)
		);
	}

	add_action( 'init', 'origamiez_bbpress_register_sidebar', 40 );
	add_action( 'after_setup_theme', 'origamiez_bbpress_theme_setup', 5 );

	/**
	 * Sets up bbPress theme support.
	 */
	function origamiez_bbpress_theme_setup() {
		if ( ! is_admin() ) {
			add_filter( 'origamiez_get_current_sidebar', 'origamiez_bbpress_set_sidebar', 20, 2 );
			add_filter( 'body_class', 'origamiez_bbpress_body_class' );

			add_filter( 'bbp_get_reply_content', 'origamiez_bbpress_shortcodes', 10, 2 );
			add_filter( 'bbp_get_topic_content', 'origamiez_bbpress_shortcodes', 10, 2 );
		}
	}

	/**
	 * Processes shortcodes in bbPress content.
	 *
	 * @param string $content  The content.
	 * @param int    $reply_id The reply ID.
	 * @return string The processed content.
	 */
	function origamiez_bbpress_shortcodes( $content, $reply_id ) {
		$reply_author = bbp_get_reply_author_id( $reply_id );

		// phpcs:ignore WordPress.WP.Capabilities.Unknown
		if ( user_can( $reply_author, 'publish_forums' ) ) {
			$content = do_shortcode( $content );
		}

		return $content;
	}

	/**
	 * Sets the bbPress sidebar.
	 *
	 * @param string $sidebar  The sidebar ID.
	 * @param string $position The sidebar position.
	 * @return string The sidebar ID.
	 */
	function origamiez_bbpress_set_sidebar( $sidebar, $position ) {
		if ( 'right' === $position ) {
			global $post;
			$tax = get_queried_object();

			if ( is_singular( 'topic' ) ||
			is_singular( 'forum' ) ||
			is_post_type_archive( 'forum' ) ||
			is_post_type_archive( 'topic' ) ||
			( isset( $tax->taxonomy ) && in_array( $tax->taxonomy, array( 'topic-tag' ), true ) ) ||
			bbp_is_search()
			) {
				$sidebar = 'bbpress_right_sidebar';
			}
		}

		return $sidebar;
	}

	/**
	 * Adds bbPress body classes.
	 *
	 * @param array $classes The body classes.
	 * @return array The filtered body classes.
	 */
	function origamiez_bbpress_body_class( $classes ) {
		global $post;

		$tax = get_queried_object();

		if ( is_singular( 'topic' ) ||
		is_singular( 'forum' ) ||
		is_post_type_archive( 'forum' ) ||
		is_post_type_archive( 'topic' ) ||
		( isset( $tax->taxonomy ) && in_array( $tax->taxonomy, array( 'topic-tag' ), true ) ) ||
		bbp_is_search()
		) {
			array_push( $classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single' );
		}

		return $classes;
	}

}

```


## Assistant



**Tool Call: cat origamiez/inc/customizer-callbacks.php origamiez/inc/font-customizer.php**
Status: Completed

Terminal:
```
<?php
/**
 * Customizer Callbacks
 *
 * @package Origamiez
 */

/**
 * Top bar enable callback
 *
 * @return mixed
 */
function origamiez_top_bar_enable_callback() {
	return get_theme_mod( 'is_display_top_bar', 1 );
}

/**
 * Skin custom callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_skin_custom_callback( $control ) {
	return 'custom' === $control->manager->get_setting( 'skin' )->value();
}

/**
 * Font enable callback helper
 *
 * @param string $font_name Font name.
 * @return bool
 */
function _origamiez_font_enable_callback( $font_name ) {
	$setting_name = "font_{$font_name}_is_enable";
	return 1 === (int) get_theme_mod( $setting_name, 0 );
}

/**
 * Font body enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_body_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'body' );
}

/**
 * Font menu enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_menu_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'menu' );
}

/**
 * Font site title enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_site_title_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'site_title' );
}

/**
 * Font site subtitle enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_site_subtitle_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'site_subtitle' );
}

/**
 * Font widget title enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_widget_title_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'widget_title' );
}

/**
 * Font h1 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h1_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'h1' );
}

/**
 * Font h2 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h2_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'h2' );
}

/**
 * Font h3 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h3_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'h3' );
}

/**
 * Font h4 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h4_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'h4' );
}

/**
 * Font h5 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h5_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'h5' );
}

/**
 * Font h6 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h6_enable_callback( $control ) {
	unset( $control );
	return _origamiez_font_enable_callback( 'h6' );
}
<?php
/**
 * Font Customizer
 *
 * @package Origamiez
 */

use Origamiez\Engine\Config\FontCustomizerConfig;

/**
 * Get font families
 *
 * @return array
 */
function origamiez_get_font_families() {
	return FontCustomizerConfig::get_font_families();
}

/**
 * Get font sizes
 *
 * @return array
 */
function origamiez_get_font_sizes() {
	return FontCustomizerConfig::get_font_sizes();
}

/**
 * Get font styles
 *
 * @return array
 */
function origamiez_get_font_styles() {
	return FontCustomizerConfig::get_font_styles();
}

/**
 * Get font weights
 *
 * @return array
 */
function origamiez_get_font_weights() {
	return FontCustomizerConfig::get_font_weights();
}

/**
 * Get font line heights
 *
 * @return array
 */
function origamiez_get_font_line_heighs() {
	return FontCustomizerConfig::get_font_line_heights();
}

```


## Assistant



**Tool Call: cat origamiez/inc/footer-helpers.php origamiez/inc/format-helpers.php**
Status: Completed

Terminal:
```
<?php
/**
 * Footer Helpers
 *
 * @package Origamiez
 */

/**
 * Set classes for footer three columns
 *
 * @param array $_classes CSS classes.
 * @return array
 */
function origamiez_set_classes_for_footer_three_cols( $_classes ) {
	unset( $_classes );
	return array( 'col-xs-12', 'col-sm-4', 'col-md-4' );
}

/**
 * Set classes for footer two columns
 *
 * @param array $_classes CSS classes.
 * @return array
 */
function origamiez_set_classes_for_footer_two_cols( $_classes ) {
	unset( $_classes );
	return array( 'col-xs-12', 'col-sm-6', 'col-md-6' );
}

/**
 * Set classes for footer one column
 *
 * @param array $_classes CSS classes.
 * @return array
 */
function origamiez_set_classes_for_footer_one_cols( $_classes ) {
	unset( $_classes );
	return array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
}
<?php
/**
 * Format Helpers
 *
 * @package Origamiez
 */

use Origamiez\Engine\Helpers\FormatHelper;

/**
 * Get format icon
 *
 * @param string $format Post format.
 * @return string
 */
function origamiez_get_format_icon( $format ) {
	return FormatHelper::get_format_icon( $format );
}

/**
 * Get breadcrumb
 */
function origamiez_get_breadcrumb() {
	do_action( 'origamiez_print_breadcrumb' );
}

```


## Assistant



**Tool Call: cat origamiez/engine/Hooks/HookRegistry.php**
Status: Completed

Terminal:
```
<?php
/**
 * Hook Registry
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Hooks;

/**
 * Class HookRegistry
 *
 * @package Origamiez\Engine\Hooks
 */
class HookRegistry {

	/**
	 * Hooks
	 *
	 * @var array
	 */
	private array $hooks = array();

	/**
	 * Instance
	 *
	 * @var self|null
	 */
	private static ?self $instance = null;

	/**
	 * Hook_Registry constructor.
	 */
	private function __construct() {
	}

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add action.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 * @param integer         $accepted_args The accepted args.
	 *
	 * @return self
	 */
	public function add_action( string $hook, callable|string $callback, int $priority = 10, int $accepted_args = 1 ): self {
		add_action( $hook, $callback, $priority, $accepted_args );
		$this->hooks[] = array(
			'type'          => 'action',
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);
		return $this;
	}

	/**
	 * Add filter.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 * @param integer         $accepted_args The accepted args.
	 *
	 * @return self
	 */
	public function add_filter( string $hook, callable|string $callback, int $priority = 10, int $accepted_args = 1 ): self {
		add_filter( $hook, $callback, $priority, $accepted_args );
		$this->hooks[] = array(
			'type'          => 'filter',
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);
		return $this;
	}

	/**
	 * Register hooks.
	 *
	 * @param HookProviderInterface $provider The provider.
	 *
	 * @return self
	 */
	public function register_hooks( HookProviderInterface $provider ): self {
		$provider->register( $this );
		return $this;
	}

	/**
	 * Get hooks.
	 *
	 * @return array
	 */
	public function get_hooks(): array {
		return $this->hooks;
	}

	/**
	 * Get hooks by type.
	 *
	 * @param string $type The type.
	 *
	 * @return array
	 */
	public function get_hooks_by_type( string $type ): array {
		return array_filter( $this->hooks, fn( $hook ) => $hook['type'] === $type );
	}

	/**
	 * Get hooks by name.
	 *
	 * @param string $name The name.
	 *
	 * @return array
	 */
	public function get_hooks_by_name( string $name ): array {
		return array_filter( $this->hooks, fn( $hook ) => $hook['hook'] === $name );
	}

	/**
	 * Remove action.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 *
	 * @return boolean
	 */
	public function remove_action( string $hook, callable|string $callback, int $priority = 10 ): bool {
		return remove_action( $hook, $callback, $priority );
	}

	/**
	 * Remove filter.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 *
	 * @return boolean
	 */
	public function remove_filter( string $hook, callable|string $callback, int $priority = 10 ): bool {
		return remove_filter( $hook, $callback, $priority );
	}
}

```


## Assistant



**Tool Call: cat origamiez/engine/Hooks/Hooks/FrontendHooks.php**
Status: Completed

Terminal:
```
<?php
/**
 * Frontend Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Container;
use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

/**
 * Class FrontendHooks
 *
 * @package Origamiez\Engine\Hooks\Hooks
 */
class FrontendHooks implements HookProviderInterface {

	/**
	 * Container
	 *
	 * @var Container
	 */
	private Container $container;

	/**
	 * FrontendHooks constructor.
	 *
	 * @param Container $container The container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		$registry
			->add_action( 'init', array( $this, 'widget_order_class' ) )
			->add_filter( 'post_class', array( $this, 'archive_post_class' ) )
			->add_filter( 'excerpt_more', '__return_false' )
			->add_filter( 'wp_nav_menu_objects', array( $this, 'add_first_and_last_class_for_menu_item' ) )
			->add_filter( 'post_thumbnail_html', array( $this, 'remove_hardcoded_image_size' ) )
			->add_action( 'origamiez_after_body_open', array( $this, 'global_wrapper_open' ) )
			->add_action( 'origamiez_before_body_close', array( $this, 'global_wrapper_close' ) )
			->add_action( 'origamiez_print_button_readmore', array( $this, 'get_button_readmore' ) );
	}

	/**
	 * Widget order class.
	 *
	 * @return void
	 */
	public function widget_order_class(): void {
		$widget_class_manager = $this->container->get( 'widget_class_manager' );
		$widget_class_manager->add_widget_order_classes();
	}

	/**
	 * Archive post class.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function archive_post_class( array $classes ): array {
		global $wp_query;
		if ( 0 === $wp_query->current_post ) {
			$classes[] = 'origamiez-first-post';
		}
		$manager = $this->container->get( 'post_class_manager' );
		return $manager->get_post_classes( $classes );
	}

	/**
	 * Add first and last class for menu item.
	 *
	 * @param array $items The items.
	 *
	 * @return array
	 */
	public function add_first_and_last_class_for_menu_item( array $items ): array {
		$items[1]->classes[]                 = 'origamiez-menuitem-first';
		$items[ count( $items ) ]->classes[] = 'origamiez-menuitem-last';
		return $items;
	}

	/**
	 * Remove hardcoded image size.
	 *
	 * @param string $html The html.
	 *
	 * @return string
	 */
	public function remove_hardcoded_image_size( string $html ): string {
		return preg_replace( '/(width|height)="\d+"\s/', '', $html );
	}

	/**
	 * Global wrapper open.
	 *
	 * @return void
	 */
	public function global_wrapper_open(): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			echo '<div class="container">';
		}
	}

	/**
	 * Global wrapper close.
	 *
	 * @return void
	 */
	public function global_wrapper_close(): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			echo '</div>';
		}
	}

	/**
	 * Get button readmore.
	 *
	 * @return void
	 */
	public function get_button_readmore(): void {
		$button = $this->container->get( 'read_more_button' );
		$button->display();
	}
}

```


## Assistant



**Tool Call: cat origamiez/engine/Helpers/LayoutHelper.php**
Status: Completed

Terminal:
```
<?php
/**
 * Layout Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class LayoutHelper
 */
class LayoutHelper {

	/**
	 * Get wrap classes.
	 *
	 * @param bool $should_echo Whether to echo the classes.
	 * @return string
	 */
	public static function get_wrap_classes( bool $should_echo = true ): string {
		$classes = '';
		if ( 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			$classes = 'container';
		}

		if ( $should_echo ) {
			echo esc_attr( $classes );
		}

		return $classes;
	}
}

```


## Assistant



**Tool Call: grep -rn 'extract(' origamiez/**
Status: Completed

Terminal:
```





```


## Assistant



**Tool Call: grep -rn 'global ' origamiez/**
Status: Completed

Terminal:
```
origamiez/pagination.php:9:	global $wp_query, $wp_rewrite;
origamiez/plugins/woocommerce/index.php:43:		global $wp_styles, $is_IE;
origamiez/plugins/bbpress/index.php:70:			global $post;
origamiez/plugins/bbpress/index.php:94:		global $post;
origamiez/js/jquery.fitvids.js:1:/*global jQuery */
origamiez/js/jquery.navgoco.js:196:		 * navgoco menus so the read happens only once and stored in the global `cookie` var.
origamiez/parts/single/related/related-flat-list.php:8:global $post;
origamiez/parts/single/related/related-carousel.php:8:global $post;
origamiez/engine/ThemeSupportManager.php:171:		global $content_width;
origamiez/engine/Post/PostClassManager.php:29:		global $post;
origamiez/engine/Utils/ImageUtils.php:122:		global $_wp_additional_image_sizes;
origamiez/engine/Hooks/Hooks/FrontendHooks.php:74:		global $wp_query;
origamiez/engine/Display/AuthorDisplay.php:40:			global $post;
origamiez/engine/Display/Breadcrumb/Segments/PageSegment.php:43:		global $post;
origamiez/engine/Display/Breadcrumb/Segments/SearchSegment.php:43:		global $wp_query;
origamiez/engine/Widgets/SidebarRegistry.php:97:		global $wp_registered_widgets;
origamiez/engine/Widgets/WidgetClassManager.php:29:		global $wp_registered_widgets;
origamiez/engine/Widgets/AbstractPostsWidget.php:206:		global $wp_version;

```


## Assistant



**Tool Call: cat origamiez/engine/Hooks/Hooks/SecurityHooks.php**
Status: Completed

Terminal:
```
<?php
/**
 * Security Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Container;
use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

/**
 * Class SecurityHooks
 *
 * @package Origamiez\Engine\Hooks\Hooks
 */
class SecurityHooks implements HookProviderInterface {

	/**
	 * Container
	 *
	 * @var Container
	 */
	private Container $container;

	/**
	 * SecurityHooks constructor.
	 *
	 * @param Container $container The container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		$registry
			->add_action( 'init', array( $this, 'verify_search_nonce' ) )
			->add_action( 'pre_get_posts', array( $this, 'sanitize_search_query' ) )
			->add_action( 'send_headers', array( $this, 'add_security_headers' ) )
			->add_action( 'wp_login_failed', array( $this, 'track_failed_login' ) )
			->add_action( 'wp_login', array( $this, 'clear_login_attempts' ) );
	}

	/**
	 * Verify search nonce.
	 *
	 * @return void
	 */
	public function verify_search_nonce(): void {
		if ( is_search() && isset( $_GET['search_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['search_nonce'] ) ), 'origamiez_search_form_nonce' ) ) {
				wp_die( esc_html__( 'Security check failed. Please try again.', 'origamiez' ) );
			}
		}
	}

	/**
	 * Sanitize search query.
	 *
	 * @param \WP_Query $query The query object.
	 *
	 * @return void
	 */
	public function sanitize_search_query( \WP_Query $query ): void {
		if ( is_search() && ! is_admin() && $query->is_main_query() ) {
			$search_term = get_search_query();
			if ( ! empty( $search_term ) ) {
				$sanitized_term = sanitize_text_field( $search_term );
				$sanitized_term = substr( $sanitized_term, 0, 100 );
				$query->set( 's', $sanitized_term );
			}
		}
	}

	/**
	 * Add security headers.
	 *
	 * @return void
	 */
	public function add_security_headers(): void {
		if ( ! is_admin() ) {
			header( 'X-Content-Type-Options: nosniff' );
			header( 'X-Frame-Options: SAMEORIGIN' );
			header( 'X-XSS-Protection: 1; mode=block' );
			header( 'Referrer-Policy: strict-origin-when-cross-origin' );

			$csp  = "default-src 'self'; ";
			$csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com; ";
			$csp .= "style-src 'self' 'unsafe-inline' *.googleapis.com *.gstatic.com; ";
			$csp .= "img-src 'self' data: *.gravatar.com *.wp.com; ";
			$csp .= "font-src 'self' *.googleapis.com *.gstatic.com; ";
			$csp .= "connect-src 'self'; ";
			$csp .= "frame-src 'self' *.youtube.com *.vimeo.com; ";
			$csp .= "object-src 'none'; ";
			$csp .= "base-uri 'self';";

			header( 'Content-Security-Policy: ' . $csp );
		}
	}

	/**
	 * Track failed login.
	 *
	 * @param string $username The username.
	 *
	 * @return void
	 */
	public function track_failed_login( string $username ): void {
		$username = sanitize_user( $username );
		$attempts = get_transient( 'origamiez_login_attempts_' . $username );
		$attempts = $attempts ? $attempts + 1 : 1;
		set_transient( 'origamiez_login_attempts_' . $username, $attempts, 15 * MINUTE_IN_SECONDS );
	}

	/**
	 * Clear login attempts.
	 *
	 * @param string $user_login The user login.
	 *
	 * @return void
	 */
	public function clear_login_attempts( string $user_login ): void {
		delete_transient( 'origamiez_login_attempts_' . sanitize_user( $user_login ) );
	}
}

```


## Assistant



**Tool Call: cat origamiez/searchform.php**
Status: Completed

Terminal:
```
<?php
/**
 * Searchform
 *
 * @package Origamiez
 */

?>
<form method="get" id="search-form" class="search-form clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php wp_nonce_field( 'origamiez_search_form_nonce', 'search_nonce' ); ?>
	<input autocomplete="off" type="text" value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Enter your keyword...', 'origamiez' ); ?>" name="s" class="search-text"
			maxlength="20">
	<button type="submit" class="search-submit"><span class="fa fa-search"></span></button>
</form>

```


## Assistant

Here is a comprehensive code review and refactoring plan for the `./origamiez` directory, strictly evaluating against the principles of Clean Code and the `AGENTS.md` guidelines.

### 🚨 1. Critical Issues & Hidden Bugs

**1. PHP 8.x Fatal Error Risk in Menu Classes**
In the `FrontendHooks` class, the logic that adds classes to the first and last menu items blindly accesses array keys without verifying if the array is empty or associative.
```origamiez/engine/Hooks/Hooks/FrontendHooks.php#L85-93
	public function add_first_and_last_class_for_menu_item( array $items ): array {
		$items[1]->classes[]                 = 'origamiez-menuitem-first';
		$items[ count( $items ) ]->classes[] = 'origamiez-menuitem-last';
		return $items;
	}
```
* **Why it’s a bug:** If the menu is empty, `$items[1]` produces an `Undefined array key` warning, followed by a Fatal Error when attempting to read `->classes` on `null`. Moreover, `$items` keys might not always be sequential starting at `1`.

**2. Caching Destruction via Search Form Nonces**
You have added a nonce check to the public search form (`searchform.php`) and try to verify it via `SecurityHooks::verify_search_nonce`. 
* **Why it’s a bug:** Nonces expire every 12–24 hours. A nonce in a public search form completely breaks page caching mechanisms (like WP Rocket or Varnish). Anonymous users landing on cached pages will fail the nonce verification and see "Security check failed". Public search forms should **not** require nonces.
* **Secondary Failure:** The verification runs on the `init` hook. The `is_search()` function is evaluated against the main WP query, which hasn't been set up yet during `init`. It will silently fail or throw notices.

**3. Search Query Double-Escaping**
```origamiez/engine/Hooks/Hooks/SecurityHooks.php#L72-82
	public function sanitize_search_query( \WP_Query $query ): void {
		if ( is_search() && ! is_admin() && $query->is_main_query() ) {
			$search_term = get_search_query(); // Returns HTML-escaped string
			if ( ! empty( $search_term ) ) {
				$sanitized_term = sanitize_text_field( $search_term );
                // ...
				$query->set( 's', $sanitized_term );
```
* **Why it’s a bug:** `get_search_query()` escapes HTML by default (returning `&quot;`, `&amp;`, etc.). When you sanitize it and inject it back into the query with `$query->set( 's', ... )`, you're searching the database for HTML entities instead of the actual characters.

---

### 🏗️ 2. Architectural Violations

**1. `app/` Directory is Missing (Core Pattern Violation)**
`AGENTS.md` mandates that core PHP classes must be in `app/`. Currently, the codebase has completely ignored this and placed everything in `engine/`. Additionally, the `composer.json` maps `Origamiez\` to `app/` (which doesn't exist) and uses `Origamiez\Engine\` mapped to `engine/`. 

**2. Custom DI Container Replaces `php-di`**
The instructions explicitly require managing dependencies via `php-di/php-di` (referencing `app/Core/Container.php`). However, the theme rolled its own PSR-11 container in `engine/Container.php`. As a result, `ThemeBootstrap.php` is heavily bloated with manual closures instantiating every service instead of relying on `php-di`'s elegant autowiring or definition arrays.

**3. Scattered `add_action` Calls**
`AGENTS.md` explicitly states: *“Avoid manual `add_action` in random files.”* 
However, in plugin integrators like `plugins/woocommerce/index.php` and `plugins/bbpress/index.php`, hooks are manually registered in the global scope instead of building dedicated classes (`WoocommerceHooks`, `BbpressHooks`) that implement `HookProviderInterface` and register with the `HookRegistry`.

**4. UI Template Parts Outside of `parts/`**
Dozens of template components (`sidebar-right.php`, `header-shop.php`, `footer-1.php`, etc.) sit directly in the root directory. In `index.php`, the template part is invoked directly against the root: `get_template_part( 'sidebar-right' );`. This ignores the mandate to keep UI components modularized inside `parts/`.

---

### 👃 3. Code Smells & Clean Code Suggestions

* **Regex on HTML Output:** `FrontendHooks::remove_hardcoded_image_size` uses `preg_replace` on raw HTML to strip inline width/height attributes. This is brittle. The modern WordPress approach is to use the `wp_get_attachment_image_attributes` filter to unset the `width` and `height` properties before the HTML is even generated.
* **Naming Conventions:** A customizer callback function is named `_origamiez_font_enable_callback`. The leading underscore breaks the rigid rule that global functions must strictly begin with `origamiez_`.
* **Typos in API signatures:** `inc/font-customizer.php` defines the function `origamiez_get_font_line_heighs()` instead of `_heights()`. 

---

### 🛠️ 4. Step-by-Step Refactoring Plan

#### Phase 1: Security & Bugs Fixes (Immediate)
1. **Remove the Search Nonce:** Strip `wp_nonce_field` from `searchform.php`. Remove the `verify_search_nonce` method from `SecurityHooks`.
2. **Fix Search Query Extraction:** Update `SecurityHooks::sanitize_search_query` to fetch the raw query directly from the object instead of using `get_search_query()`.
3. **Fix Menu Array Key Error:** Safeguard the array boundaries using modern PHP.

```origamiez/engine/Hooks/Hooks/FrontendHooks.php#L85-95
	public function add_first_and_last_class_for_menu_item( array $items ): array {
		if ( empty( $items ) ) {
			return $items;
		}

		$first_key = array_key_first( $items );
		$last_key  = array_key_last( $items );

		$items[ $first_key ]->classes[] = 'origamiez-menuitem-first';
		$items[ $last_key ]->classes[]  = 'origamiez-menuitem-last';

		return $items;
	}
```

#### Phase 2: Architectural Alignment (Directory & DI)
1. **Rename Directories:** Rename `engine/` to `app/`. Update all namespace declarations from `Origamiez\Engine\...` to `Origamiez\Core\...` (or whatever the target PSR-4 root implies).
2. **Composer Update:** Remove the dual `engine/` map. Require `php-di`. Run `composer update`.
3. **Implement PHP-DI:** Delete `Container.php`. Set up `app/Core/Container.php` leveraging `DI\ContainerBuilder`.
4. **Clean up `ThemeBootstrap`:** Move all the `singleton()` registration bloat out of `ThemeBootstrap.php` and into a PHP-DI config array (e.g., `app/Config/di-definitions.php`).

#### Phase 3: Centralizing Hooks
1. Create `app/Hooks/Plugins/WoocommerceHooks.php` and `app/Hooks/Plugins/BbpressHooks.php`. 
2. Migrate all logic out of `plugins/*/index.php` into these classes.
3. Make them implement `HookProviderInterface` and inject them via `ThemeBootstrap` alongside `FrontendHooks`.

```/dev/null/WoocommerceHooks.php#L10-25
namespace Origamiez\Core\Hooks\Plugins;

use Origamiez\Core\Hooks\HookProviderInterface;
use Origamiez\Core\Hooks\HookRegistry;

class WoocommerceHooks implements HookProviderInterface {
    public function register( HookRegistry $registry ): void {
        $registry
            ->add_action( 'after_setup_theme', [ $this, 'setup_theme' ], 20 )
            ->add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 20 )
            ->add_filter( 'loop_shop_columns', [ $this, 'loop_shop_columns' ] );
    }
    // ... migrate corresponding methods ...
}
```

#### Phase 4: Template Part Restructuring
1. **Move Files:** Move all `sidebar-*.php`, `header-*.php`, and `footer-*.php` files from the root into `origamiez/parts/`.
2. **Refactor Template Calls:** Update root templates like `index.php` and `single.php` to target the `parts/` folder. For instance:

```origamiez/index.php#L42-43
	</div>
<?php get_template_part( 'parts/sidebar', 'right' ); ?>
```

#### Phase 5: Cleanup & WP Standards
1. Replace HTML-regex parsing in `remove_hardcoded_image_size` with the `wp_get_attachment_image_attributes` filter:

```/dev/null/FrontendHooks.php#L1-9
    public function strip_image_dimensions( array $attr ): array {
        unset( $attr['width'], $attr['height'] );
        return $attr;
    }
```
2. Rename `_origamiez_font_enable_callback` to `origamiez_font_enable_callback` and update customizer logic accordingly.
3. Correct naming typoes (like `heighs`) in `inc/font-customizer.php`.

