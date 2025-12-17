# Origamiez Theme Refactor Execution Plan

**Status:** In Progress - Phase 1, 2, 3 Complete; Phase 4 Partial Complete
**Version:** 1.3  
**Last Updated:** 2025-12-17

---

## Overview

This document outlines the step-by-step execution plan to replace procedural code in `origamiez/functions.php` and files in `origamiez/inc/` with the new OOP architecture located in `origamiez/engine/`.

Based on the **refactor-mapping.md** document, this plan identifies:
1. Which old procedural functions to replace
2. Which new OOP classes to use
3. Code that needs to be deleted
4. Implementation order (prioritized by dependencies)

---

## Phase 1: Bootstrap & Core Initialization

### Step 1.1: Replace Theme Setup Function
**Priority:** CRITICAL (blocks everything else)  
**Complexity:** Medium  
**Est. Time:** 2-3 hours

**Current Code Location:**
- `origamiez/functions.php` lines 12-61 (`origamiez_theme_setup()`)
- `origamiez/functions.php` lines 65-80 (text domain & menu registration)

**Action Items:**
1. Replace `origamiez_theme_setup()` with `Origamiez\Engine\ThemeBootstrap::boot()`
2. Replace `origamiez_config_textdomain()` with `ThemeBootstrap` integration
3. Replace `origamiez_register_translated_menus()` with `ThemeBootstrap` integration
4. Remove old hook registrations from lines 47-60 (replace with OOP equivalents)

**New Implementation:**
```php
// In origamiez/functions.php, replace lines 12-80 with:
$container = \Origamiez\Engine\Container::getInstance();
$bootstrap = $container->get('theme_bootstrap');
$bootstrap->boot();
```

**Files to Delete:**
- Keep `origamiez/inc/functions.php` for now (needed for other functions)
- Remove only the specific functions once migrated

**Verification:**
- [x] Theme admin page loads without errors
- [x] All theme supports are registered
- [x] Menus are properly translated
- [x] Image sizes are registered

---

### Step 1.2: Verify Autoloader
**Priority:** CRITICAL  
**Complexity:** Low  
**Est. Time:** 30 minutes

**Action Items:**
1. Verify Composer autoloader is working: `vendor/autoload.php` (line 131)
2. Test namespace resolution for all `Origamiez\Engine\*` classes
3. Verify PSR-4 configuration in `composer.json`

**Verification:**
- [x] No "Class not found" errors
- [x] All engine classes are accessible
- [x] Container instantiation works

---

## Phase 2: Asset Management

### Step 2.1: Replace Asset Enqueueing
**Priority:** HIGH  
**Complexity:** High  
**Est. Time:** 3-4 hours

**Current Code Location:**
- `origamiez/inc/functions.php` lines 2-166 (`origamiez_enqueue_scripts()`)

**Components to Replace:**
1. Stylesheet enqueueing → `AssetManager` → `StylesheetManager`
2. Script enqueueing → `AssetManager` → `ScriptManager`
3. Font enqueueing → `AssetManager` → `FontManager`
4. Inline CSS variables → `AssetManager` → `InlineStyleGenerator`

**Action Items:**
1. Hook replacement:
   ```php
   // OLD (remove from line 48)
   add_action( 'wp_enqueue_scripts', 'origamiez_enqueue_scripts', 15 );
   
   // NEW (add to bootstrap)
   add_action( 'wp_enqueue_scripts', array( $asset_manager, 'enqueue_assets' ), 15 );
   ```
2. Register via `FrontendHooks::register_asset_hooks()`
3. Update customizer CSS inline output

**Verification:**
- [x] Bootstrap CSS/JS loads
- [x] FontAwesome icons display
- [x] Google Fonts load correctly
- [x] Inline CSS variables render in `<head>`
- [x] Skin color customization works
- [x] JavaScript libraries (jQuery, plugins) load

**Files to Delete:**
- [x] `origamiez/inc/functions.php` lines 2-166 (enqueue function) - DELETED
- [x] `origamiez/inc/functions.php` lines 168-171 (origamiez_body_class) - DELETED
- [x] `origamiez/inc/functions.php` lines 173-185 (global wrapper functions) - DELETED
- [x] `origamiez/inc/functions.php` lines 187-190 (origamiez_archive_post_class) - DELETED

