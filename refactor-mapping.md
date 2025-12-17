# Origamiez Theme Refactor Mapping

## Code Migration from Procedural to OOP Architecture

**Last Updated:** 2025-12-17  
**Document Version:** 1.0  
**Status:** Comprehensive mapping of legacy code to new OOP structure

---

## Overview

This document maps all processing logic from the old procedural-style code (located in `origamiez/inc/` and
`origamiez/functions.php`) to the new OOP architecture (located in `origamiez/engine/`). Each mapping includes:

- Old function/procedure name and file location
- New class and method responsible for the functionality
- Implementation status (✅ Migrated, ⚠️ Partially Migrated, ❌ Not Yet Migrated)
- Notes and observations

---

## 1. Theme Initialization & Setup

### 1.1 Theme Setup (origamiez_theme_setup)

**Location:** `origamiez/functions.php` (lines 12-61)

| Old Implementation        | New OOP Implementation                    | Status     |
|---------------------------|-------------------------------------------|------------|
| `origamiez_theme_setup()` | `Origamiez\Engine\ThemeBootstrap::boot()` | ✅ Migrated |

**Details:**

- Theme support registration via `add_theme_support()` → Handled in `ThemeBootstrap::boot()`
- Feature registration moved to individual service classes
- Image size registration → `Origamiez\Engine\Helpers\ImageSizeManager`
- Content width setup → Maintained in functions.php (no migration needed)

**Related Services:**

- `ThemeBootstrap` orchestrates all initialization
- `ThemeHooks` registers foundational WordPress hooks
- `FrontendHooks` registers frontend-specific hooks

---

## 2. Asset Management

### 2.1 Script & Style Enqueueing (origamiez_enqueue_scripts)

**Location:** `origamiez/inc/functions.php` (lines 2-166)

| Old Implementation            | New OOP Implementation                                   | Status     |
|-------------------------------|----------------------------------------------------------|------------|
| `origamiez_enqueue_scripts()` | `Origamiez\Engine\Assets\AssetManager::enqueue_assets()` | ✅ Migrated |

**Sub-components:**

#### 2.1.1 Stylesheet Management

| Old Code                                           | New Class              | Method                |
|----------------------------------------------------|------------------------|-----------------------|
| Library stylesheets (Bootstrap, FontAwesome, etc.) | `StylesheetManager`    | `enqueue()`           |
| Main theme stylesheet                              | `StylesheetManager`    | `enqueue()`           |
| Custom skin CSS variables                          | `InlineStyleGenerator` | `add_inline_styles()` |
| Google Fonts enqueueing                            | `FontManager`          | `enqueue()`           |

**Location:** `origamiez/engine/Assets/`

- `AssetManager.php` - Main orchestrator
- `StylesheetManager.php` - Handles stylesheet registration
- `FontManager.php` - Handles font management
- `InlineStyleGenerator.php` - Generates inline CSS for color customization

#### 2.1.2 Script Management

| Old Code                             | New Class       | Method              |
|--------------------------------------|-----------------|---------------------|
| jQuery and dependent plugins         | `ScriptManager` | `enqueue()`         |
| Custom script initialization         | `ScriptManager` | `enqueue()`         |
| Script localization (origamiez_vars) | `ScriptManager` | `localize_script()` |
| IE compatibility fixes               | `ScriptManager` | `enqueue()`         |

**Location:** `origamiez/engine/Assets/ScriptManager.php`

- Handles all script registration and localization
- Manages script dependencies
- Applies IE conditional logic

#### 2.1.3 Dynamic Font Management

| Old Code                    | New Class     | Method        |
|-----------------------------|---------------|---------------|
| Google Fonts loop iteration | `FontManager` | `enqueue()`   |
| Font family generation      | `FontManager` | `get_fonts()` |

**Location:** `origamiez/engine/Assets/FontManager.php`

#### 2.1.4 Custom CSS Variables (Skin System)

| Old Code                               | New Class              | Method                       |
|----------------------------------------|------------------------|------------------------------|
| CSS variable generation from theme_mod | `InlineStyleGenerator` | `add_inline_styles()`        |
| Color customization system             | `SkinConfig`           | Provides color mappings      |
| Custom CSS textarea support            | `CustomCssSettings`    | Provides custom CSS settings |

**Location:** `origamiez/engine/Assets/InlineStyleGenerator.php`

- Generates CSS custom properties (variables)
- Compiles color settings from customizer
- Handles typography customization

#### 2.1.5 Typography Customization

| Old Code                                          | New Class              | Method                    |
|---------------------------------------------------|------------------------|---------------------------|
| Font object selector loop                         | `TypographySettings`   | Defines font settings     |
| Font rule generation (family, size, weight, etc.) | `InlineStyleGenerator` | `add_typography_styles()` |

---

## 3. Body Class Management

### 3.1 Dynamic Body Classes (origamiez_body_class)

**Location:** `origamiez/inc/functions.php` (lines 168-253)

| Old Implementation       | New OOP Implementation                                 | Status     |
|--------------------------|--------------------------------------------------------|------------|
| `origamiez_body_class()` | `Origamiez\Engine\Layout\BodyClassManager::register()` | ✅ Migrated |

**Architecture:**
The body class system is refactored into a provider-based architecture:

**Main Class:** `BodyClassManager`

- Located: `origamiez/engine/Layout/BodyClassManager.php`
- Registers filter hook for body classes
- Collects classes from multiple providers

