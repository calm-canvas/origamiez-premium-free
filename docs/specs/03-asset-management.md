# Asset Management

## Description
The Origamiez theme uses a structured approach to asset management, separating asset compilation from runtime enqueuing. The runtime process is handled by the `AssetManager`, which delegates tasks to specialized sub-managers for stylesheets, scripts, fonts, and dynamic inline styles.

## Core Architecture
- **Main Class/File**: `Origamiez\Assets\AssetManager` (`origamiez/app/Assets/AssetManager.php`)
- **Dependencies**: 
    - `Origamiez\Assets\StylesheetManager`: Handles CSS enqueuing.
    - `Origamiez\Assets\ScriptManager`: Handles JS enqueuing.
    - `Origamiez\Assets\InlineStyleGenerator`: Generates dynamic CSS (Customizer or, after migration, merged Theme JSON via `ThemeJsonAppearanceBridge`).
    - `Origamiez\Assets\FontManager`: Placeholder / extension hook; Google Fonts and dynamic slots enqueue in `StylesheetManager` (single handle set).
    - `Origamiez\Assets\ThemeJsonAppearanceBridge`: Resolves merged Theme JSON + theme_mod fallbacks for Phase 4 front-end parity.
- **Patterns Used**: 
    - **Delegation Pattern**: `AssetManager` acts as a facade, delegating specific enqueuing tasks to sub-managers.
    - **Strategy Pattern**: Different managers handle different asset types.

## Implementation Details
- **How it works**: 
    1.  **Registration**: `ThemeBootstrap` initializes the `AssetManager` and calls its `register()` method, which hooks into WordPress's `wp_enqueue_scripts` event with a priority of 15.
    2.  **Enqueuing Lifecycle**: During `wp_enqueue_scripts`, the following occurs sequentially:
        - `StylesheetManager` enqueues core CSS files (Bootstrap, FontAwesome, theme styles, base + dynamic Google Fonts).
        - `InlineStyleGenerator` injects dynamic CSS (legacy Customizer or merged global styles / typography when the migration bridge is active).
        - `ScriptManager` enqueues JavaScript files (jQuery, plugins, theme scripts).
    3.  **Dynamic Styles**: The `InlineStyleGenerator` processes theme options (colors, typography) and outputs them as a `wp_add_inline_style` block attached to the main theme stylesheet. Heading-level font rules (`h1`–`h6`) are generated with a small loop over levels to avoid repeated mapping code.
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
    - The theme uses **Vite** for asset compilation. Source files are located in the `assets/` directory at the project root.
    - Use `pnpm dev` for development builds (HMR) and `pnpm build` for production.
- **Common Issues**: 
    - **Dependency Order**: Ensure script dependencies (like `jquery`) are correctly defined in `ScriptManager`.

## Related Files
- `origamiez/app/Assets/AssetManager.php`
- `origamiez/app/Assets/StylesheetManager.php`
- `origamiez/app/Assets/ScriptManager.php`
- `origamiez/app/Assets/InlineStyleGenerator.php`
- `origamiez/app/Assets/FontManager.php`
- `vite.config.js` (Root directory)
- `assets/` (Source assets directory)