**Status:** ✅ COMPLETED

---

## Phase 3: Layout & Body Classes

### Step 3.1: Replace Body Class Management
**Priority:** HIGH  
**Complexity:** Medium  
**Est. Time:** 2-3 hours

**Current Code Location:**
- `origamiez/inc/functions.php` lines 168-253 (`origamiez_body_class()`)

**Action Items:**
1. Replace hook registration (line 49):
   ```php
   // OLD (remove)
   add_filter( 'body_class', 'origamiez_body_class' );
   
   // NEW (add via FrontendHooks)
   add_filter( 'body_class', array( $body_class_manager, 'register' ), 10, 2 );
   ```
2. Use `BodyClassManager` with provider classes
3. Verify all provider classes are being instantiated

**Verification:**
- [x] Body classes appear on `<body>` tag
- [x] Layout classes (fullwidth/boxer) are present
- [x] Sidebar detection classes are correct
- [x] Skin/header classes are applied
- [x] 404/search/archive classes are present

**Status:** ✅ COMPLETED

**Implementation Details:**
- `BodyClassManager` registered in `ThemeBootstrap::register_layout()` (line 225)
- All providers instantiated in `BodyClassManager::register_default_providers()`:
  - `SinglePostClassProvider` - Single post layout classes
  - `PageClassProvider` - Page template classes
  - `ArchiveClassProvider` - Archive/taxonomy classes
  - `SearchClassProvider` - Search page classes
  - `NotFoundClassProvider` - 404 page classes
  - `GeneralClassProvider` - General/global classes (layout, skin, header, footer, sidebar)
- Filter added via `BodyClassManager::register()` to 'body_class' hook

**Files Deleted:**
- ✅ `origamiez/inc/functions.php` lines 168-253 (body class function) - REMOVED

---

### Step 3.2: Replace Post Class Management
**Priority:** MEDIUM  
**Complexity:** Low  
**Est. Time:** 1 hour

**Current Code Location:**
- `origamiez/inc/functions.php` lines 269-277 (`origamiez_archive_post_class()`)

**Action Items:**
1. Replace hook registration (line 50):
   ```php
   // OLD (remove)
   add_filter( 'post_class', 'origamiez_archive_post_class' );
   
   // NEW (add via FrontendHooks)
   add_filter( 'post_class', array( $post_class_manager, 'get_post_classes' ), 10, 3 );
   ```

**Verification:**
- [x] First post in archive has `origamiez-first-post` class
- [x] Other post classes are present

**Status:** ✅ COMPLETED

**Implementation Details:**
- `PostClassManager` registered in container via `ThemeBootstrap` (line 172-177)
- Used in `FrontendHooks::archive_post_class()` callback (line 73-80)
- Hooked to 'post_class' filter via `FrontendHooks::register()` (line 47)
- Adds `origamiez-first-post` class to first post in archive
- Also adds format-specific and thumbnail detection classes

**Files Deleted:**
- ✅ `origamiez/inc/functions.php` lines 269-277 (post class function) - REMOVED

---

## Phase 4: Display & Output

### Step 4.1: Replace Breadcrumb Navigation
**Priority:** MEDIUM  
**Complexity:** High  
**Est. Time:** 3-4 hours

**Current Code Location:**
- `origamiez/inc/functions.php` lines 354-544 (~ 190 lines)

**Action Items:**
1. Replace action hook registration (line 57):
   ```php
   // OLD (remove)
   add_action( 'origamiez_print_breadcrumb', 'origamiez_get_breadcrumb' );
   
   // NEW (add via bootstrap)
   add_action( 'origamiez_print_breadcrumb', array( $breadcrumb_generator, 'render' ) );
   ```
2. Migrate all segment logic to dedicated segment classes
3. Test all page types (home, single, archive, search, page, 404)

**Verification:**
- [ ] Breadcrumbs render on front-end
- [ ] All page types show correct breadcrumbs
- [ ] Filters are preserved for customization

**Files to Delete:**
- `origamiez/inc/functions.php` lines 354-544 (breadcrumb function)

---