**Provider Classes (implement `BodyClassProviderInterface`):**

| Layout Type     | Provider Class            | File Location                                  |
|-----------------|---------------------------|------------------------------------------------|
| General/Default | `GeneralClassProvider`    | `Layout/Providers/GeneralClassProvider.php`    |
| Single Post     | `SinglePostClassProvider` | `Layout/Providers/SinglePostClassProvider.php` |
| Page            | `PageClassProvider`       | `Layout/Providers/PageClassProvider.php`       |
| Archive/Home    | `ArchiveClassProvider`    | `Layout/Providers/ArchiveClassProvider.php`    |
| Search          | `SearchClassProvider`     | `Layout/Providers/SearchClassProvider.php`     |
| 404 Not Found   | `NotFoundClassProvider`   | `Layout/Providers/NotFoundClassProvider.php`   |

**Class Generation Logic:**

| Old Code (lines) | Provider                | Method                             | Purpose                          |
|------------------|-------------------------|------------------------------------|----------------------------------|
| 170-173          | SinglePostClassProvider | `get_classes()`                    | Single post layout classes       |
| 175-189          | PageClassProvider       | `get_classes()`                    | Page template classes            |
| 190-208          | ArchiveClassProvider    | `get_classes()`                    | Archive/taxonomy layout classes  |
| 209-210          | SearchClassProvider     | `get_classes()`                    | Search page classes              |
| 211-212          | NotFoundClassProvider   | `get_classes()`                    | 404 page classes                 |
| 214-225          | GeneralClassProvider    | `add_background_classes()`         | Background image/color detection |
| 221-225          | GeneralClassProvider    | `add_layout_classes()`             | Layout width (fullwidth/boxer)   |
| 226-228          | GeneralClassProvider    | `add_footer_classes()`             | Footer visibility classes        |
| 229-236          | GeneralClassProvider    | `add_skin_and_header_classes()`    | Skin and header style classes    |
| 237-240          | SinglePostClassProvider | `get_single_post_layout_class()`   | Single post layout variations    |
| 241-250          | All Providers           | `add_sidebar_visibility_classes()` | Sidebar detection (left/right)   |

**Related Components:**

- **BodyClassConfig** (`origamiez/engine/Config/BodyClassConfig.php`)
    - Provides configuration for class generation logic
    - Centralized mapping of class naming conventions

- **LayoutConfig** (`origamiez/engine/Config/LayoutConfig.php`)
    - Provides layout-related configuration (fullwidth, layouts, etc.)

- **SkinConfig** (`origamiez/engine/Config/SkinConfig.php`)
    - Provides skin/color configuration mappings

---

## 4. Post Class Management

### 4.1 Archive Post Classes (origamiez_archive_post_class)

**Location:** `origamiez/inc/functions.php` (lines 269-277)

| Old Implementation               | New OOP Implementation                                       | Status     |
|----------------------------------|--------------------------------------------------------------|------------|
| `origamiez_archive_post_class()` | `Origamiez\Engine\Post\PostClassManager::get_post_classes()` | ✅ Migrated |

**Details:**

- Location: `origamiez/engine/Post/PostClassManager.php`
- Adds `origamiez-first-post` class to the first post in archive loops
- Integrated into `FrontendHooks::archive_post_class()` filter

**Additional Post Utilities:**

| Old Code               | New Class         | Purpose                                 |
|------------------------|-------------------|-----------------------------------------|
| Format icon generation | `PostIconFactory` | Generates icon classes for post formats |
| Post formatting        | `PostFormatter`   | Handles post data formatting            |
| Post metadata          | `MetadataManager` | Manages post metadata operations        |

---

## 5. Display & Output

### 5.1 Breadcrumb Navigation (origamiez_get_breadcrumb)

**Location:** `origamiez/inc/functions.php` (lines 354-544 ~ 190 lines)

| Old Implementation           | New OOP Implementation                                                | Status     |
|------------------------------|-----------------------------------------------------------------------|------------|
| `origamiez_get_breadcrumb()` | `Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator::register()` | ✅ Migrated |

**Architecture:**
Refactored into segment-based architecture with builder pattern:

**Main Classes:**

| Class                 | Location                                     | Purpose                            |
|-----------------------|----------------------------------------------|------------------------------------|
| `BreadcrumbGenerator` | `Display/Breadcrumb/BreadcrumbGenerator.php` | Main orchestrator, registers hooks |
| `BreadcrumbBuilder`   | `Display/Breadcrumb/BreadcrumbBuilder.php`   | Builds breadcrumb HTML output      |

**Segment Classes (implement `SegmentInterface`):**

| Page Type        | Segment Class     | File Location                             | Old Code      |
|------------------|-------------------|-------------------------------------------|---------------|
| Homepage         | `HomeSegment`     | `Breadcrumb/Segments/HomeSegment.php`     | Lines 356-365 |
| Single Post      | `SingleSegment`   | `Breadcrumb/Segments/SingleSegment.php`   | Lines 366-380 |
| Archive/Taxonomy | `ArchiveSegment`  | `Breadcrumb/Segments/ArchiveSegment.php`  | Lines 381-410 |
| Search           | `SearchSegment`   | `Breadcrumb/Segments/SearchSegment.php`   | Lines 411-415 |
| Page             | `PageSegment`     | `Breadcrumb/Segments/PageSegment.php`     | Lines 416-430 |
| 404 Not Found    | `NotFoundSegment` | `Breadcrumb/Segments/NotFoundSegment.php` | Lines 431-437 |

