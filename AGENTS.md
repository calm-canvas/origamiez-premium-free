# AGENTS.md - Project Instructions for AI Agents

## Project Identity

- **Name**: Origamiez
- **Purpose**: A flexible, high-performance WordPress theme for magazines, newspapers, and e-commerce.
- **Vibe**: Professional, modular, and extensible. It bridges traditional WordPress development with modern engineering practices (Vite, Dependency Injection, PSR-4).
- **Hybrid theme**: The shipped theme combines **classic PHP templates**, **`theme.json` (Block Editor design tokens / settings)**, **`block-templates` support**, **block patterns** (planned via custom blocks; `origamiez/patterns/` is reserved), and **classic + block widgets** (`widgets-block-editor`). Agents should assume features may surface in the Site Editor, Customizer, widget areas, or PHP templates—keep behavior and styling coherent across all paths.

## Tech Stack & Environment

- **PHP**: 7.4+ (fully optimized for PHP 8.3+).
- **WordPress**: 5.5+ (tested up to 6.9.0).
- **Frontend**: Vite-based build system, SASS (modular entry under repo `assets/`), Bootstrap 5.3.
- **Dependencies**: PHP-DI (`php-di/php-di`), Font Awesome 6.4.0, Owl Carousel.
- **Environment**: Docker (Apache / PHP 8.3); orchestration via `Makefile` and `docker/`.
- **Package manager (JS)**: Prefer **`pnpm`** for scripts referenced in this doc (`pnpm format`, `pnpm lint:fix`).

## Repository vs Shipped Theme

| Area                           | Role                                                                                                                                                                       |
| ------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **`origamiez/`**               | **Deliverable theme** loaded by WordPress: `functions.php`, `theme.json`, `app/` (PSR-4), `parts/`, `inc/`, `patterns/`, `templates/`, built CSS/JS consumed by the theme. |
| **`assets/`**                  | **Authoring** SASS/JS for Vite; output is typically synchronized into the theme’s enqueue paths (see `docs/specs/03-asset-management.md`).                                 |
| **`docs/specs/`**              | Architecture specs; treat as source of truth alongside this file.                                                                                                          |
| **`plugins/craftsman-suite/`** | Separate plugin with its own `app/` tree—do not confuse with the theme’s `origamiez/app/`.                                                                                 |

## Architecture & Coding Standards

### Entry and bootstrap

1. **`origamiez/functions.php`** loads Composer autoload, hooks **`after_setup_theme`**, instantiates **`Origamiez\ThemeBootstrap`**, and calls **`boot()`**.
2. Legacy/global callback glue lives under **`origamiez/inc/`** (`config.php`, `functions.php`) and runs after the bootstrap hook is set up; new logic should prefer `origamiez/app/`.

### Theme engine (`origamiez/app/`)

