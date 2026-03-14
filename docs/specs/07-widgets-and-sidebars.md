# Widgets and Sidebars

## Description
The Origamiez theme provides a comprehensive set of custom widgets designed for magazine and news layouts. These widgets are managed through a `WidgetFactory` and `WidgetRegistry`, while sidebars are organized via a `SidebarRegistry`. This system allows for flexible placement of content across various theme templates.

## Core Architecture
- **Main Classes**: 
    - `Origamiez\Engine\Widgets\WidgetFactory` (`origamiez/engine/Widgets/WidgetFactory.php`)
    - `Origamiez\Engine\Widgets\SidebarRegistry` (`origamiez/engine/Widgets/SidebarRegistry.php`)
- **Dependencies**: 
    - `Origamiez\Engine\Widgets\WidgetRegistry`: Internal registry for managing widget classes.
    - `Origamiez\Engine\Widgets\Sidebars\SidebarConfiguration`: Data object for sidebar settings.
- **Patterns Used**: 
    - **Factory Pattern**: `WidgetFactory` instantiates and registers multiple widget types.
    - **Registry Pattern**: Both widgets and sidebars are maintained in centralized registries.
    - **Singleton**: `WidgetRegistry` and `SidebarRegistry` use the singleton pattern for global access.

## Implementation Details
- **Widget Registration**: 
    1.  `WidgetFactory::boot()` is called during theme initialization.
    2.  It registers a suite of custom widgets (e.g., `SocialLinksWidget`, `PostsListGridWidget`, `PostsListSliderWidget`) with the `WidgetRegistry`.
    3.  The `WidgetRegistry` then hooks into WordPress's `widgets_init` to finalize registration.
- **Sidebar Management**: 
    1.  `SidebarRegistry` defines a set of default sidebars (Main Top, Main Center, Left, Right, Footer 1-5).
    2.  Specialized sidebars (e.g., `main-center-left`) are specifically designed for use with the "Page Magazine" template.
    3.  The registry hooks into `init` to register these sidebars with WordPress using `register_sidebar()`.
- **Dynamic Sidebar Params**: The `SidebarRegistry` also filters `dynamic_sidebar_params` to automatically inject specific HTML wrappers (like `.origamiez-widget-content`) around widgets based on whether they have a title.
- **Key Functions/Methods**:
    - `WidgetFactory::register_widgets()`: Defines the list of widgets to be loaded.
    - `SidebarRegistry::register_sidebar(SidebarConfiguration)`: Adds a new sidebar area.
    - `SidebarRegistry::setup_default_sidebars()`: Defines the theme's core sidebar locations.

## Maintenance & Development
- **Adding a New Widget**: 
    1.  Create a new widget class in `origamiez/engine/Widgets/Types/`, extending the appropriate base class.
    2.  Register the new class in `WidgetFactory::register_widgets()`.
- **Adding a New Sidebar**: 
    1.  Add a new `SidebarConfiguration` entry in `SidebarRegistry::setup_default_sidebars()`.
    2.  Alternatively, use `SidebarRegistry::get_instance()->register_sidebar()` from an external hook.
- **Common Issues**: 
    - **Widget Not Appearing**: Ensure the sidebar it's assigned to is actually called in the current template via `dynamic_sidebar()`.

## Related Files
- `origamiez/engine/Widgets/WidgetFactory.php`
- `origamiez/engine/Widgets/WidgetRegistry.php`
- `origamiez/engine/Widgets/SidebarRegistry.php`
- `origamiez/engine/Widgets/Types/` (Directory)
- `origamiez/engine/Widgets/Sidebars/` (Directory)
- `origamiez/sidebar.php` and other `sidebar-*.php` files in the theme root.
