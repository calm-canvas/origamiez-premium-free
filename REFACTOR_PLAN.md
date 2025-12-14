# Origamiez Theme Refactoring Plan

## Overview
Convert procedural WordPress theme code to Object-Oriented PHP following SOLID principles and DRY pattern.

**Target Directory**: `origamiez/engine/`

---

## 1. PHASE 1: Core Infrastructure & Dependency Injection

### 1.1 Service Container (Singleton)
**File**: `origamiez/engine/Container.php`
- Implement PSR-11 compatible service container
- Register all services and dependencies
- Replace global variables with container access
- Lazy-load services

**Current Issues**:
- Global `$dir` and `$is_IE` variables scattered throughout
- Hard to test due to tight coupling
- No clear dependency management

---

### 1.2 Configuration Manager
**File**: `origamiez/engine/Config/ConfigManager.php`
- Centralize all theme configuration
- Replace magic strings and hardcoded values
- Support for skin configurations, layout options
- Separate environment config from business logic

**Classes to Create**:
```
origamiez/engine/Config/
├── ConfigManager.php (handles all settings)
├── SkinConfig.php (manages theme skins)
├── LayoutConfig.php (layout configurations)
└── FontConfig.php (typography settings)
```

**Move to Config**:
- Hardcoded image sizes registration
- Theme support features
- Customizer panels/sections/settings definitions
- Menu locations
- Social media configurations

---

## 2. PHASE 2: Asset Management (CSS/JS Enqueue)

### 2.1 Asset Enqueue Manager
**File**: `origamiez/engine/Assets/AssetManager.php`
- Separate stylesheet and script registration
- Replace `origamiez_enqueue_scripts()` function

**Sub-classes**:
```
origamiez/engine/Assets/
├── AssetManager.php (main orchestrator)
├── StylesheetManager.php
├── ScriptManager.php
├── InlineStyleGenerator.php
└── FontManager.php
```

**Benefits**:
- Single Responsibility: Each class handles one asset type
- Easier to add/remove assets
- Testable asset dependencies
- Modular inline style generation

---

## 3. PHASE 3: Hook & Filter Management

### 3.1 Hook Registry
**File**: `origamiez/engine/Hooks/HookRegistry.php`
- Centralize all action and filter registrations
- Replace scattered `add_action()` calls
- Better visibility of what hooks are registered

**Structure**:
```
origamiez/engine/Hooks/
├── HookRegistry.php
├── Hooks/
│   ├── FrontendHooks.php
│   ├── AdminHooks.php
│   ├── CustomizerHooks.php
│   └── SecurityHooks.php
```

---

## 4. PHASE 4: Body & Layout Classes

### 4.1 Body Class Manager
**File**: `origamiez/engine/Layout/BodyClassManager.php`
- Replace `origamiez_body_class()` function
- Separate logic for different page types (single, page, archive, etc.)

**Sub-classes**:
```
origamiez/engine/Layout/
├── BodyClassManager.php
├── Providers/
│   ├── SinglePostClassProvider.php
│   ├── PageClassProvider.php
│   ├── ArchiveClassProvider.php
│   ├── SearchClassProvider.php
│   └── NotFoundClassProvider.php
├── Modifiers/
│   └── LayoutModifier.php (handles layout classes)
```

**SOLID Principles Applied**:
- Open/Closed: Easy to add new page type providers
- Single Responsibility: Each provider handles specific page type
- Dependency Injection: No static dependencies

---

## 5. PHASE 5: Template & Display Management

### 5.1 Breadcrumb Generator
**File**: `origamiez/engine/Display/Breadcrumb/BreadcrumbGenerator.php`

**Classes**:
```
origamiez/engine/Display/Breadcrumb/
├── BreadcrumbGenerator.php
├── BreadcrumbBuilder.php
├── Segments/
│   ├── HomeSegment.php
│   ├── SingleSegment.php
│   ├── PageSegment.php
│   ├── ArchiveSegment.php
│   ├── SearchSegment.php
│   ├── NotFoundSegment.php
│   └── SegmentInterface.php
└── Formatters/
    ├── SegmentFormatter.php
    └── HtmlFormatter.php
```

**Benefits**:
- Replace 90+ line `origamiez_get_breadcrumb()` function
- Strategy pattern for different breadcrumb segments
- Easier to customize/extend

### 5.2 Comment & Author Display
**File**: `origamiez/engine/Display/`

