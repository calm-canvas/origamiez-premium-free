# Configuration Management

## Description
The Origamiez theme utilizes a centralized `ConfigManager` to handle theme-wide defaults, static configurations, and runtime settings. This is supplemented by specialized configuration classes that provide logic-heavy settings for skins, layouts, and typography, ensuring that configuration is both accessible and well-organized.

## Core Architecture
- **Main Class/File**: `Origamiez\Engine\Config\ConfigManager` (`origamiez/engine/Config/ConfigManager.php`)
- **Dependencies**: 
    - `Origamiez\Engine\Config\SkinConfig`: Manages color schemes and skins.
    - `Origamiez\Engine\Config\LayoutConfig`: Manages sidebar and content layout logic.
    - `Origamiez\Engine\Config\FontConfig`: Manages typography and font settings.
    - `Origamiez\Engine\Config\BodyClassConfig`: Manages rules for body classes.
- **Patterns Used**: 
    - **Singleton**: `ConfigManager` provides a single source of truth for configuration.
    - **Dot Notation**: Supports hierarchical data access via strings (e.g., `theme.name`).
    - **Data Mapper**: Maps raw configuration data to usable theme features.

## Implementation Details
- **How it works**: 
    1.  **Defaults**: Upon instantiation, `ConfigManager` initializes a set of hardcoded defaults for theme prefix, image sizes, menus, and supported features.
    2.  **Accessing Data**: The `get()` method allows retrieving nested values using dot notation. If a key is not found, a default value is returned.
    3.  **Theme Mods**: `ConfigManager` also acts as a wrapper for WordPress's `get_theme_mod` and `set_theme_mod`, providing a consistent API for both static and dynamic settings.
    4.  **Specialized Classes**: For complex features like layout switches, specialized classes (like `LayoutConfig`) contain the logic to determine the current state based on multiple inputs (Customizer settings, page templates, etc.).
- **Key Functions/Methods**:
    - `ConfigManager::get(key, default)`: Retrieves a configuration value.
    - `ConfigManager::set(key, value)`: Updates or adds a configuration value.
    - `ConfigManager::merge(array)`: Merges an external array into the existing configuration.
    - `ConfigManager::get_theme_option(option)`: Wrapper for `get_theme_mod`.

## Maintenance & Development
- **Updating Defaults**: Core defaults like supported WordPress features should be updated in `ConfigManager::initialize_defaults()`.
- **Retrieving Settings**: Always use the `ConfigManager` or the specialized config classes instead of calling `get_theme_mod` directly in templates. This ensures that the theme's logic (like default values and overrides) is respected.
- **Extending**: To add a new complex configuration area, create a new class in the `origamiez/engine/Config/` directory and register it in `ThemeBootstrap`.

## Related Files
- `origamiez/engine/Config/ConfigManager.php`
- `origamiez/engine/Config/SkinConfig.php`
- `origamiez/engine/Config/LayoutConfig.php`
- `origamiez/engine/Config/FontConfig.php`
- `origamiez/engine/Config/BodyClassConfig.php`