- **PSR-4 namespace**: `Origamiez\...` mapped from `origamiez/app/`.
- **Dependency injection**: `DI\ContainerBuilder` + **`origamiez/app/Core/di-definitions.php`** (singleton-style services use `factory( [ Class::class, 'get_instance' ] )`).
- **Bootstrap orchestration**: `ThemeBootstrap::boot()` order—`ThemeSupportManager::register()` → hooks → assets → layout (`BodyClassManager`) → display (`BreadcrumbGenerator`) → Customizer (`CustomizerService` + settings classes) → **`WidgetFactory`** → **`SidebarRegistry`** → action **`origamiez_engine_booted`**.
- **Hook system**: Central registration via **`HookRegistry`** and classes implementing **`HookProviderInterface`** under `origamiez/app/Hooks/` (e.g. `ThemeHooks`, `FrontendHooks`, `SecurityHooks`, plugin-specific providers). Prefer **not** adding loose `add_action` / `add_filter` in random files; extend an existing provider or add a new provider and register it from `ThemeBootstrap::register_hooks()`.
- **Theme supports (hybrid)**: Declared in **`ThemeSupportManager`**—includes **`editor-styles`**, **`align-wide`**, **`wp-block-styles`**, **`responsive-embeds`**, **`appearance-tools`**, **`block-templates`**, **`widgets-block-editor`**, plus classic features (menus, post formats, custom header/background, etc.). Theme-owned block patterns are not auto-loaded from PHP; add `register_block_pattern` (or Block Editor registration) when custom blocks ship, with optional `wp_enqueue_block_style` for scoped CSS.
- **Global design tokens**: **`origamiez/theme.json`** defines palette and settings consumed by the block editor; keep SASS/CSS custom properties (`assets/sass/_tokens.scss`, `_variables.scss`) and Customizer output aligned where colors overlap.
- **Widgets**: **`AbstractWidget`** extends **`WP_Widget`**; registration flows through **`WidgetRegistry`** / **`WidgetFactory`** (see `WidgetRegistry::register()` on `widgets_init`). Sidebars use **`SidebarRegistry`** and configuration under `origamiez/app/Widgets/Sidebars/`.
- **Customizer**: Modular **settings classes** (e.g. `GeneralSettings`, `LayoutSettings`) registered on **`CustomizerService`** in `ThemeBootstrap::register_customizer()`—avoid monolithic `functions.php` option definitions.
- **Security / sanitization**: **`SanitizationManager`** and validators under `origamiez/app/Security/`; reuse when handling settings, widgets, or admin input.
- **UI composition**: Reusable PHP fragments in **`origamiez/parts/`** via **`get_template_part()`**; use the **`origamiez-`** CSS class prefix for theme-owned components.

### AI / “Vibe Coding” workflow

This repo is optimized for **agent-assisted development**: small, reviewable diffs, respect for existing registries, and specs in `docs/specs/`. When generating code:

- **Trace the real boot path** (`functions.php` → `ThemeBootstrap` → services) before adding features.
- **Register, don’t scatter**: hooks → `HookRegistry` providers; widgets → factory/registry; sidebars → `SidebarRegistry`; services → `di-definitions.php`.
- **Hybrid awareness**: if a feature touches the editor, widgets, and front-end templates, confirm **`theme.json`**, **enqueue conditions**, and **template parts** stay consistent.
- **Verify paths**: theme code lives under **`origamiez/`**; frontend sources often under **`assets/`**.

## Directory Structure (concise)

- **`origamiez/app/`**: Core PHP (bootstrap, hooks, assets, customizer, widgets, layout, display, security, config).
- **`origamiez/inc/`**: Theme includes and legacy/global helpers wired from `functions.php`.
- **`origamiez/parts/`**: Template parts; **`origamiez/patterns/`**: Reserved for future block patterns; **`origamiez/templates/`**: Block templates (e.g. `index.html`).
- **`assets/`**: Vite/SASS/JS sources at repo root.
- **`docs/`**: Specs and guides (`docs/specs/`).
- **`docker/`**: Container configuration.

## Development Workflow

1. **Environment**: `docker compose up -d` or `make up`.
2. **Initialize**: `./bin/init.sh` (when setting up the project).
3. **Frontend dev**: `npm run dev` (Vite HMR) or `npm run watch`.
4. **Production build**: `npm run build`.

## Coding & Naming Conventions

### PHP (WordPress & PSR-4)