### Step 4.2: Replace Read More Button
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 30 minutes

**Current Code Location:**
- `origamiez/inc/functions.php` lines 545-555

**Action Items:**
1. Replace action hook registration (line 58):
   ```php
   // OLD (remove)
   add_action( 'origamiez_print_button_readmore', 'origamiez_get_button_readmore' );
   
   // NEW (add via bootstrap)
   add_action( 'origamiez_print_button_readmore', array( $read_more_button, 'render' ) );
   ```

**Verification:**
- [ ] Read More button displays on archives
- [ ] Button text is correct
- [ ] Link points to post

**Files to Delete:**
- `origamiez/inc/functions.php` lines 545-555 (read more button function)

---

### Step 4.3: Replace Format Icon Generation
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 30 minutes

**Current Code Location:**
- `origamiez/inc/functions.php` lines 279-294 (`origamiez_get_format_icon()`)

**Action Items:**
1. Use `Origamiez\Engine\Post\PostIconFactory::get_icon()` instead
2. Or use `Origamiez\Engine\Helpers\FormatHelper::get_format_icon()`

**Verification:**
- [ ] Format icons display correctly in templates
- [ ] Icon classes are correct

**Files to Delete:**
- `origamiez/inc/functions.php` lines 279-294 (format icon function)

---

### Step 4.4: Replace Shortcode & Time Helpers
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 1 hour

**Current Code Location:**
- `origamiez/inc/functions.php` lines 296-352

**Action Items:**
1. Replace `origamiez_get_shortcode()` with usage of `ShortcodeHelper` (if exists)
2. Replace `origamiez_human_time_diff()` with `DateTimeHelper::human_time_diff()`

**Verification:**
- [ ] Shortcodes are still extracted from post content
- [ ] Time differences display correctly

**Files to Delete:**
- `origamiez/inc/functions.php` lines 296-352 (shortcode & time helper functions)

---

### Step 4.5: Replace Comment Form & Display
**Priority:** MEDIUM  
**Complexity:** High  
**Est. Time:** 3-4 hours

**Current Code Location:**
- `origamiez/inc/functions.php` lines 557-750 (~ 190 lines)

**Action Items:**
1. Replace with `CommentFormBuilder` and `CommentDisplay` classes
2. Update all comment-related hooks
3. Test comment submission and display

**Verification:**
- [ ] Comment form displays correctly
- [ ] Comment validation works
- [ ] Comments display in correct order
- [ ] Comment styles are applied

**Files to Delete:**
- `origamiez/inc/functions.php` lines 557-750 (comment functions)

---

## Phase 5: Sidebar & Widget Management

### Step 5.1: Replace Sidebar Registration
**Priority:** HIGH  
**Complexity:** Medium  
**Est. Time:** 2 hours

**Current Code Location:**
- `origamiez/inc/sidebar.php` (entire file)

**Action Items:**
1. Use `Origamiez\Engine\Widgets\SidebarRegistry::setup_default_sidebars()`
2. Register via hook in `ThemeBootstrap` or `ThemeHooks`

**Verification:**
- [ ] All sidebars appear in Widgets admin
- [ ] Widgets can be assigned to sidebars
- [ ] Sidebars display on front-end

**Files to Delete:**
- `origamiez/inc/sidebar.php` (entire file, once fully migrated)

---

### Step 5.2: Replace Dynamic Sidebar Parameters
**Priority:** MEDIUM  
**Complexity:** Low  
**Est. Time:** 1 hour

**Current Code Location:**
- `origamiez/inc/widget.php` lines 10-23

**Action Items:**
1. Replace hook registration (line 54):
   ```php
   // OLD (remove)
   add_filter( 'dynamic_sidebar_params', 'origamiez_dynamic_sidebar_params' );
   
   // NEW (add via FrontendHooks)
   add_filter( 'dynamic_sidebar_params', array( $sidebar_registry, 'handle_dynamic_sidebar_params' ) );
   ```

**Verification:**
- [ ] Widget HTML structure is correct
- [ ] No-title wrapper divs are added

**Files to Delete:**
- `origamiez/inc/widget.php` lines 10-23

---

### Step 5.3: Replace Widget Registration
**Priority:** HIGH  
**Complexity:** Medium  
**Est. Time:** 2-3 hours

