# Architecture Overview

## Description
The Origamiez theme follows a modern, object-oriented architecture centered around a custom Dependency Injection (DI) Container and a central Bootstrap class. This structure separates core theme logic from WordPress template files, making the codebase more maintainable, testable, and scalable.

## Core Architecture
- **Main Class/File**: `Origamiez\Engine\ThemeBootstrap` (`origamiez/engine/ThemeBootstrap.php`)
- **Dependencies**: 
    - `Origamiez\Engine\Container`: A PSR-11 compliant DI container.
    - `Origamiez\Engine\Config\ConfigManager`: Handles theme configurations.
    - `Origamiez\Engine\Hooks\HookRegistry`: Manages WordPress actions and filters.
- **Patterns Used**: 
    - **Singleton**: The `Container` and `ThemeBootstrap` (effectively) act as singletons to ensure global access to services.
    - **Dependency Injection**: Services are registered and resolved through the `Container`.
    - **Service Container**: Centralized management of application components.

## Implementation Details
- **How it works**: 
    1.  **Entry Point**: The theme's `functions.php` initializes the `ThemeBootstrap` class and calls the `boot()` method during the `after_setup_theme` hook.
    2.  **Container Initialization**: `ThemeBootstrap` creates a singleton instance of `Container` and registers core services (Config, Hooks, Assets, etc.) using `singleton()` or `bind()`.
    3.  **Bootstrapping**: The `boot()` method sequentially registers theme features:
        - Theme Support (menus, post formats, etc.)
        - Hooks and Filters
        - Assets (CSS/JS)
        - Layout configurations
        - Customizer settings
        - Widgets and Sidebars
- **Key Functions/Methods**:
    - `ThemeBootstrap::boot()`: Orchestrates the initialization of the entire theme engine.
    - `Container::get_instance()`: Retrieves the global DI container instance.
    - `Container::singleton(id, definition)`: Registers a service that will only be instantiated once.
    - `Container::get(id)`: Resolves and returns a service from the container.

## Maintenance & Development
- **Configuration**: The bootstrapping process is controlled within `ThemeBootstrap.php`. New services should be registered in the `setup_container()` method.
- **Common Issues**: 
    - **Circular Dependencies**: Be cautious when services depend on each other within the container.
    - **Service Not Found**: Ensure all services used via `$container->get()` are registered in `setup_container()`.
- **Future Improvements**:
    - Implement auto-wiring using Reflection to reduce manual service registration.
    - Transition to a more standard PSR-11 implementation if third-party library constraints allow.

## Related Files
- `origamiez/functions.php`
- `origamiez/engine/ThemeBootstrap.php`
- `origamiez/engine/Container.php`
- `origamiez/engine/ThemeSupportManager.php`
