# Origamiez Theme - Development Guide

## Overview

Origamiez has been refactored from a procedural architecture to a modern Object-Oriented Programming (OOP) structure. This document provides developers with guidance on working with the refactored codebase.

**Last Updated:** December 18, 2025  
**Refactor Status:** ✅ COMPLETE (Phases 1-10)

---

## Architecture Overview

### Directory Structure

```
origamiez/
├── engine/                    # OOP Service Classes
│   ├── Assets/               # Asset management
│   ├── Config/               # Configuration classes
│   ├── Customizer/           # Theme customizer
│   ├── Display/              # Display/rendering logic
│   ├── Helpers/              # Helper utilities
│   ├── Hooks/                # Hook registration
│   ├── Layout/               # Layout management
│   ├── Post/                 # Post-related classes
│   ├── Security/             # Security & validation
│   ├── Utils/                # Utility classes
│   ├── Widgets/              # Widget system
│   ├── Container.php         # DI Container
│   └── ThemeBootstrap.php    # Bootstrap/initialization
├── inc/
│   ├── classes/              # Legacy abstract widget classes
│   ├── functions.php         # Wrapper & utility functions
│   ├── sidebar.php           # [DEPRECATED - Use SidebarRegistry]
│   ├── widget.php            # [DEPRECATED - Use WidgetFactory]
│   └── customizer.php        # [DEPRECATED - Use CustomizerService]
├── parts/                    # Template parts
├── plugins/                  # Plugin integrations
├── functions.php             # Main theme setup file
└── ... (template files)
```

### Core Concepts

#### 1. Dependency Injection Container

The `Container` class (Singleton) manages all service dependencies:

```php
$container = \Origamiez\Engine\Container::getInstance();
$service = $container->get('service_name');
```

**Registered Services:**
- `config_manager` - Central configuration
- `asset_manager` - Asset enqueueing
- `body_class_manager` - Body class generation
- `breadcrumb_generator` - Breadcrumb navigation
- `customizer_service` - Customizer setup
- `widget_factory` - Widget registration
- `sidebar_registry` - Sidebar registration
- And more...

#### 2. Theme Bootstrap

The `ThemeBootstrap` class initializes the theme:

```php
// In origamiez/functions.php
$bootstrap = new \Origamiez\Engine\ThemeBootstrap();
$bootstrap->boot();
```

This method:
1. Sets up the DI container
2. Registers theme hooks
3. Registers layout managers
4. Registers display components
5. Registers widget system
6. Registers customizer

#### 3. Service Architecture

All major components follow the Service pattern:

```php
namespace Origamiez\Engine\Assets;

class AssetManager {
    public function enqueue_assets(): void {
        // Stylesheet management
        // Script management
        // Font management
        // Inline styles
    }
}
```

---

## Key Components

### Asset Management

**Classes:** `AssetManager`, `StylesheetManager`, `ScriptManager`, `FontManager`, `InlineStyleGenerator`

**Location:** `origamiez/engine/Assets/`

Manages all CSS, JavaScript, and font enqueueing:

```php
$asset_manager = $container->get('asset_manager');
$asset_manager->enqueue_assets();
```

### Layout & Body Classes

**Classes:** `BodyClassManager`, Multiple Provider Classes

**Location:** `origamiez/engine/Layout/`

Generates dynamic body classes based on page type:

```php
// Providers:
- GeneralClassProvider        # Global layout classes
- SinglePostClassProvider     # Single post classes
- PageClassProvider           # Page-specific classes
- ArchiveClassProvider        # Archive/taxonomy classes
- SearchClassProvider         # Search page classes
- NotFoundClassProvider       # 404 page classes
```

### Display Components

**Classes:** `BreadcrumbGenerator`, `ReadMoreButton`, `CommentFormBuilder`, `CommentDisplay`

**Location:** `origamiez/engine/Display/`

Handles breadcrumbs, buttons, comments, and other display elements.

**Breadcrumb Architecture:**
- Uses segment-based builder pattern
- Segments: `HomeSegment`, `SingleSegment`, `ArchiveSegment`, `SearchSegment`, `PageSegment`, `NotFoundSegment`

### Customizer System

**Classes:** `CustomizerService`, Multiple Settings Classes, `ControlFactory`