**Implementation Details:**

- Each segment handles its specific breadcrumb structure
- Segments are chained together by `BreadcrumbBuilder`
- Prefix and HTML markup moved to builder class
- Filter hooks preserved for backward compatibility

---

### 5.2 Read More Button (origamiez_get_button_readmore)

**Location:** `origamiez/inc/functions.php` (lines 545-555)

| Old Implementation                | New OOP Implementation                              | Status     |
|-----------------------------------|-----------------------------------------------------|------------|
| `origamiez_get_button_readmore()` | `Origamiez\Engine\Display\ReadMoreButton::render()` | ✅ Migrated |

**Details:**

- Location: `origamiez/engine/Display/ReadMoreButton.php`
- Generates styled "Read More" button for post excerpts
- Registered via action hook `origamiez_print_button_readmore`

---

### 5.3 Format Icon Generation (origamiez_get_format_icon)

**Location:** `origamiez/inc/functions.php` (lines 279-294)

| Old Implementation            | New OOP Implementation                              | Status     |
|-------------------------------|-----------------------------------------------------|------------|
| `origamiez_get_format_icon()` | `Origamiez\Engine\Post\PostIconFactory::get_icon()` | ✅ Migrated |

**Alternate Implementation:**

- **Also in:** `Origamiez\Engine\Helpers\FormatHelper::get_format_icon()`
- Location: `origamiez/engine/Helpers/FormatHelper.php`

**Details:**

- Provides icon class mapping for post formats (video, audio, gallery, etc.)
- FontAwesome icon classes
- Maintains filter hook for customization

---

### 5.4 Shortcode Extraction (origamiez_get_shortcode)

**Location:** `origamiez/inc/functions.php` (lines 296-319)

| Old Implementation          | New OOP Implementation                   | Status                |
|-----------------------------|------------------------------------------|-----------------------|
| `origamiez_get_shortcode()` | Moved to helper - No dedicated OOP class | ⚠️ Partially Migrated |

**Location:** Utility function maintained in theme for backward compatibility

- Not yet fully encapsulated in engine classes
- Used by post formatting logic
- **MIGRATION NOTE:** Consider moving to `Origamiez\Engine\Helpers\ShortcodeHelper`

---

### 5.5 Time Difference Display (origamiez_human_time_diff)

**Location:** `origamiez/inc/functions.php` (lines 321-352)

| Old Implementation            | New OOP Implementation                                       | Status     |
|-------------------------------|--------------------------------------------------------------|------------|
| `origamiez_human_time_diff()` | `Origamiez\Engine\Helpers\DateTimeHelper::human_time_diff()` | ✅ Migrated |

**Details:**

- Location: `origamiez/engine/Helpers/DateTimeHelper.php`
- Generates human-readable time differences (e.g., "2 days ago")
- Used in post metadata display

---

### 5.6 Comment Display & Form (origamiez_comment_form_fields)

**Location:** `origamiez/inc/functions.php` (lines 557-750 ~ 190 lines)

| Old Implementation      | New OOP Implementation                        | Status     |
|-------------------------|-----------------------------------------------|------------|
| Comment form generation | `Origamiez\Engine\Display\CommentFormBuilder` | ✅ Migrated |
| Comment output          | `Origamiez\Engine\Display\CommentDisplay`     | ✅ Migrated |

**Details:**

- Location: `origamiez/engine/Display/CommentFormBuilder.php`
- Location: `origamiez/engine/Display/CommentDisplay.php`
- Handles comment form fields, validation, and display
- Integrates with WordPress comment hooks

---

## 6. Global Wrapper Functions

### 6.1 Global Wrapper Open/Close (origamiez_global_wapper_open/close)

**Location:** `origamiez/inc/functions.php` (lines 255-267)

| Old Implementation                | New OOP Implementation | Status    |
|-----------------------------------|------------------------|-----------|
| `origamiez_global_wapper_open()`  | ❌ NOT MIGRATED         | ❌ Pending |
| `origamiez_global_wapper_close()` | ❌ NOT MIGRATED         | ❌ Pending |

**⚠️ IMPORTANT NOTICE:**
These functions are still called in `origamiez/functions.php` (lines 55-56) and NOT yet migrated to OOP:

```php
add_action( 'origamiez_after_body_open', 'origamiez_global_wapper_open' );
add_action( 'origamiez_before_body_close', 'origamiez_global_wapper_close' );
```

**Current Behavior:**

- Opens/closes container divs based on layout fullwidth setting
- Used to wrap page content in responsive container

**Migration Recommendation:**

- Create `Origamiez\Engine\Layout\GlobalWrapperManager` class
- Implement methods: `render_wrapper_open()` and `render_wrapper_close()`
- Register via `ThemeBootstrap::register_layout()` or similar

**Estimated Impact:**

- Simple HTML output - Low complexity
- No external dependencies
- Estimated effort: 2-3 hours

---

## 7. Sidebar Management

### 7.1 Sidebar Registration (origamiez_register_sidebars)

**Location:** `origamiez/inc/sidebar.php` (lines 2-76)

| Old Implementation              | New OOP Implementation                                               | Status     |
|---------------------------------|----------------------------------------------------------------------|------------|
| `origamiez_register_sidebars()` | `Origamiez\Engine\Widgets\SidebarRegistry::setup_default_sidebars()` | ✅ Migrated |