**Classes**:
```
origamiez/engine/Display/
├── AuthorDisplay.php (replace origamiez_get_author_infor)
├── CommentDisplay.php (replace origamiez_list_comments)
├── CommentFormBuilder.php (replace origamiez_comment_form)
└── ReadMoreButton.php
```

---

## 6. PHASE 6: Utility & Helper Functions

### 6.1 String & Image Utilities
**Files**:
```
origamiez/engine/Utils/
├── StringUtils.php (origamiez_get_format_icon, origamiez_human_time_diff, etc.)
├── ImageUtils.php (origamiez_get_image_src, origamiez_remove_hardcoded_image_size)
├── TimeUtils.php (origamiez_human_time_diff)
├── HtmlSanitizer.php (origamiez_get_allowed_tags)
└── ShortcodeParser.php (origamiez_get_shortcode)
```

### 6.2 Sanitization & Validation
**Files**:
```
origamiez/engine/Security/
├── SanitizationManager.php
├── Sanitizers/
│   ├── CheckboxSanitizer.php
│   ├── SelectSanitizer.php
│   ├── TextAreaSanitizer.php
│   ├── UrlSanitizer.php
│   ├── EmailSanitizer.php
│   └── TextSanitizer.php
├── Validators/
│   ├── NonceSecurity.php
│   ├── SearchQueryValidator.php
│   └── LoginAttemptTracker.php
└── SecurityHeaderManager.php (CSP, X-Frame-Options, etc.)
```

---

## 7. PHASE 7: Customizer Management

### 7.1 Customizer Service
**Files**:
```
origamiez/engine/Customizer/
├── CustomizerService.php
├── ControlFactory.php
├── Builders/
│   ├── PanelBuilder.php
│   ├── SectionBuilder.php
│   └── SettingBuilder.php
├── Settings/
│   ├── GeneralSettings.php
│   ├── ColorSettings.php
│   ├── TypographySettings.php
│   ├── LayoutSettings.php
│   └── SocialSettings.php
└── Listeners/
    └── CustomizerListener.php (handles unyson updates)
```

---

## 8. PHASE 8: Post Processing & Formatting

### 8.1 Post Class Manager
**File**: `origamiez/engine/Post/PostClassManager.php`
- Replace `origamiez_archive_post_class()`

### 8.2 Metadata Manager
**Files**:
```
origamiez/engine/Post/
├── MetadataManager.php (origamiez_get_metadata_prefix)
├── PostFormatter.php
└── PostIconFactory.php (origamiez_get_format_icon)
```

---

## 9. PHASE 9: Theme Initialization & Setup

### 9.1 Theme Bootstrap
**File**: `origamiez/engine/ThemeBootstrap.php`
- Centralize `origamiez_theme_setup()` logic
- Initialize all services in proper order
- Handle text domain loading

**Classes**:
```
origamiez/engine/
├── ThemeBootstrap.php
├── Initializers/
│   ├── ThemeFeaturesInitializer.php
│   ├── MenusInitializer.php
│   ├── ImageSizesInitializer.php
│   ├── TextDomainInitializer.php
│   └── ContentWidthInitializer.php
```

---

## 10. PHASE 10: Wrapper & Layout Structure

### 10.1 Layout Container
**File**: `origamiez/engine/Layout/LayoutContainer.php`
- Replace `origamiez_global_wapper_open()` and `origamiez_global_wapper_close()`

**Classes**:
```
origamiez/engine/Layout/
├── LayoutContainer.php
├── WidgetWrapperManager.php
├── SidebarManager.php
└── Modifiers/
    └── SidebarVisibilityModifier.php
```

---

## 11. PHASE 11: Filter & Return Value Functions

### 11.1 Return Value Providers
**File**: `origamiez/engine/Providers/ReturnValueProvider.php`

**Classes**:
```
origamiez/engine/Providers/
├── ReturnValueProvider.php
├── Generators/
│   ├── NumberGenerator.php (origamiez_return_10, etc.)
│   └── GridClassGenerator.php (footer column classes)
```

---

## 12. PHASE 12: Widget Factory

### 12.1 Widget Registration Service
**File**: `origamiez/engine/Widgets/WidgetRegistry.php`
- Consolidate widget and sidebar registration
- Replace `inc/widget.php` and `inc/sidebar.php`

**Classes**:
```
origamiez/engine/Widgets/
├── WidgetRegistry.php
├── SidebarRegistry.php
├── AbstractWidget.php (improved from inc/classes)
├── WidgetFactory.php
└── Sidebars/
    └── SidebarConfiguration.php
```

---

## SOLID Principles Applied

