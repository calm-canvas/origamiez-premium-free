# Plugin Integrations

## Description
The Origamiez theme is built to be fully compatible with popular WordPress plugins like WooCommerce and bbPress. Instead of including all plugin-specific logic in the core theme files, these integrations are modularized within the `plugins/` directory, ensuring they only load when the respective plugins are active.

## Core Architecture
- **Main Files**: 
    - `plugins/woocommerce/index.php`: Main integration file for WooCommerce.
    - `plugins/bbpress/index.php`: Main integration file for bbPress.
- **Dependencies**: 
    - `class_exists('WooCommerce')`: Checks if WooCommerce is active.
    - `class_exists('bbPress')`: Checks if bbPress is active.
- **Patterns Used**: 
    - **Conditional Loading**: Plugin-specific functions and hooks are only registered if the plugin is detected.
    - **Hook Overrides**: Using `remove_action` to disable default plugin layouts in favor of theme-specific ones.

## Implementation Details
- **WooCommerce Integration**: 
    1.  **Theme Support**: Declares `add_theme_support('woocommerce')` to enable core WooCommerce features.
    2.  **Layout Customization**: Removes default WooCommerce breadcrumbs and sidebars, replacing them with the theme's own layout components.
    3.  **Filtered Options**: Modifies the number of products per page and the number of shop columns through filters.
    4.  **Custom Scripts**: Enqueues specialized scripts (like `touchspin.js`) specifically for the shop environment.
- **bbPress Integration**: 
    1.  Registers theme-specific styles and scripts for forum layouts.
    2.  Adjusts the forum breadcrumb structure to match the theme's design.
    3.  Modifies forum-related body classes for proper styling.
- **Key Functions/Methods**:
    - `origamiez_woocommerce_setup()`: Orchestrates the WooCommerce theme support and layout changes.
    - `origamiez_woocommerce_enqueue_scripts()`: Loads shop-specific assets.

## Maintenance & Development
- **Fixing Plugin Layout Issues**: 
    - Look into the corresponding `plugins/[plugin-name]/` directory.
    - Check if the theme is removing a core plugin action that needs to be restored or modified.
- **Adding a New Plugin Integration**: 
    - Create a new directory in `plugins/`.
    - Create an `index.php` file and wrap the logic in a `class_exists()` check.
    - Include the new `index.php` in the theme's main `functions.php`.
- **Common Issues**: 
    - **Asset Conflicts**: Ensure plugin-specific scripts do not conflict with core theme scripts or other plugins.

## Related Files
- `origamiez/plugins/woocommerce/` (Directory)
- `origamiez/plugins/bbpress/` (Directory)
- `origamiez/functions.php` (Where integrations are loaded)