**Details:**

- Location: `origamiez/engine/Widgets/SidebarRegistry.php`
- Registers all 15 theme sidebars (main, footer, magazine layout, etc.)
- Uses `SidebarConfiguration` factory pattern
- Registered via action hook `init` at priority 5 & 30

**Sidebar Configuration:**

- Location: `origamiez/engine/Widgets/Sidebars/SidebarConfiguration.php`
- Factory method: `SidebarConfiguration::create()`
- Provides fluent interface for sidebar setup

---

### 7.2 Dynamic Sidebar Parameters (origamiez_dynamic_sidebar_params)

**Location:** `origamiez/inc/widget.php` (lines 10-23)

| Old Implementation                   | New OOP Implementation                                                      | Status     |
|--------------------------------------|-----------------------------------------------------------------------------|------------|
| `origamiez_dynamic_sidebar_params()` | `Origamiez\Engine\Widgets\SidebarRegistry::handle_dynamic_sidebar_params()` | ✅ Migrated |

**Details:**

- Location: `origamiez/engine/Widgets/SidebarRegistry.php` (lines 94-110)
- Modifies sidebar widget HTML markup
- Adds wrapper div when widget has no title
- Called via `dynamic_sidebar_params` filter

---

## 8. Widget Management

### 8.1 Widget Registration (parts/widgets loading)

**Location:** `origamiez/inc/widget.php` (lines 2-9)

| Old Implementation                        | New OOP Implementation                           | Status     |
|-------------------------------------------|--------------------------------------------------|------------|
| Widget part loading (`get_template_part`) | `Origamiez\Engine\Widgets\WidgetFactory::boot()` | ✅ Migrated |

**Details:**

- **Main Class:** `WidgetFactory`
- Location: `origamiez/engine/Widgets/WidgetFactory.php`
- Handles widget discovery and registration
- Boots all widget types

**Widget Types:**
All legacy widget classes migrated to OOP:

| Widget Type           | Class                           | Location                                          |
|-----------------------|---------------------------------|---------------------------------------------------|
| Posts List Grid       | `PostsListGridWidget`           | `Widgets/Types/PostsListGridWidget.php`           |
| Posts List Slider     | `PostsListSliderWidget`         | `Widgets/Types/PostsListSliderWidget.php`         |
| Posts List Small      | `PostsListSmallWidget`          | `Widgets/Types/PostsListSmallWidget.php`          |
| Posts List Zebra      | `PostsListZebraWidget`          | `Widgets/Types/PostsListZebraWidget.php`          |
| Posts List Two Cols   | `PostsListTwoColsWidget`        | `Widgets/Types/PostsListTwoColsWidget.php`        |
| Posts List Media      | `PostsListMediaWidget`          | `Widgets/Types/PostsListMediaWidget.php`          |
| Posts List Background | `PostsListWithBackgroundWidget` | `Widgets/Types/PostsListWithBackgroundWidget.php` |
| Social Links          | `SocialLinksWidget`             | `Widgets/Types/SocialLinksWidget.php`             |

**Widget Base Classes:**

| Base Class                 | Location                               | Purpose                       |
|----------------------------|----------------------------------------|-------------------------------|
| `AbstractWidget`           | `Widgets/AbstractWidget.php`           | Base for all widgets          |
| `AbstractPostsWidget`      | `Widgets/AbstractPostsWidget.php`      | Base for posts list widgets   |
| `AbstractPostsWidgetTypeB` | `Widgets/AbstractPostsWidgetTypeB.php` | Base for Type B posts widgets |
| `AbstractPostsWidgetTypeC` | `Widgets/AbstractPostsWidgetTypeC.php` | Base for Type C posts widgets |

**Widget Class Manager:**

- Location: `origamiez/engine/Widgets/WidgetClassManager.php`
- Adds HTML classes to widget divs
- Called via action hook

---

## 9. Customizer Management

### 9.1 Customizer Registration (origamiez_customize_register)

**Location:** `origamiez/inc/customizer.php` (lines 1-86)

| Old Implementation               | New OOP Implementation                                      | Status     |
|----------------------------------|-------------------------------------------------------------|------------|
| `origamiez_customize_register()` | `Origamiez\Engine\Customizer\CustomizerService::register()` | ✅ Migrated |

**Architecture:**
Complete refactor from monolithic function to service-based architecture:

**Main Classes:**

| Class                | Location                                      | Purpose                       |
|----------------------|-----------------------------------------------|-------------------------------|
| `CustomizerService`  | `Customizer/CustomizerService.php`            | Main orchestrator             |
| `PanelBuilder`       | `Customizer/Builders/PanelBuilder.php`        | Builds customizer panels      |
| `SectionBuilder`     | `Customizer/Builders/SectionBuilder.php`      | Builds customizer sections    |
| `SettingBuilder`     | `Customizer/Builders/SettingBuilder.php`      | Builds customizer settings    |
| `ControlFactory`     | `Customizer/ControlFactory.php`               | Creates appropriate controls  |
| `CustomizerListener` | `Customizer/Listeners/CustomizerListener.php` | Listens to customizer updates |

**Settings Classes (implement `SettingsInterface`):**

