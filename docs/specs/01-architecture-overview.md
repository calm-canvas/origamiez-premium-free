# Architecture Overview

## Description
The Origamiez theme follows a modern, object-oriented architecture centered around the [PHP-DI](https://php-di.org/) Dependency Injection (DI) Container and a central Bootstrap class. This structure separates core theme logic from WordPress template files, making the codebase more maintainable, testable, and scalable.

## Core Architecture
- **Main Class/File**: `Origamiez\ThemeBootstrap` (`origamiez/app/ThemeBootstrap.php`)
- **Dependencies**: 
    - `PHP-DI`: A powerful and flexible DI container.
    - `Origamiez\Config\ConfigManager`: Handles theme configurations.
    - `Origamiez\Hooks\HookRegistry`: Manages WordPress actions and filters.
- **Patterns Used**: 
    - **Singleton**: The `ThemeBootstrap` (effectively) act as singleton to ensure global access to services.
    - **Dependency Injection**: Services are registered via definitions and resolved through the `Container`.
    - **Service Container**: Centralized management of application components using PHP-DI.

## Implementation Details
- **How it works**: 
    1.  **Entry Point**: The theme's `functions.php` initializes the `ThemeBootstrap` class and calls the `boot()` method during the `after_setup_theme` hook.
    2.  **Container Initialization**: `ThemeBootstrap` creates a `Container` instance using `ContainerBuilder` and registers core services using definitions in `app/Core/di-definitions.php`.
    3.  **Bootstrapping**: The `boot()` method sequentially registers theme features:
        - Theme Support (menus, post formats, etc.)
        - Hooks and Filters
        - Assets (CSS/JS)
        - Layout configurations
        - Customizer settings
        - Widgets and Sidebars
- **Key Functions/Methods**:
    - `ThemeBootstrap::boot()`: Orchestrates the initialization of the entire theme engine.
    - `ThemeBootstrap::get_container()`: Retrieves the global DI container instance.
    - `Container::get(id)`: Resolves and returns a service from the container.

## Maintenance & Development
- **Configuration**: The bootstrapping process is controlled within `ThemeBootstrap.php`. New services should be registered in `app/Core/di-definitions.php`.
- **Common Issues**: 
    - **Circular Dependencies**: Be cautious when services depend on each other within the container.
    - **Service Not Found**: Ensure all services used via `$container->get()` are defined in `di-definitions.php`.

## Related Files
- `origamiez/functions.php`
- `origamiez/app/ThemeBootstrap.php`
- `origamiez/app/Core/di-definitions.php`
- `origamiez/app/ThemeSupportManager.php`