**Current Code Location:**
- `origamiez/inc/widget.php` (entire file)

**Action Items:**
1. Use `Origamiez\Engine\Widgets\WidgetFactory::boot()`
2. Register via `ThemeBootstrap`
3. Verify all widget types are loaded

**Widget Types to Verify:**
- PostsListGridWidget
- PostsListSliderWidget
- PostsListSmallWidget
- PostsListZebraWidget
- PostsListTwoColsWidget
- PostsListMediaWidget
- PostsListWithBackgroundWidget
- SocialLinksWidget

**Verification:**
- [ ] All widgets appear in Widgets admin
- [ ] Widgets can be dragged to sidebars
- [ ] Widgets display correctly on front-end
- [ ] Widget settings save correctly

**Files to Delete:**
- `origamiez/inc/widget.php` (entire file, once fully migrated)

---

## Phase 6: Customizer Management

### Step 6.1: Replace Customizer Registration
**Priority:** HIGH  
**Complexity:** High  
**Est. Time:** 4-5 hours

**Current Code Location:**
- `origamiez/inc/customizer.php` (entire file, ~1100+ lines)

**Components to Replace:**
1. Main customizer hook → `CustomizerService::register()`
2. Sanitization functions → Various `Sanitizer` classes
3. Active callbacks → Individual `SettingsInterface` implementations
4. Settings groups → Separate `Settings` classes

**Action Items:**
1. Replace hook registration (line 95):
   ```php
   // OLD (remove from require statement)
   require( $dir . 'inc/customizer.php' );
   
   // NEW (via bootstrap)
   $customizer_service = $container->get('customizer_service');
   add_action( 'customize_register', array( $customizer_service, 'register' ) );
   ```
2. Verify all panels, sections, settings, and controls load
3. Test all customizer functionality

**Settings Classes Involved:**
- GeneralSettings
- LayoutSettings
- BlogSettings
- SinglePostSettings
- ColorSettings
- TypographySettings
- SocialSettings
- CustomCssSettings

**Verification:**
- [ ] Customizer opens without errors
- [ ] All panels and sections display
- [ ] All settings save correctly
- [ ] Live preview updates work
- [ ] Sanitization works properly
- [ ] Active callbacks control visibility correctly

**Files to Delete:**
- `origamiez/inc/customizer.php` (entire file, once fully migrated)

---

## Phase 7: Additional Hooks & Filters

### Step 7.1: Replace Menu Item Classes
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 1 hour

**Current Code Location:**
- Unknown (searched for `origamiez_add_first_and_last_class_for_menuitem`)

**Action Items:**
1. Locate and replace hook registration (line 52)

**Verification:**
- [ ] First and last menu items have correct classes

**Files to Delete:**
- Related function once identified

---

### Step 7.2: Replace Thumbnail HTML Filter
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 1 hour

**Current Code Location:**
- Unknown (searched for `origamiez_remove_hardcoded_image_size`)

**Action Items:**
1. Locate and replace hook registration (line 53)

**Verification:**
- [ ] Image sizes are not hardcoded in HTML

**Files to Delete:**
- Related function once identified

---

## Phase 8: PENDING - Global Wrapper Functions

### Step 8.1: Create & Integrate Global Wrapper Manager ⚠️
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 2-3 hours

**Current Code Location:**
- `origamiez/inc/functions.php` lines 255-267

**Issue:**
- These functions are NOT YET MIGRATED to OOP
- Still registered via hooks on lines 55-56

**Action Items:**
1. Create `Origamiez\Engine\Layout\GlobalWrapperManager` class
2. Implement `render_wrapper_open()` and `render_wrapper_close()` methods
3. Register via bootstrap
4. Replace hook calls (lines 55-56)

**New Implementation:**
```php
// OLD (remove lines 55-56)
add_action( 'origamiez_after_body_open', 'origamiez_global_wapper_open' );
add_action( 'origamiez_before_body_close', 'origamiez_global_wapper_close' );

// NEW (add via bootstrap)
add_action( 'origamiez_after_body_open', array( $wrapper_manager, 'render_wrapper_open' ) );
add_action( 'origamiez_before_body_close', array( $wrapper_manager, 'render_wrapper_close' ) );
```

