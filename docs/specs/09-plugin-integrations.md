# Plugin Integrations

## Description
The Origamiez theme is built to be fully compatible with popular WordPress plugins like WooCommerce and bbPress. Instead of including all plugin-specific logic in the core theme files, these integrations are modularized within the `app/Hooks/Plugins/` directory using the `HookProviderInterface`, ensuring they only register hooks when the respective plugins are active.

## Core Architecture
- **Main Files**: 
    - `app/Hooks/Plugins/WoocommerceHooks.php`: Main integration provider for WooCommerce.
    - `app/Hooks/Plugins/BbpressHooks.php`: Main integration provider for bbPress.
- **Dependencies**: 
    - `class_exists('WooCommerce')`: Checks if WooCommerce is active within the provider.
    - `class_exists('bbPress')`: Checks if bbPress is active within the provider.
- **Patterns Used**: 
    - **Hook Provider Pattern**: Plugin-specific functions and hooks are registered via the centralized `HookRegistry`.
    - **Conditional Loading**: Hook registration is wrapped in plugin activity checks.
    - **Hook Overrides**: Using `remove_action` to disable default plugin layouts in favor of theme-specific ones.

## Implementation Details
- **WooCommerce Integration**: 
    1.  **Theme Support**: Declares `add_theme_support('woocommerce')` to enable core WooCommerce features.
    2.  **Layout Customization**: Removes default WooCommerce breadcrumbs and sidebars, replacing them with the theme's own layout components from `parts/`.
    3.  **Filtered Options**: Modifies the number of products per page and the number of shop columns through filters.
- **bbPress Integration**: 
    1.  Registers theme-specific styles and scripts for forum layouts.
    2.  Adjusts the forum breadcrumb structure to match the theme's design.
    3.  Modifies forum-related body classes for proper styling.
- **Key Classes**:
    - `Origamiez\Hooks\Plugins\WoocommerceHooks`: Orchestrates the WooCommerce theme support and layout changes.
    - `Origamiez\Hooks\Plugins\BbpressHooks`: Manages bbPress-specific adjustments.

## Maintenance & Development
- **Fixing Plugin Layout Issues**: 
    - Look into the corresponding `app/Hooks/Plugins/` provider class.
    - Check if the theme is removing a core plugin action that needs to be restored or modified.
- **Adding a New Plugin Integration**: 
    - Create a new provider class in `app/Hooks/Plugins/` implementing `HookProviderInterface`.
    - Register the new provider in `ThemeBootstrap::register_hooks()`.
- **Common Issues**: 
    - **Asset Conflicts**: Ensure plugin-specific scripts do not conflict with core theme scripts or other plugins.

## Related Files
- `origamiez/app/Hooks/Plugins/` (Directory)
- `origamiez/app/ThemeBootstrap.php` (Where providers are registered)
- `origamiez/parts/` (Where plugin-specific template parts reside, e.g., `header-shop.php`)