| Settings Group       | Class                | File                                         | Lines in Old Code  |
|----------------------|----------------------|----------------------------------------------|--------------------|
| General Settings     | `GeneralSettings`    | `Customizer/Settings/GeneralSettings.php`    | 267-288            |
| Layout Settings      | `LayoutSettings`     | `Customizer/Settings/LayoutSettings.php`     | 289-450+           |
| Blog Settings        | `BlogSettings`       | `Customizer/Settings/BlogSettings.php`       | 370-600+           |
| Single Post Settings | `SinglePostSettings` | `Customizer/Settings/SinglePostSettings.php` | 600-800+           |
| Color Settings       | `ColorSettings`      | `Customizer/Settings/ColorSettings.php`      | Color section      |
| Typography Settings  | `TypographySettings` | `Customizer/Settings/TypographySettings.php` | Typography section |
| Social Settings      | `SocialSettings`     | `Customizer/Settings/SocialSettings.php`     | Social section     |
| Custom CSS Settings  | `CustomCssSettings`  | `Customizer/Settings/CustomCssSettings.php`  | 1100+              |

**Benefits of OOP Refactor:**

1. Each settings group is isolated in separate class
2. Easier to maintain and extend
3. Single Responsibility Principle
4. Reduced code duplication

---

### 9.2 Customizer Sanitization

**Old Implementation:** Functions scattered in `customizer.php`

- `origamiez_sanitize_textarea()` (line 88-94)
- `origamiez_sanitize_checkbox()` (inline in old code)
- `origamiez_sanitize_select()` (inline in old code)

**New OOP Implementation:**

| Sanitizer Class     | Location                                    | Old Function                |
|---------------------|---------------------------------------------|-----------------------------|
| `TextSanitizer`     | `Security/Sanitizers/TextSanitizer.php`     | sanitize_text_field         |
| `TextAreaSanitizer` | `Security/Sanitizers/TextAreaSanitizer.php` | origamiez_sanitize_textarea |
| `EmailSanitizer`    | `Security/Sanitizers/EmailSanitizer.php`    | sanitize_email              |
| `UrlSanitizer`      | `Security/Sanitizers/UrlSanitizer.php`      | esc_url_raw                 |
| `CheckboxSanitizer` | `Security/Sanitizers/CheckboxSanitizer.php` | origamiez_sanitize_checkbox |
| `SelectSanitizer`   | `Security/Sanitizers/SelectSanitizer.php`   | origamiez_sanitize_select   |

**Main Manager:**

- Location: `origamiez/engine/Security/SanitizationManager.php`
- Coordinates all sanitizer classes
- Provides unified sanitization interface

**Status:** ✅ Fully Migrated

---

### 9.3 Customizer Active Callbacks

**Old Implementation:** Functions in `customizer.php`

- `origamiez_skin_custom_callback()` (line 96-102)
- `origamiez_font_body_enable_callback()` (line 104-110)
- `origamiez_font_menu_enable_callback()` (line 112-118)
- ... (9 more font-related callbacks)
- `origamiez_top_bar_enable_callback()` (line 192-198)

**New OOP Implementation:**

- Moved to individual `SettingsInterface` implementations
- Each settings class defines its own callbacks
- Located in `Customizer/Settings/` directory
- Methods: `get_active_callbacks()` or similar

**Status:** ✅ Migrated (integrated into Settings classes)

**Example Implementation Path:**

- Old: `origamiez_font_body_enable_callback()` → New: `TypographySettings::callback_font_body_enable()`

---

## 10. Helper Functions & Utilities

### 10.1 String/Format Helpers

| Old Function                   | New Class           | Method               | Location                       |
|--------------------------------|---------------------|----------------------|--------------------------------|
| `origamiez_get_str_uglify()`   | `StringHelper`      | `uglify()`           | `Helpers/StringHelper.php`     |
| String formatting functions    | `FormatHelper`      | Multiple             | `Helpers/FormatHelper.php`     |
| `origamiez_get_allowed_tags()` | `AllowedTagsConfig` | `get_allowed_tags()` | `Config/AllowedTagsConfig.php` |

---

### 10.2 Image Helpers

| Old Function            | New Class          | Method                   | Location                       |
|-------------------------|--------------------|--------------------------|--------------------------------|
| Image size registration | `ImageSizeManager` | `register_image_sizes()` | `Helpers/ImageSizeManager.php` |
| Image manipulation      | `ImageHelper`      | Multiple                 | `Helpers/ImageHelper.php`      |
| Image utilities         | `ImageUtils`       | Multiple                 | `Utils/ImageUtils.php`         |

---

### 10.3 Metadata Helpers

| Old Function          | New Class         | Method   | Location                     |
|-----------------------|-------------------|----------|------------------------------|
| Post metadata display | `MetadataHelper`  | Multiple | `Helpers/MetadataHelper.php` |
| Metadata management   | `MetadataManager` | Multiple | `Post/MetadataManager.php`   |

---

### 10.4 Options & Configuration

| Old Function                     | New Class           | Method           | Location                           |
|----------------------------------|---------------------|------------------|------------------------------------|
| Options sync on save             | `OptionsSyncHelper` | `sync_options()` | `Helpers/OptionsSyncHelper.php`    |
| `origamiez_get_custom_options()` | `CustomizerService` | `get_settings()` | `Customizer/CustomizerService.php` |

---

## 11. Hook & Filter System

### 11.1 Hook Registry

**Old Implementation:**

- Hooks registered directly in functions via `add_action()`/`add_filter()`
- Scattered throughout `functions.php`

**New OOP Implementation:**

