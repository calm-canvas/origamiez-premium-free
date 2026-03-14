# Layout and Display

## Description
The Origamiez theme uses a modular approach to handle layout-related body classes and display elements like breadcrumbs. By using specialized managers and providers, the theme ensures that CSS hooks and structural elements are correctly applied based on the current WordPress context (single post, archive, page, etc.).

## Core Architecture
- **Main Classes**: 
    - `Origamiez\Engine\Layout\BodyClassManager` (`origamiez/engine/Layout/BodyClassManager.php`)
    - `Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator` (`origamiez/engine/Display/Breadcrumb/BreadcrumbGenerator.php`)
- **Dependencies**: 
    - `BodyClassProviderInterface`: Interface for classes that provide specific body classes.
    - `BreadcrumbBuilder`: Internal class that handles the logic of building the breadcrumb trail.
- **Patterns Used**: 
    - **Provider Pattern**: `BodyClassManager` aggregates classes from multiple providers (Search, Archive, Page, etc.).
    - **Builder Pattern**: `BreadcrumbGenerator` uses `BreadcrumbBuilder` to construct the breadcrumb HTML.
    - **Hook-based Display**: Breadcrumbs are triggered via a custom action hook.

## Implementation Details
- **Body Class Management**: 
    1.  `BodyClassManager` is initialized with several default providers (e.g., `PageClassProvider`, `ArchiveClassProvider`).
    2.  It hooks into the WordPress `body_class` filter.
    3.  When the filter runs, it iterates through all registered providers, each adding its own context-specific classes to the `$classes` array.
- **Breadcrumb Generation**: 
    1.  `BreadcrumbGenerator` hooks its `display_breadcrumb()` method to the custom `origamiez_print_breadcrumb` action.
    2.  The `BreadcrumbBuilder` analyzes the current WordPress query to determine the path from the home page to the current content.
    3.  Template files call `do_action('origamiez_print_breadcrumb')` to display the breadcrumbs.
- **Key Functions/Methods**:
    - `BodyClassManager::register_provider(provider)`: Adds a new class provider to the list.
    - `BodyClassProviderInterface::provide(classes)`: Method where providers add their classes.
    - `BreadcrumbGenerator::display_breadcrumb()`: Outputs the generated breadcrumb HTML.

## Maintenance & Development
- **Adding Body Classes**: 
    - To add global classes, modify `GeneralClassProvider.php`.
    - To add classes for a specific new post type, create a new class implementing `BodyClassProviderInterface` and register it in `BodyClassManager`.
- **Customizing Breadcrumbs**: 
    - The structural logic for breadcrumbs resides in `BreadcrumbBuilder.php`.
    - To change the location of breadcrumbs, move the `do_action('origamiez_print_breadcrumb')` call in the template files (e.g., `header.php`, `parts/breadcrumb.php`).
- **Common Issues**: 
    - **CSS Conflicts**: Ensure that classes added via providers do not conflict with core WordPress classes.

## Related Files
- `origamiez/engine/Layout/BodyClassManager.php`
- `origamiez/engine/Layout/Providers/` (Directory)
- `origamiez/engine/Display/Breadcrumb/BreadcrumbGenerator.php`
- `origamiez/engine/Display/Breadcrumb/BreadcrumbBuilder.php`
- `origamiez/parts/breadcrumb.php`
