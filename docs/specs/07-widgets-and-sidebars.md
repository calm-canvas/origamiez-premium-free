# Widgets and Sidebars

## Description
The Origamiez theme provides a comprehensive set of custom widgets designed for magazine and news layouts. These widgets are managed through a `WidgetFactory` and `WidgetRegistry`, while sidebars are organized via a `SidebarRegistry`. This system allows for flexible placement of content across various theme templates.

## Core Architecture
- **Main Classes**: 
    - `Origamiez\Widgets\WidgetFactory` (`origamiez/app/Widgets/WidgetFactory.php`)
    - `Origamiez\Widgets\SidebarRegistry` (`origamiez/app/Widgets/SidebarRegistry.php`)
- **Dependencies**: 
    - `Origamiez\Widgets\WidgetRegistry`: Internal registry for managing widget classes.
    - `Origamiez\Widgets\Sidebars\SidebarConfiguration`: Data object for sidebar settings.
- **Patterns Used**: 
    - **Factory Pattern**: `WidgetFactory` instantiates and registers multiple widget types.
    - **Registry Pattern**: Both widgets and sidebars are maintained in centralized registries.
    - **Singleton**: `WidgetRegistry` and `SidebarRegistry` use the singleton pattern for global access.

## Implementation Details
- **Widget Registration**: 
    1.  `WidgetFactory::boot()` is called during theme initialization.
    2.  It registers a suite of custom widgets (e.g., `SocialLinksWidget`, `PostsListGridWidget`, and other posts-list widgets) with the `WidgetRegistry`.
    3.  The `WidgetRegistry` then hooks into WordPress's `widgets_init` to finalize registration.
- **Type C posts widgets (shared base classes)**:
    - **`AbstractPostsWidgetTypeC`** (`origamiez/app/Widgets/AbstractPostsWidgetTypeC.php`) centralizes the widget chrome and query loop: `echo_widget_shell_open()` / `echo_widget_shell_close()`, `render_posts_widget_with_query()` (opens shell, runs `WP_Query`, invokes a callback when there are posts, resets postdata, closes shell), plus shared helpers such as `get_post_list_display_vars()` and grid markup helpers used by list-style widgets.
    - **`AbstractPostsListTypeCWidget`** (`origamiez/app/Widgets/AbstractPostsListTypeCWidget.php`) extends that for the standard “posts list” family: static `register()`, constructor wiring from `widget_registration_config()`, default `widget()` implementation that calls `render_posts_widget_with_query()` with `render_posts_list_markup()`. Concrete widgets (`PostsListGridWidget`, `PostsListMediaWidget`, `PostsListSmallWidget`, `PostsListTwoColsWidget`, `PostsListWithBackgroundWidget`, `PostsListZebraWidget`) only supply registration metadata and `render_posts_list_markup()` body output.
    - **Template parts**: Markup for these widgets lives in the PHP widget classes (and shared abstract helpers), not in `parts/widgets/posts-list-*.php`. Legacy partials under `parts/widgets/` for those layouts were removed once rendering was consolidated.
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
    1.  Create a new widget class in `origamiez/app/Widgets/Types/`, extending the appropriate base class.
    2.  Register the new class in `WidgetFactory::register_widgets()`.
- **Adding a New Sidebar**: 
    1.  Add a new `SidebarConfiguration` entry in `SidebarRegistry::setup_default_sidebars()`.
    2.  Alternatively, use `SidebarRegistry::get_instance()->register_sidebar()` from an external hook.
- **Common Issues**: 
    - **Widget Not Appearing**: Ensure the sidebar it's assigned to is actually called in the current template via `dynamic_sidebar()`.

## Related Files
- `origamiez/app/Widgets/WidgetFactory.php`
- `origamiez/app/Widgets/WidgetRegistry.php`
- `origamiez/app/Widgets/SidebarRegistry.php`
- `origamiez/app/Widgets/AbstractPostsWidgetTypeC.php`
- `origamiez/app/Widgets/AbstractPostsListTypeCWidget.php`
- `origamiez/app/Widgets/Types/` (Directory)
- `origamiez/app/Widgets/Sidebars/` (Directory)
- `origamiez/sidebar.php` (Root entry point) and `origamiez/parts/sidebar-*.php` files.