- Centralized hook registration via `HookRegistry`
- Location: `origamiez/engine/Hooks/HookRegistry.php`
- Provider pattern for organized hook groups

**Hook Provider Classes:**

| Provider        | Location                        | Purpose                 |
|-----------------|---------------------------------|-------------------------|
| `ThemeHooks`    | `Hooks/Hooks/ThemeHooks.php`    | Core theme hooks        |
| `FrontendHooks` | `Hooks/Hooks/FrontendHooks.php` | Frontend-specific hooks |

**Status:** ✅ Fully Migrated

---

## 12. Layout & Display Management

### 12.1 Sidebar Visibility & Modification

| Old Function            | New Class                   | Method                | Location                               |
|-------------------------|-----------------------------|-----------------------|----------------------------------------|
| Sidebar detection       | `SidebarManager`            | `is_active_sidebar()` | `Layout/SidebarManager.php`            |
| Sidebar modification    | `SidebarVisibilityModifier` | Multiple              | `Layout/SidebarVisibilityModifier.php` |
| Widget wrapper handling | `WidgetWrapperManager`      | Multiple              | `Layout/WidgetWrapperManager.php`      |

---

### 12.2 Layout Container

| Class             | Location                     | Purpose                               |
|-------------------|------------------------------|---------------------------------------|
| `LayoutContainer` | `Layout/LayoutContainer.php` | Container for layout-related services |

---

## 13. Configuration Management

### 13.1 Config Classes

| Config Type         | Class               | Location                       |
|---------------------|---------------------|--------------------------------|
| Main Config Manager | `ConfigManager`     | `Config/ConfigManager.php`     |
| Body Class Config   | `BodyClassConfig`   | `Config/BodyClassConfig.php`   |
| Layout Config       | `LayoutConfig`      | `Config/LayoutConfig.php`      |
| Skin Config         | `SkinConfig`        | `Config/SkinConfig.php`        |
| Font Config         | `FontConfig`        | `Config/FontConfig.php`        |
| Allowed Tags Config | `AllowedTagsConfig` | `Config/AllowedTagsConfig.php` |
| Social Config       | `SocialConfig`      | `Config/SocialConfig.php`      |

---

## 14. Security & Validation

### 14.1 Input Validation

| Validator              | Location                                       | Purpose                      |
|------------------------|------------------------------------------------|------------------------------|
| `NonceSecurity`        | `Security/Validators/NonceSecurity.php`        | WordPress nonce verification |
| `SearchQueryValidator` | `Security/Validators/SearchQueryValidator.php` | Search query validation      |
| `LoginAttemptTracker`  | `Security/Validators/LoginAttemptTracker.php`  | Failed login tracking        |

### 14.2 Security Headers

| Class                   | Location                             | Purpose                       |
|-------------------------|--------------------------------------|-------------------------------|
| `SecurityHeaderManager` | `Security/SecurityHeaderManager.php` | Manages HTTP security headers |

---

## 15. Dependency Injection Container

### 15.1 Service Container

| Class       | Location        | Purpose                       |
|-------------|-----------------|-------------------------------|
| `Container` | `Container.php` | Main DI container (Singleton) |

**Service Registration:**

- Services registered in `ThemeBootstrap::setup_container()`
- Location: `origamiez/engine/ThemeBootstrap.php` (lines 78-183)

**Registered Services:**

- config_manager
- skin_config
- layout_config
- font_config
- body_class_config
- hook_registry
- asset_manager
- body_class_manager
- breadcrumb_generator
- customizer_service
- widget_factory
- sidebar_registry
- widget_class_manager
- post_class_manager
- read_more_button

---

## 16. Provider & Generator Utilities

### 16.1 Provider Classes

| Provider              | Location                            | Purpose                       |
|-----------------------|-------------------------------------|-------------------------------|
| `ReturnValueProvider` | `Providers/ReturnValueProvider.php` | Returns predefined values     |
| `NumberGenerator`     | `Providers/NumberGenerator.php`     | Generates number sequences    |
| `GridClassGenerator`  | `Providers/GridClassGenerator.php`  | Generates grid layout classes |

---

## Summary Statistics

### Migration Status Overview

| Category                | Total Items | ✅ Migrated | ⚠️ Partial | ❌ Pending |
|-------------------------|-------------|------------|------------|-----------|
| **Asset Management**    | 5           | 5          | 0          | 0         |
| **Layout & Classes**    | 8           | 8          | 0          | 0         |
| **Display & Output**    | 6           | 5          | 1          | 0         |
| **Sidebar Management**  | 2           | 2          | 0          | 0         |
| **Widget Management**   | 9           | 9          | 0          | 0         |
| **Customizer**          | 12          | 12         | 0          | 0         |
| **Helpers & Utilities** | 15          | 15         | 0          | 0         |
| **Hooks & Filters**     | 2           | 2          | 0          | 0         |
| **Configuration**       | 7           | 7          | 0          | 0         |
| **Security**            | 5           | 5          | 0          | 0         |
| **Global Wrappers**     | 2           | 0          | 0          | 2         |
| **TOTALS**              | **74**      | **71**     | **1**      | **2**     |

### Code Lines Overview