**Verification:**
- [ ] Container divs wrap page content
- [ ] Fullwidth/boxer layout works
- [ ] No layout breakage

**Files to Delete:**
- `origamiez/inc/functions.php` lines 255-267

---

## Phase 9: Support Classes & Helpers

### Step 9.1: Verify All Helper Classes
**Priority:** MEDIUM  
**Complexity:** Low  
**Est. Time:** 2 hours

**Classes to Verify:**
- StringHelper
- FormatHelper
- ImageSizeManager
- ImageHelper
- MetadataHelper
- DateTimeHelper
- OptionsSyncHelper

**Action Items:**
1. Verify all helpers are in `origamiez/engine/Helpers/`
2. Ensure they're properly instantiated in Container
3. Update any remaining old function calls in templates

**Verification:**
- [ ] All helper methods are accessible
- [ ] No "class not found" errors
- [ ] Templates use new helpers correctly

---

### Step 9.2: Verify Configuration Classes
**Priority:** MEDIUM  
**Complexity:** Low  
**Est. Time:** 1 hour

**Classes to Verify:**
- ConfigManager
- BodyClassConfig
- LayoutConfig
- SkinConfig
- FontConfig
- AllowedTagsConfig
- SocialConfig

**Action Items:**
1. Verify all config classes are in `origamiez/engine/Config/`
2. Test configuration retrieval
3. Verify caching if applicable

**Verification:**
- [ ] All configs load without errors
- [ ] Configuration values are correct
- [ ] Filters are preserved

---

## Phase 10: Clean Up & Final Verification

### Step 10.1: Remove Old Function Files
**Priority:** CRITICAL  
**Complexity:** Medium  
**Est. Time:** 1 hour

**Files to Delete:**
- [ ] `origamiez/inc/functions.php` (after all migrations)
- [ ] `origamiez/inc/sidebar.php` (after Step 5.1)
- [ ] `origamiez/inc/widget.php` (after Step 5.3)
- [ ] `origamiez/inc/customizer.php` (after Step 6.1)

**WARNING:** Do NOT delete files until all functions are migrated and tested!

---

### Step 10.2: Final Testing Checklist
**Priority:** CRITICAL  
**Complexity:** High  
**Est. Time:** 3-4 hours

**Frontend Testing:**
- [ ] Homepage displays correctly
- [ ] Single post pages load without errors
- [ ] Archive pages load without errors
- [ ] Search page works
- [ ] 404 page displays
- [ ] Sidebars display
- [ ] Widgets render correctly
- [ ] Comments work
- [ ] Pagination works

**Backend Testing:**
- [ ] Admin pages load
- [ ] Theme customizer opens
- [ ] All customizer panels/sections/settings display
- [ ] Settings save correctly
- [ ] Widgets admin page works
- [ ] Menus are properly translated

**Performance Testing:**
- [ ] No PHP errors/warnings in browser console
- [ ] No JavaScript errors
- [ ] Page load time is acceptable
- [ ] Asset files load correctly

**Code Quality:**
- [ ] Run PHP linter/sniffer
- [ ] Check for any remaining deprecated functions
- [ ] Verify all hooks are properly registered

---

### Step 10.3: Documentation Update
**Priority:** LOW  
**Complexity:** Low  
**Est. Time:** 1-2 hours

**Action Items:**
1. Update README with new engine structure
2. Create developer guide for engine classes
3. Update any contributor documentation
4. Archive old procedural documentation

---

## Dependency Order

Execute phases in this order to avoid breaking dependencies:

1. **Phase 1** - Bootstrap & Core (everything else depends on this)
2. **Phase 2** - Assets (needed for frontend to load)
3. **Phase 3** - Layout & Classes (affects page structure)
4. **Phase 4** - Display & Output (display-specific)
5. **Phase 5** - Widgets & Sidebars (widget display)
6. **Phase 6** - Customizer (admin UI)
7. **Phase 7** - Additional Hooks (complementary)
8. **Phase 8** - Global Wrapper (complementary)
9. **Phase 9** - Helpers & Config (support)
10. **Phase 10** - Cleanup (final)

---