- **Standard**: [WordPress Coding Standards (WPCS)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- **Naming**:
    - **Classes**: `PascalCase`.
    - **Methods/Functions**: `snake_case`.
    - **Variables**: `snake_case`.
    - **Class files**: PSR-4 under `origamiez/app/` (e.g. `origamiez/app/Hooks/HookRegistry.php` → `Origamiez\Hooks\HookRegistry`).
    - **Template files**: `kebab-case.php`.
- **Prefixing**: Global functions and constants **`origamiez_`** (and constant `ORIGAMIEZ_*` where used); text domain **`origamiez`**.

### CSS / SASS

- **Selectors**: `kebab-case`, **`origamiez-`** prefix for theme components.
- **Variables**: CSS custom properties with `--` (aligned with `_tokens.scss` / `_variables.scss`).
- **Structure**: Modular partials (variables, mixins, components, overrides).

### JavaScript / TypeScript

- **Naming**: `camelCase` for functions/variables, `PascalCase` for classes, `UPPER_SNAKE_CASE` for constants.
- **Global namespace**: Theme-specific object (e.g. `Origamier`) to avoid polluting `window`.
- **WordPress**: jQuery is common; ES6+ allowed where the build supports it.

## Infrastructure & Commands

- `make setup`: `.env`, `override.ini`, Docker network checks.
- `make up`: setup + `docker compose up -d`.
- `make down` / `make restart` / `make remove`: lifecycle.

## Code Quality & Formatting

- **PHP**: `composer format` (check), `composer fix` (PHPCBF).
- **JS/CSS**: `pnpm format`, `pnpm lint:fix`.

## AI Guidelines

- **Be minimalist**: Touch only files required for the task; no unsolicited READMEs.
- **Respect patterns**: Mirror existing services, providers, and registries in `origamiez/app/`.
- **Use hooks**: Extend `HookProviderInterface` implementations and register from `ThemeBootstrap`.
- **Read specs**: `docs/specs/` for asset pipeline, hooks, customizer, etc.
- **Free vs premium**: Keep a single core structure; gate features via config/filters as the project already does, rather than forking unrelated copies of logic.

---

## Case Studies: Good vs Bad (Hybrid Block + Widget Theme)

Twenty high-signal patterns for themes that must coexist with **blocks**, **block widgets**, **classic widgets**, and **PHP templates**.

### 1. Hook registration

| Good                                                                                                             | Bad                                                                                         |
| ---------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| Add actions/filters inside a `HookProviderInterface` class; register it from `ThemeBootstrap::register_hooks()`. | Sprinkle `add_action` across `inc/functions.php` and random templates with no central list. |

### 2. Service location

| Good                                                                         | Bad                                                                       |
| ---------------------------------------------------------------------------- | ------------------------------------------------------------------------- |
| Resolve dependencies via **`di-definitions.php`** and constructor injection. | `new` heavy objects in templates or global functions; untestable globals. |

### 3. Widget lifecycle

| Good                                                                                                                                             | Bad                                                                                                 |
| ------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------- |
| Register widget classes through **`WidgetRegistry`** / **`WidgetFactory`** so every widget is tracked and hooked on `widgets_init` consistently. | Call `register_widget()` directly in `functions.php` for each class, bypassing project conventions. |

### 4. Sidebar definitions

| Good                                                                                                                    | Bad                                                                            |
| ----------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------ |
| Use **`SidebarRegistry`** + **`SidebarConfiguration`** so IDs, descriptions, and counts stay documented and filterable. | Duplicate `register_sidebar()` blocks with magic string IDs in multiple files. |

### 5. Hybrid: `theme.json` vs PHP

| Good                                                                                                                             | Bad                                                                                                    |
| -------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------ |
| Define editor palette and typography in **`theme.json`**; mirror critical colors in SASS tokens/Customizer for front-end parity. | Hard-code hex colors only in widgets while `theme.json` says something else—editor and front mismatch. |

### 6. Block patterns

| Good                                                                                                                                                 | Bad                                                                                 |
| ---------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| Register patterns (e.g. from custom blocks) with a dedicated category such as **`origamiez`**; optional scoped CSS via **`wp_enqueue_block_style`**. | Paste huge HTML blobs into a page once and never ship reusable, versioned patterns. |

### 7. Block-only styles

| Good                                                                                                  | Bad                                                               |
| ----------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Use **`wp_enqueue_block_style`** (when available) for pattern/block-specific CSS with unique handles. | Load a global `patterns.css` on every page regardless of content. |

### 8. Editor vs front styles

| Good                                                                          | Bad                                                                     |
| ----------------------------------------------------------------------------- | ----------------------------------------------------------------------- |
| **`add_editor_style`** + shared token file so the editor resembles the front. | Editor uses default styles; users see a different layout after publish. |

### 9. Widget form security

| Good                                                                                          | Bad                                                          |
| --------------------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| Sanitize/validate widget options with theme **`SanitizationManager`** / dedicated sanitizers. | `$_POST` → `update()` with `stripslashes` only or raw saves. |

### 10. Customizer settings

| Good                                                                                                         | Bad                                                         |
| ------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------- |
| One settings class per concern (`LayoutSettings`, `ColorSettings`, …) registered on **`CustomizerService`**. | Hundreds of `$wp_customize->add_setting` calls in one file. |

### 11. Template reuse

| Good                                                                                       | Bad                                                          |
| ------------------------------------------------------------------------------------------ | ------------------------------------------------------------ |
| **`get_template_part( 'parts/...' )`** for markup shared by blocks, widgets, and archives. | Copy-paste the same HTML into a widget class and a template. |

### 12. Asset loading

| Good                                                                                                                       | Bad                                                                 |
| -------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- |
| Register handles/dependencies in **`AssetManager`** / script & stylesheet managers; conditional enqueue for special views. | `wp_enqueue_script` with inline paths in header.php for every page. |

### 13. Body / layout classes

| Good                                                                              | Bad                                                                              |
| --------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| Extend **`BodyClassManager`** providers when context-specific classes are needed. | Ad-hoc `body_class` filters in five unrelated files with overlapping priorities. |

### 14. Text domain & strings

| Good                                                                                           | Bad                                                               |
| ---------------------------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| All user-facing strings use **`'origamiez'`** and consistent translator comments where needed. | Mixed text domains or missing i18n in new widgets/block patterns. |

### 15. Block widgets vs classic widget markup

| Good                                                                                                                     | Bad                                                                      |
| ------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------ |
| Support **`widgets-block-editor`**; output stable, accessible HTML from `widget()` whether the form is block or classic. | Rely on jQuery-only admin scripts that break in the block widget screen. |

### 16. FSE / block templates compatibility

| Good                                                                                                                                       | Bad                                                                                     |
| ------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------- |
| Keep **`block-templates`** support and templates under **`origamiez/templates/`** coherent with header/footer in PHP when users mix modes. | Assume `header.php` always runs while an `index.html` template omits critical wrappers. |

### 17. Feature flags (free / premium)

| Good                                                                                                                      | Bad                                                                  |
| ------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| Gate capabilities with configuration + **`apply_filters( 'origamiez_*' )`** so one codebase can ship free/premium builds. | Maintain two almost-identical widget classes that diverge over time. |

### 18. Performance on query-heavy widgets

| Good                                                                                                     | Bad                                                                      |
| -------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Use `WP_Query` with sensible limits, `no_found_rows`, transient/cache where appropriate, shared helpers. | Uncached full-category queries on every `widget()` render on every page. |

### 19. Plugin integration hooks

| Good                                                                              | Bad                                                                                          |
| --------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| Isolate WooCommerce/bbPress hooks in **`WoocommerceHooks`** / **`BbpressHooks`**. | Theme template hacks that `if ( function_exists( 'is_shop' ) )` deeply through `header.php`. |

### 20. After-bootstrap extensions

| Good                                                                                          | Bad                                                                               |
| --------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------- |
| Child themes/plugins hook **`origamiez_engine_booted`** or public filters to extend behavior. | Patch core theme files under `origamiez/app/` that will be overwritten on update. |

---

_When in doubt, follow an existing class in `origamiez/app/` as the reference implementation and read the matching file in `docs/specs/`._