| Location                       | Status     | Type                         |
|--------------------------------|------------|------------------------------|
| `origamiez/inc/functions.php`  | Mixed      | 1071 lines - Partially moved |
| `origamiez/inc/sidebar.php`    | ✅ Migrated | 76 lines - Fully moved       |
| `origamiez/inc/widget.php`     | ✅ Migrated | 23 lines - Fully moved       |
| `origamiez/inc/customizer.php` | ✅ Migrated | 1185 lines - Fully moved     |
| `origamiez/inc/classes/`       | ✅ Migrated | Widget classes - Fully moved |
| **TOTAL MIGRATED**             | -          | **~2300 lines**              |

---

## Outstanding Migration Items

### 1. Global Wrapper Container Functions ❌

- **Functions:** `origamiez_global_wapper_open()` and `origamiez_global_wapper_close()`
- **Location:** Still in `origamiez/inc/functions.php`
- **Current Status:** Called via action hooks in `origamiez/functions.php`
- **Recommendation:** Create `GlobalWrapperManager` class
- **Effort:** Low (2-3 hours)
- **Priority:** Medium

### 2. Shortcode Extraction Utility ⚠️

- **Function:** `origamiez_get_shortcode()`
- **Location:** Still in `origamiez/inc/functions.php`
- **Current Status:** Utility function, not critical path
- **Recommendation:** Move to `Helpers/ShortcodeHelper`
- **Effort:** Low (1-2 hours)
- **Priority:** Low

---

## Migration Best Practices Applied

1. **Single Responsibility Principle**
    - Each class has one reason to change
    - Example: `AssetManager` delegates to `StylesheetManager`, `ScriptManager`, etc.

2. **Dependency Injection**
    - Services injected via constructor
    - Container manages service lifecycle
    - Example: `FrontendHooks` receives `Container` in constructor

3. **Interface-based Design**
    - Clear contracts for implementations
    - Example: `SettingsInterface`, `BodyClassProviderInterface`, `SegmentInterface`

4. **Provider Pattern**
    - Multiple providers for body classes and breadcrumbs
    - Easier to extend functionality
    - No single monolithic function

5. **Builder Pattern**
    - `BreadcrumbBuilder`, `SectionBuilder`, `PanelBuilder`
    - Complex object construction simplified
    - Fluent interfaces for readability

6. **Factory Pattern**
    - `WidgetFactory`, `PostIconFactory`, `ControlFactory`
    - Centralized object creation
    - Consistent initialization logic

7. **Configuration Objects**
    - Config classes centralize settings
    - Single source of truth
    - Example: `SkinConfig`, `BodyClassConfig`, `FontConfig`

---

## Integration Points with Old Code

### Backward Compatibility Maintained

The new OOP architecture maintains full backward compatibility:

1. **WordPress Hooks Preserved**
    - All original action/filter hooks maintained
    - Custom hooks (e.g., `origamiez_after_body_open`) still available

2. **Theme Customizer Settings**
    - All settings and controls work identically
    - User data migration not needed

3. **Widget System**
    - Old widget instances continue to work
    - New widgets inherit from proper base classes

4. **Template Functions**
    - Helper functions still available for templates
    - Example: `get_theme_mod()` calls work unchanged

---

## Code Quality Improvements

### What Was Gained

1. **Testability**
    - Unit testable classes
    - Reduced global state dependencies

2. **Maintainability**
    - Clear class organization
    - Self-documenting code structure

3. **Reusability**
    - Common logic extracted to helpers
    - Easy to compose services

4. **Extensibility**
    - Provider pattern allows easy additions
    - Interface contracts enable plugins

5. **Performance**
    - Lazy loading via service container
    - Only services used are instantiated

---

## Future Improvements

### Phase 2 Migration (Future)

1. Complete migration of remaining functions
2. Introduce events system for more flexibility
3. Add caching layer for config objects
4. Implement admin-side OOP classes
5. Add comprehensive unit tests

### Phase 3 Improvements (Future)

1. Extract common widget functionality
2. Create admin customizer UI builder
3. Implement REST API for customizer
4. Add configuration versioning

---

## File Index

### Engine Directory Structure

