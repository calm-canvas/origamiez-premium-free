# Customizer Service

## Description
The Origamiez theme provides a structured, object-oriented wrapper around the WordPress Customizer API. The `CustomizerService` orchestrates the registration of panels, sections, and settings, using a "Builder" pattern to separate the configuration of options from their implementation within the WordPress environment.

## Core Architecture
- **Main Class/File**: `Origamiez\Engine\Customizer\CustomizerService` (`origamiez/engine/Customizer/CustomizerService.php`)
- **Dependencies**: 
    - `Origamiez\Engine\Customizer\Builders\PanelBuilder`: Handles `WP_Customize_Panel` creation.
    - `Origamiez\Engine\Customizer\Builders\SectionBuilder`: Handles `WP_Customize_Section` creation.
    - `Origamiez\Engine\Customizer\Builders\SettingBuilder`: Handles `WP_Customize_Setting` and `WP_Customize_Control` creation.
    - `Origamiez\Engine\Customizer\Settings\SettingsInterface`: Interface for defining groups of theme settings.
- **Patterns Used**: 
    - **Builder Pattern**: Decouples the definition of settings from the complex WordPress Customizer registration logic.
    - **Service Pattern**: Provides a centralized service for managing all theme options.
    - **Registry Pattern**: Maintains an internal list of settings classes and configuration arrays.

## Implementation Details
- **How it works**: 
    1.  **Registration**: `ThemeBootstrap` registers various "Settings Classes" (e.g., `GeneralSettings`, `LayoutSettings`) with the `CustomizerService`.
    2.  **Hooking**: The service hooks into the `customize_register` WordPress action.
    3.  **Processing**: When the action triggers, the service:
        - Iterates through all registered `SettingsInterface` classes.
        - Each class calls methods on the service (`register_panel`, `register_section`, `register_setting`) to populate the internal registry.
        - The service then uses its internal `Builders` to finalize the registration with the global `WP_Customize_Manager` instance.
- **Key Functions/Methods**:
    - `CustomizerService::add_settings_class(SettingsInterface class)`: Adds a settings provider.
    - `CustomizerService::register_panel(id, args)`: Registers a customizer panel.
    - `CustomizerService::register_section(id, args)`: Registers a customizer section.
    - `CustomizerService::register_setting(id, args)`: Registers a setting and its corresponding control.
    - `SettingsInterface::register(CustomizerService service)`: The method where specific settings are defined.

## Maintenance & Development
- **Adding a New Setting**: 
    1.  Locate the relevant settings class in `origamiez/engine/Customizer/Settings/`.
    2.  Use the `register_setting()` method within that class's `register()` function.
    3.  Define the `section`, `label`, `type`, and `default` value in the arguments array.
- **Creating a New Settings Group**: 
    1.  Create a new class implementing `SettingsInterface`.
    2.  Register the new class in `ThemeBootstrap::register_customizer()`.
- **Sanitization**: Always provide a `sanitize_callback` in the setting arguments to ensure data integrity.

## Related Files
- `origamiez/engine/Customizer/CustomizerService.php`
- `origamiez/engine/Customizer/Settings/SettingsInterface.php`
- `origamiez/engine/Customizer/Builders/` (Directory)
- `origamiez/engine/Customizer/Settings/` (Directory)