### ✅ Single Responsibility Principle (SRP)
- Each class handles **one responsibility**
- `StylesheetManager` handles only stylesheets
- `ScriptManager` handles only scripts
- `BreadcrumbGenerator` handles only breadcrumbs

### ✅ Open/Closed Principle (OCP)
- Open for extension, closed for modification
- Use **Strategy pattern** for breadcrumb segments
- Use **Provider pattern** for body classes
- Easy to add new providers without modifying core

### ✅ Liskov Substitution Principle (LSP)
- All segment providers implement `SegmentInterface`
- All sanitizers implement `SanitizerInterface`
- Interchangeable implementations

### ✅ Interface Segregation Principle (ISP)
- Small, focused interfaces
- `SegmentInterface` for breadcrumb segments only
- `AssetInterface` for asset types
- Clients depend on specific interfaces

### ✅ Dependency Inversion Principle (DIP)
- Depend on abstractions, not concrete classes
- Inject `ConfigManager` instead of using `get_theme_mod()`
- Inject `HookRegistry` instead of direct `add_action()`
- Use constructor injection

### ✅ DRY (Don't Repeat Yourself)
- Extract common patterns into base classes
- Create reusable utility classes
- Consolidate duplicate code (security functions)

---

## Implementation Order

1. **First**: Container & Config (dependency foundation)
2. **Second**: Asset Manager (commonly used)
3. **Third**: Hook Registry (organize all hooks)
4. **Fourth**: Layout & Body Classes (core display logic)
5. **Fifth**: Utilities & Sanitization (support functions)
6. **Sixth**: Customizer (UI management)
7. **Seventh**: Theme Initialization (bring it all together)

---

## Migration Steps

### Step 1: Create Engine Directory
```bash
mkdir -p origamiez/engine/{Assets,Config,Display,Hooks,Layout,Post,Security,Utils,Widgets,Customizer,Providers,Initializers}
```

### Step 2: Build Core Services
- Container
- ConfigManager
- HookRegistry

### Step 3: Refactor Assets
- Extract asset enqueue logic into `AssetManager`
- Remove from `origamiez_enqueue_scripts()`

### Step 4: Refactor Hooks
- Move all `add_action()` to `HookRegistry`
- Replace functions.php hook registrations

### Step 5: Refactor Layout Logic
- `BodyClassManager` with providers
- `BreadcrumbGenerator`
- `PostClassManager`

### Step 6: Refactor Utilities
- Extract functions to Utils classes
- Create Sanitization classes

### Step 7: Update Bootstrap
- `functions.php` becomes minimal bootstrap
- `inc/functions.php` uses engine classes

### Step 8: Testing
- Add unit tests for core classes
- Verify functionality preserved
- Performance testing

---

## File Structure After Refactoring

```
origamiez/
├── functions.php (minimal, delegates to engine)
├── inc/
│   ├── functions.php (legacy, can be deprecated)
│   ├── customizer.php (can be deprecated)
│   ├── classes/ (can be deprecated)
│   ├── widget.php (can be deprecated)
│   └── sidebar.php (can be deprecated)
├── engine/
│   ├── Container.php
│   ├── ThemeBootstrap.php
│   ├── Assets/
│   ├── Config/
│   ├── Customizer/
│   ├── Display/
│   ├── Hooks/
│   ├── Initializers/
│   ├── Layout/
│   ├── Post/
│   ├── Providers/
│   ├── Security/
│   ├── Utils/
│   └── Widgets/
├── app/
│   └── ... (existing PSR-4 autoloading)
└── ... (other theme files)
```

---

## Benefits of This Refactoring

| Aspect | Current | After Refactoring |
|--------|---------|-------------------|
| **Testability** | Difficult - tight coupling | Easy - dependency injection |
| **Maintainability** | Hard - scattered functions | Easy - organized classes |
| **Extensibility** | Requires modifying core | Simple - provider pattern |
| **Code Reuse** | Limited - copy-paste | High - shared utilities |
| **Debugging** | Complex flow | Clear class dependencies |
| **Performance** | Same or better | Same or better - lazy loading |
| **Team Collaboration** | Scattered responsibilities | Clear ownership per class |
| **Security** | Manual auditing required | Centralized security classes |

---

## Notes

- **Backwards Compatibility**: Keep functions.php calling new engine classes
- **Gradual Migration**: Don't convert everything at once
- **Composer Autoloading**: Use existing `vendor/autoload.php`
- **WordPress Hooks**: Don't fight WP, wrap it in classes
- **Testing**: Add unit tests alongside refactoring