**Location:** `origamiez/engine/Customizer/`

**Settings Classes:**
- `GeneralSettings` - Header, footer, logo options
- `LayoutSettings` - Layout and sidebar options
- `BlogSettings` - Blog display options
- `SinglePostSettings` - Single post display options
- `ColorSettings` - Color customization
- `TypographySettings` - Font customization
- `SocialSettings` - Social media links
- `CustomCssSettings` - Custom CSS textarea

### Widget System

**Classes:** `WidgetFactory`, Multiple Widget Classes, `SidebarRegistry`, `WidgetClassManager`

**Location:** `origamiez/engine/Widgets/`

**Widget Types:**
- `PostsListGridWidget` - Grid layout posts
- `PostsListSliderWidget` - Slider/carousel posts
- `PostsListSmallWidget` - Compact posts list
- `PostsListZebraWidget` - Alternating layout posts
- `PostsListTwoColsWidget` - Two-column posts
- `PostsListMediaWidget` - Posts with format icons
- `PostsListWithBackgroundWidget` - Posts with background
- `SocialLinksWidget` - Social media links

**Widget Base Classes:**
- `AbstractWidget` - Base for all widgets
- `AbstractPostsWidget` - Base for posts widgets (Type A)
- `AbstractPostsWidgetTypeB` - Base for Type B posts widgets
- `AbstractPostsWidgetTypeC` - Base for Type C posts widgets

### Helper Classes

**Location:** `origamiez/engine/Helpers/`

Utility classes for common operations:

- `StringHelper` - String manipulation
- `FormatHelper` - Post format handling
- `ImageHelper` - Image utilities
- `ImageSizeManager` - Image size registration
- `MetadataHelper` - Post metadata
- `DateTimeHelper` - Time/date formatting
- `OptionsSyncHelper` - WordPress options access
- `LayoutHelper` - Layout CSS classes

### Configuration Classes

**Location:** `origamiez/engine/Config/`

Centralized configuration management:

- `ConfigManager` - Main config manager
- `BodyClassConfig` - Body class configuration
- `LayoutConfig` - Layout options
- `SkinConfig` - Color/skin configuration
- `FontConfig` - Font families
- `AllowedTagsConfig` - HTML sanitization whitelist
- `SocialConfig` - Social media configuration

---

## Legacy Functions (Still Used)

The following functions in `origamiez/inc/functions.php` are still required for backward compatibility:

### Wrapper Functions
```php
origamiez_get_format_icon($format)         // Delegates to FormatHelper
origamiez_get_breadcrumb()                 // Delegates to BreadcrumbGenerator
origamiez_list_comments()                  // Delegates to CommentDisplay
origamiez_comment_form()                   // Delegates to CommentFormBuilder
origamiez_get_button_readmore()            // Delegates to ReadMoreButton
```

### Customizer Callbacks
```php
origamiez_skin_custom_callback()           // Conditionally show skin controls
origamiez_font_body_enable_callback()      // Conditionally show font controls
origamiez_font_menu_enable_callback()
origamiez_font_site_title_enable_callback()
origamiez_font_site_subtitle_enable_callback()
origamiez_font_widget_title_enable_callback()
origamiez_font_h1_enable_callback()
origamiez_font_h2_enable_callback()
origamiez_font_h3_enable_callback()
origamiez_font_h4_enable_callback()
origamiez_font_h5_enable_callback()
origamiez_font_h6_enable_callback()
origamiez_top_bar_enable_callback()        // Show/hide top bar
```

### Utility Functions
```php
origamiez_get_author_infor()               // Display author information
origamiez_get_socials()                    // Get social media configuration
origamiez_get_allowed_tags()               // Get HTML sanitization whitelist
origamiez_get_metadata_prefix()            // Get metadata separator
origamiez_get_str_uglify()                 // Uglify strings
origamiez_return_10/15/20/30/60()          // Return number callbacks
origamiez_set_classes_for_footer_*()       // Footer column classes
origamiez_save_unyson_options()            # Legacy options sync
origamiez_sanitize_checkbox/select()       # Form sanitizers
origamiez_get_font_families/sizes/weights() # Font options
```

---

## Development Workflow

### Adding a New Theme Feature

