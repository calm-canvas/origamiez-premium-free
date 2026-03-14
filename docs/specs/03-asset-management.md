# Asset Management

## Description
The Origamiez theme uses a structured approach to asset management, separating asset compilation from runtime enqueuing. The runtime process is handled by the `AssetManager`, which delegates tasks to specialized sub-managers for stylesheets, scripts, fonts, and dynamic inline styles.

## Core Architecture
- **Main Class/File**: `Origamiez\Engine\Assets\AssetManager` (`origamiez/engine/Assets/AssetManager.php`)
- **Dependencies**: 
    - `Origamiez\Engine\Assets\StylesheetManager`: Handles CSS enqueuing.
    - `Origamiez\Engine\Assets\ScriptManager`: Handles JS enqueuing.
    - `Origamiez\Engine\Assets\InlineStyleGenerator`: Generates dynamic CSS based on theme settings.
    - `Origamiez\Engine\Assets\FontManager`: Manages custom and Google font loading.
- **Patterns Used**: 
    - **Delegation Pattern**: `AssetManager` acts as a facade, delegating specific enqueuing tasks to sub-managers.
    - **Strategy Pattern**: Different managers handle different asset types.

## Implementation Details
- **How it works**: 
    1.  **Registration**: `ThemeBootstrap` initializes the `AssetManager` and calls its `register()` method, which hooks into WordPress's `wp_enqueue_scripts` event with a priority of 15.
    2.  **Enqueuing Lifecycle**: During `wp_enqueue_scripts`, the following occurs sequentially:
        - `StylesheetManager` enqueues core CSS files (Bootstrap, FontAwesome, theme styles).
        - `FontManager` enqueues font-related styles.
        - `InlineStyleGenerator` injects dynamic CSS generated from Customizer settings.
        - `ScriptManager` enqueues JavaScript files (jQuery, plugins, theme scripts).
    3.  **Dynamic Styles**: The `InlineStyleGenerator` processes theme options (colors, typography) and outputs them as a `wp_add_inline_style` block attached to the main theme stylesheet.
- **Key Functions/Methods**:
    - `AssetManager::register()`: Hooks into the WordPress enqueue action.
    - `AssetManager::enqueue_assets()`: Orchestrates the enqueuing sequence.
    - `StylesheetManager::enqueue(template_uri)`: Registers and enqueues CSS files.
    - `ScriptManager::enqueue(template_uri)`: Registers and enqueues JS files.

## Maintenance & Development
- **Adding Assets**: 
    - For CSS, modify `StylesheetManager::enqueue()`.
    - For JS, modify `ScriptManager::enqueue()`.
- **Compiling Assets**: 
    - The theme uses **Laravel Mix** (Mix 6) for asset compilation. Source files are located in the `assets/` directory at the project root.
    - Use `npm run dev` for development builds and `npm run build` for production.
- **Common Issues**: 
    - **Dependency Order**: Ensure script dependencies (like `jquery`) are correctly defined in `ScriptManager`.
    - **Cache Busting**: Mix handles versioning; ensure the generated file paths are correctly referenced in the managers.

## Related Files
- `origamiez/engine/Assets/AssetManager.php`
- `origamiez/engine/Assets/StylesheetManager.php`
- `origamiez/engine/Assets/ScriptManager.php`
- `origamiez/engine/Assets/InlineStyleGenerator.php`
- `origamiez/engine/Assets/FontManager.php`
- `webpack.mix.js` (Root directory)
- `assets/` (Source assets directory)