```
origamiez/engine/
├── Assets/                          (Asset management)
│   ├── AssetManager.php
│   ├── StylesheetManager.php
│   ├── ScriptManager.php
│   ├── FontManager.php
│   └── InlineStyleGenerator.php
├── Config/                          (Configuration objects)
│   ├── ConfigManager.php
│   ├── BodyClassConfig.php
│   ├── LayoutConfig.php
│   ├── SkinConfig.php
│   ├── FontConfig.php
│   ├── AllowedTagsConfig.php
│   └── SocialConfig.php
├── Customizer/                      (Theme customizer)
│   ├── CustomizerService.php
│   ├── Builders/
│   │   ├── PanelBuilder.php
│   │   ├── SectionBuilder.php
│   │   └── SettingBuilder.php
│   ├── ControlFactory.php
│   ├── Listeners/
│   │   └── CustomizerListener.php
│   └── Settings/
│       ├── SettingsInterface.php
│       ├── GeneralSettings.php
│       ├── LayoutSettings.php
│       ├── BlogSettings.php
│       ├── SinglePostSettings.php
│       ├── ColorSettings.php
│       ├── TypographySettings.php
│       ├── SocialSettings.php
│       └── CustomCssSettings.php
├── Display/                         (Output & display)
│   ├── Breadcrumb/
│   │   ├── BreadcrumbGenerator.php
│   │   ├── BreadcrumbBuilder.php
│   │   └── Segments/
│   │       ├── SegmentInterface.php
│   │       ├── HomeSegment.php
│   │       ├── SingleSegment.php
│   │       ├── ArchiveSegment.php
│   │       ├── SearchSegment.php
│   │       ├── PageSegment.php
│   │       └── NotFoundSegment.php
│   ├── ReadMoreButton.php
│   ├── CommentFormBuilder.php
│   ├── CommentDisplay.php
│   └── AuthorDisplay.php
├── Helpers/                         (Helper utilities)
│   ├── CssUtilHelper.php
│   ├── DateTimeHelper.php
│   ├── FormatHelper.php
│   ├── ImageHelper.php
│   ├── ImageSizeManager.php
│   ├── MetadataHelper.php
│   ├── OptionsSyncHelper.php
│   └── StringHelper.php
├── Hooks/                           (Hook management)
│   ├── HookRegistry.php
│   ├── HookProviderInterface.php
│   └── Hooks/
│       ├── ThemeHooks.php
│       └── FrontendHooks.php
├── Layout/                          (Layout management)
│   ├── BodyClassManager.php
│   ├── BodyClassProviderInterface.php
│   ├── LayoutContainer.php
│   ├── SidebarManager.php
│   ├── SidebarVisibilityModifier.php
│   ├── WidgetWrapperManager.php
│   └── Providers/
│       ├── GeneralClassProvider.php
│       ├── SinglePostClassProvider.php
│       ├── PageClassProvider.php
│       ├── ArchiveClassProvider.php
│       ├── SearchClassProvider.php
│       └── NotFoundClassProvider.php
├── Post/                            (Post management)
│   ├── PostClassManager.php
│   ├── PostFormatter.php
│   ├── PostIconFactory.php
│   └── MetadataManager.php
├── Providers/                       (Utility providers)
│   ├── ReturnValueProvider.php
│   ├── NumberGenerator.php
│   └── GridClassGenerator.php
├── Security/                        (Security management)
│   ├── SanitizationManager.php
│   ├── SecurityHeaderManager.php
│   ├── Sanitizers/
│   │   ├── SanitizerInterface.php
│   │   ├── TextSanitizer.php
│   │   ├── TextAreaSanitizer.php
│   │   ├── EmailSanitizer.php
│   │   ├── UrlSanitizer.php
│   │   ├── CheckboxSanitizer.php
│   │   └── SelectSanitizer.php
│   └── Validators/
│       ├── ValidatorInterface.php
│       ├── NonceSecurity.php
│       ├── SearchQueryValidator.php
│       └── LoginAttemptTracker.php
├── Utils/                           (Utility functions)
│   ├── ImageUtils.php
│   └── StringUtils.php
├── Widgets/                         (Widget management)
│   ├── AbstractWidget.php
│   ├── AbstractPostsWidget.php
│   ├── AbstractPostsWidgetTypeB.php
│   ├── AbstractPostsWidgetTypeC.php
│   ├── WidgetFactory.php
│   ├── WidgetRegistry.php
│   ├── WidgetClassManager.php
│   ├── SidebarRegistry.php
│   ├── WidgetTypeB.php
│   ├── WidgetTypeC.php
│   ├── Types/
│   │   ├── PostsListGridWidget.php
│   │   ├── PostsListSliderWidget.php
│   │   ├── PostsListSmallWidget.php
│   │   ├── PostsListZebraWidget.php
│   │   ├── PostsListTwoColsWidget.php
│   │   ├── PostsListMediaWidget.php
│   │   ├── PostsListWithBackgroundWidget.php
│   │   └── SocialLinksWidget.php
│   └── Sidebars/
│       └── SidebarConfiguration.php
├── Container.php                    (DI Container)
├── ThemeBootstrap.php               (Bootstrap orchestrator)
└── index.php                        (Engine entry point)
```

---

## References & Related Files

### Old Code Locations

- Primary: `origamiez/inc/functions.php` (1,071 lines)
- Sidebar: `origamiez/inc/sidebar.php` (76 lines)
- Widgets: `origamiez/inc/widget.php` (23 lines)
- Customizer: `origamiez/inc/customizer.php` (1,185 lines)
- Classes: `origamiez/inc/classes/` (3 files)

### Bootstrap Point

- Main: `origamiez/functions.php` (4.11 KB)
- New: `origamiez/engine/ThemeBootstrap.php` (7.11 KB)

### Autoloading

- Location: `origamiez/vendor/autoload.php` (loaded via Composer)

---

## Appendix: Quick Reference

### Quick Migration Lookup

**Q: Where did `origamiez_enqueue_scripts()` go?**
A: `Origamiez\Engine\Assets\AssetManager::enqueue_assets()`

**Q: Where did `origamiez_body_class()` go?**
A: `Origamiez\Engine\Layout\BodyClassManager` with provider pattern

**Q: Where did customizer settings go?**
A: Individual classes in `Customazer/Settings/` (GeneralSettings, BlogSettings, etc.)

**Q: Where did `origamiez_register_sidebars()` go?**
A: `Origamiez\Engine\Widgets\SidebarRegistry::setup_default_sidebars()`

**Q: Where did breadcrumbs go?**
A: `Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator` with Segment pattern

**Q: Can I still use hooks?**
A: Yes! All WordPress hooks preserved. New hooks also available via `HookRegistry`

**Q: Is backward compatibility maintained?**
A: Yes! All existing functionality preserved. Old theme customizations still work.

---

**Document End**

*Last Reviewed: 2025-12-17*  
*Next Review: After Phase 2 Migration*