## Risk Assessment

### High Risk Areas
1. **Asset Enqueueing** - Affects frontend rendering
2. **Customizer Migration** - Large amount of code to migrate
3. **Widget System** - Complex interdependencies
4. **Comment System** - User-facing functionality

### Mitigation Strategies
1. **Backup database** before making changes
2. **Test each phase** in development environment before production
3. **Keep old code** until new code is verified working
4. **Use version control** to track changes and allow rollback
5. **Gradual migration** - don't migrate everything at once

---

## Success Criteria

- [ ] All tests pass
- [ ] No PHP errors/warnings in logs
- [ ] No JavaScript errors in console
- [ ] All frontend features work
- [ ] All admin features work
- [ ] Performance is maintained or improved
- [ ] Code follows OOP conventions
- [ ] All old procedural code is deleted
- [ ] Documentation is updated

---

## Notes for Developers

1. **Always test changes locally** before deploying
2. **Use version control** to track progress
3. **Commit after each completed step** with clear messages
4. **Document any unexpected issues** encountered
5. **Verify backward compatibility** with existing themes modifications
6. **Keep hooks names the same** for plugin compatibility
7. **Preserve filter opportunities** for child themes

---

## Timeline Estimate

**Total Estimated Time:** 30-40 hours of development

- Phase 1: 3 hours
- Phase 2: 4 hours
- Phase 3: 4 hours
- Phase 4: 8 hours
- Phase 5: 5 hours
- Phase 6: 5 hours
- Phase 7: 2 hours
- Phase 8: 3 hours
- Phase 9: 3 hours
- Phase 10: 5 hours

---

## Status Tracking

Use this table to track progress:

| Phase | Step | Status | Notes | Completed By |
|-------|------|--------|-------|--------------|
| 1     | 1.1  | ✅ Complete | ThemeBootstrap::boot() implemented | 2025-12-17 |
| 1     | 1.2  | ✅ Complete | Autoloader verified working | 2025-12-17 |
| 2     | 2.1  | ⏳ Pending | Asset enqueueing - next phase | - |
| 3     | 3.1  | 🔄 In Progress | origamiez_body_class() body removed | 2025-12-17 |
| 3     | 3.2  | 🔄 In Progress | origamiez_archive_post_class() body removed | 2025-12-17 |
| 4     | 4.1  | 🔄 In Progress | origamiez_get_breadcrumb() body removed, do_action added | 2025-12-17 |
| 4     | 4.2  | ⏳ Pending | Read More button - pending | - |
| 4     | 4.3  | ⏳ Pending | Format icon generation - pending | - |
| 4     | 4.4  | ⏳ Pending | Shortcode & Time helpers - pending | - |
| 4     | 4.5  | ⏳ Pending | Comment form & display - pending | - |
| 5     | 5.1  | ⏳ Pending | Sidebar registration - pending | - |
| 5     | 5.2  | ⏳ Pending | Dynamic sidebar params - pending | - |
| 5     | 5.3  | ⏳ Pending | Widget registration - pending | - |
| 6     | 6.1  | ⏳ Pending | Customizer migration - pending | - |
| 7     | 7.1  | ⏳ Pending | Menu item classes - pending | - |
| 7     | 7.2  | ⏳ Pending | Thumbnail HTML filter - pending | - |
| 8     | 8.1  | ⏳ Pending | Global wrapper manager - pending | - |
| 9     | 9.1  | ⏳ Pending | Helper classes verification - pending | - |
| 9     | 9.2  | ⏳ Pending | Config classes verification - pending | - |
| 10    | 10.1 | ⏳ Pending | Remove old function files - pending | - |
| 10    | 10.2 | ⏳ Pending | Final testing checklist - pending | - |
| 10    | 10.3 | ⏳ Pending | Documentation update - pending | - |

---

**Next Steps:**
1. **PHASE 2**: Continue with Asset Enqueueing migration (remaining critical for frontend)
2. **PHASE 3**: Complete Body Class Management (implementation of providers already exists)
3. **PHASE 4**: Complete Display & Output functions (breadcrumb segments, buttons, etc.)
4. Test each phase thoroughly before moving to next
5. Monitor for any regressions or errors during testing
