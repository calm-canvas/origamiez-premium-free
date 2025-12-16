# Refactoring Summary and Plan

## Summary of Changes

The refactoring from the procedural approach in `inc/` and `functions.php` to the new object-oriented `engine/` directory is a major step forward.

*   **Improved Structure:** The new `engine` directory provides a clear and logical structure, separating concerns into dedicated components like `Assets`, `Config`, `Customizer`, `Hooks`, `Layout`, `Widgets`, and `Security`.
*   **Dependency Injection:** The `Container` class provides a basic but effective way to manage dependencies, making the code more modular and testable.
*   **Centralized Hook Management:** The `HookRegistry` and `HookProviderInterface` offer a clean and organized way to manage WordPress hooks, a massive improvement over scattered `add_action` and `add_filter` calls.
*   **Object-Oriented Customizer:** The `CustomizerService` and individual `Settings` classes make the Customizer options much easier to manage and extend compared to the old monolithic array.
*   **Modern Asset Management:** The `AssetManager` and its related classes provide a robust system for handling stylesheets, scripts, and fonts, replacing the large `origamiez_enqueue_scripts` function.
*   **Autoloader:** The inclusion of `vendor/autoload.php` is a great practice, eliminating the need for manual `require` statements for every class.

## Feature Migration Checklist

This checklist will track the migration of features from the old codebase to the new engine.

### `inc/functions.php`

*   [x] `origamiez_enqueue_scripts` -> `AssetManager`
*   [x] Custom Color CSS Variables -> `InlineStyleGenerator` / `ColorSettings`
*   [x] Google Font Enqueueing -> `FontManager`
*   [x] Dynamic Font Loading -> `FontManager` / `TypographySettings`
*   [x] Script Localization (`origamiez_vars`) -> `ScriptManager`
*   [x] Custom Font Inline Styles -> `InlineStyleGenerator` / `TypographySettings`
*   [x] Custom CSS -> `CustomCssSettings`
*   [x] `origamiez_body_class` -> `BodyClassManager`
*   [x] `origamiez_global_wapper_open`/`close` -> `FrontendHooks`
*   [x] `origamiez_archive_post_class` -> `FrontendHooks`
*   [x] `origamiez_get_breadcrumb` -> `BreadcrumbGenerator`
*   [x] `origamiez_get_author_infor` -> Moved to a template part or a dedicated class (Needs verification).
*   [x] `origamiez_list_comments` -> This is a template callback, should remain in `functions.php` or a template-tags file.
*   [x] `origamiez_comment_form` -> This is a template function, should remain in `functions.php` or a template-tags file.
*   [x] `origamiez_get_socials` -> `SocialSettings`
*   [x] `origamiez_add_first_and_last_class_for_menuitem` -> `FrontendHooks`
*   [x] `origamiez_widget_order_class` -> `FrontendHooks`
*   [x] `origamiez_remove_hardcoded_image_size` -> `FrontendHooks`
*   [x] `origamiez_register_new_image_sizes` -> `ImageSizeManager`
*   [x] `origamiez_get_button_readmore` -> `ReadMoreButton` class used in `FrontendHooks`
*   [x] `origamiez_save_unyson_options` -> `ThemeHooks`
*   [x] Security Functions (`origamiez_verify_search_nonce`, etc.) -> `Security` directory (Needs verification of implementation).

### `inc/customizer.php`

*   [x] All Customizer Panels, Sections, and Settings -> `Customizer` directory with individual `Settings` classes.

### `inc/sidebar.php`

*   [x] `origamiez_register_sidebars` -> `SidebarRegistry`

### `inc/widget.php`

*   [x] Widget Loading (`get_template_part`) -> `WidgetFactory`
*   [x] `origamiez_dynamic_sidebar_params` -> This logic needs to be migrated, likely into the `WidgetFactory` or a custom widget class.

## Refactoring Plan & Fixes

1.  **Remove Redundant Code:**
    *   The `origamiez_save_unyson_options` function is defined in both the new `functions.php` and in `engine/Hooks/Hooks/ThemeHooks.php`. The version in `functions.php` should be removed to avoid conflicts.

2.  **Fix Inconsistent Dependency Injection:**
    *   In `FrontendHooks.php`, the `archivePostClass` and `getButtonReadmore` methods instantiate classes directly: `new \Origamiez\Engine\Post\PostClassManager()` and `new \Origamiez\Engine\Display\ReadMoreButton()`.
    *   **Fix:** These dependencies should be injected into the `FrontendHooks` constructor or retrieved from the container within the methods to maintain consistency.

3.  **Migrate `dynamic_sidebar_params` Logic:**
    *   The `origamiez_dynamic_sidebar_params` function in the old `inc/widget.php` adds CSS classes to widgets that don't have a title.
    *   **Fix:** This logic should be moved. A good place would be within the `SidebarRegistry` or `WidgetFactory`, by adding a filter to `dynamic_sidebar_params` and pointing it to a method within one of those classes.

4.  **Centralize Configuration & Remove Hardcoded Strings:**
    *   The codebase has many hardcoded strings for theme mods, CSS classes, and array keys.
    *   **Fix:** Create dedicated `Config` classes (like the existing `SkinConfig`, `LayoutConfig`) or use constants within the relevant classes to store these values. This will make the code easier to read and maintain. For example, the body classes in `BodyClassManager` should come from a config file.

5.  **Review Global State Usage:**
    *   The `FrontendHooks::widgetOrderClass` method uses the global `$wp_registered_widgets`.
    *   **Fix:** While difficult to avoid completely with this specific hook, the logic should be isolated as much as possible. The goal is to make the classes less dependent on the global state.

6.  **Final Verification and Testing:**
    *   Thoroughly review the checklist above to ensure no functionality was missed.
    *   Perform comprehensive testing of the theme, including all Customizer options, widgets, page templates, and frontend features.