1. **Create a Service Class:**
   ```php
   namespace Origamiez\Engine\Features;
   
   class MyFeature {
       public function initialize(): void {
           // Your code here
       }
   }
   ```

2. **Register in Container:**
   ```php
   // In ThemeBootstrap::setup_container()
   $container->set('my_feature', function() {
       return new \Origamiez\Engine\Features\MyFeature();
   });
   ```

3. **Initialize in Bootstrap:**
   ```php
   // In ThemeBootstrap::boot()
   $this->container->get('my_feature')->initialize();
   ```

### Extending a Widget

```php
use Origamiez\Engine\Widgets\AbstractPostsWidget;

class MyCustomWidget extends AbstractPostsWidget {
    public function __construct() {
        parent::__construct(
            'my-widget-id',
            esc_attr__('My Widget', 'origamiez'),
            [/* widget_ops */],
            [/* control_ops */]
        );
    }
    
    public function widget($args, $instance) {
        // Your widget output
    }
}
```

### Adding Customizer Settings

```php
use Origamiez\Engine\Customizer\Settings\SettingsInterface;

class MySettings implements SettingsInterface {
    public function register(PanelBuilder $panel_builder): void {
        // Register your settings
    }
}
```

---

## Testing & Verification

### Run Theme Tests

```bash
# Using Docker
docker compose exec cli wp eval '
    // Your test code here
'
```

### Common Test Cases

1. **Body Classes:** Check page source for correct classes
2. **Sidebars:** Verify widgets appear in Widget admin
3. **Customizer:** Check all settings save correctly
4. **Assets:** Ensure CSS/JS load without errors
5. **Widgets:** Verify widgets display correctly on frontend

### Check for PHP Errors

```bash
# In Docker
docker compose logs wordpress | grep -i "error\|fatal"
```

---

## Deprecated Files

The following files are no longer active but kept for reference:

- `origamiez/inc/sidebar.php` - Use `SidebarRegistry` instead
- `origamiez/inc/widget.php` - Use `WidgetFactory` instead
- `origamiez/inc/customizer.php` - Use `CustomizerService` instead

These files contain deprecation notices and can be safely deleted.

---

## Performance Considerations

1. **Lazy Loading:** Services are instantiated only when requested
2. **Caching:** Configuration classes cache results (e.g., `AllowedTagsConfig`)
3. **Asset Optimization:** Assets are enqueued with proper dependencies
4. **Code Splitting:** Features are isolated in separate classes

---

## Security Best Practices

1. **Input Validation:** Use `SanitizationManager` for form inputs
2. **Output Escaping:** Always escape output with appropriate functions
3. **Nonce Verification:** Use `NonceSecurity` for form submissions
4. **Capability Checks:** Verify user permissions before operations

---

## Hooks & Filters

All original WordPress hooks are preserved. Custom filters added during refactoring:

```php
apply_filters('origamiez_breadcrumb_segments', $segments)
apply_filters('origamiez_body_class_providers', $providers)
apply_filters('origamiez_widget_classes', $classes)
apply_filters('origamiez_customizer_settings', $settings)
```

---

## Troubleshooting

### Widgets Not Showing

1. Check if `SidebarRegistry::register()` is called
2. Verify sidebars are registered in customizer
3. Check widget HTML output in browser inspector

### Customizer Settings Not Saving

1. Verify setting is added to appropriate `Settings` class
2. Check sanitization callback is correct
3. Ensure `CustomizerService::register()` is called in bootstrap

### Body Classes Missing

1. Check provider is registered in `BodyClassManager`
2. Verify provider conditions (is_single, is_archive, etc.)
3. Check filter is hooked to 'body_class'

---

## Contributing

When contributing to Origamiez:

1. Follow the established OOP patterns
2. Place code in appropriate namespace/directory
3. Add unit tests for new features
4. Update this documentation
5. Ensure backward compatibility

---

## Resources

- **refactor-mapping.md** - Detailed mapping of old to new code
- **refactor-plan.md** - Complete refactor execution plan
- **WordPress Coding Standards** - Theme must follow WPCS
- **PHP-DI Documentation** - Dependency injection patterns used

---

## Version

**Refactored:** v3.1.0  
**Original Theme:** v3.0.0+  
**Tested on:** WordPress 6.8, PHP 8.4
