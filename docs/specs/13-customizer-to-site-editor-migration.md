# Customizer → Site Editor migration plan

This document analyzes moving **Color**, **Typography**, and **Google Fonts** controls from the WordPress Customizer (`get_theme_mod()`) toward **Appearance → Editor** (Site Editor) configuration backed by **Theme JSON** (theme defaults + **user** global styles).

It includes a **field-by-field mapping**, code touchpoints, phased execution, and risks.

---

## 1. Terminology and storage

| Concept | Where it lives |
|--------|----------------|
| **Customizer values today** | `theme_mod` keys (serialized under `theme_mods_{stylesheet}` in `wp_options`). Registered mainly via `CustomizerService` / `ColorSettings` / `TypographySettings`. |
| **Theme file defaults** | `origamiez/theme.json` — versioned in Git; defines palette, font presets, `styles`, etc. |
| **Per-site Editor changes** | WordPress persists user overrides in the **user** Theme JSON layer (typically the `wp_global_styles` post for the active theme), **not** by editing `theme.json` on disk. |
| **Migration flag (planned)** | e.g. `update_option( 'origamiez_mig_gs_v1', … )` or a `theme_mod` — must be **idempotent** and **versioned** (`v1`, `v2`) if the schema changes. |

**Note:** The codebase uses **`get_theme_mod()`**, not `get_theme_option()`, for these features. `ConfigManager::get()` may delegate to `get_theme_mod()` for theme options.

---

## 2. Current code that consumes these settings

### 2.1 Colors and custom skin

| Component | Role |
|-----------|------|
| [`origamiez/app/Assets/InlineStyleGenerator.php`](../../origamiez/app/Assets/InlineStyleGenerator.php) | When `skin === 'custom'`, emits `:root { … }` CSS variables from `get_theme_mod()` color keys; maps fallbacks to `var(--wp--preset--color--*, …)`. Also outputs `black_light_color`. |
| [`origamiez/app/Layout/Providers/GeneralClassProvider.php`](../../origamiez/app/Layout/Providers/GeneralClassProvider.php) | Reads `skin` for body classes. |
| [`assets/sass/_variables.scss`](../../assets/sass/_variables.scss) | Maps semantic colors to `--origamiez-color-*` / presets chain for the built CSS bundle. |

### 2.2 Typography (per-role controls)

| Component | Role | `theme_mod` pattern |
|-----------|------|---------------------|
| [`InlineStyleGenerator::build_font_variables()`](../../origamiez/app/Assets/InlineStyleGenerator.php) | Emits `--font-body`, `--font-heading-h1`, etc., when `{slug}_is_enable` is set. | `{font_object}_{rule}` |

Registered font object slugs (from `TypographySettings`):  
`font_body`, `font_menu`, `font_site_title`, `font_site_subtitle`, `font_widget_title`, `font_h1` … `font_h6`.

Rules: `is_enable`, `family`, `size`, `style`, `weight`, `line_height`.

Dropdown values for `family` / `size` / etc. come from [`FontCustomizerConfig`](../../origamiez/app/Config/FontCustomizerConfig.php) (stacks like `Georgia, serif`, sizes like `18px`, weights like `700`).

### 2.3 Google Fonts (URL + name slots)

| Component | Role |
|-----------|------|
| [`origamiez/app/Assets/FontManager.php`](../../origamiez/app/Assets/FontManager.php) | Enqueues stylesheets from `google_font_{i}_src` when name + src are non-empty. |
| [`origamiez/app/Assets/StylesheetManager.php`](../../origamiez/app/Assets/StylesheetManager.php) | Same pattern (parallel enqueue path). |

Slot count: filter `origamiez_get_number_of_google_fonts` (default **3** in `TypographySettings`).

---

## 3. Design principles for migration

1. **Do not only migrate database** — PHP templates and `InlineStyleGenerator` must eventually **read merged Theme JSON** (or global CSS variables WordPress emits) for colors/typography, or legacy `theme_mod` will still win on the front and diverge from the Site Editor.
2. **Prefer palette slugs that already exist** in `theme.json` when mapping Customizer colors (see mapping table).
3. **Extend** `theme.json` in-repo with **new palette slugs** where Customizer has colors without a preset (menu-specific colors, success, black-light).
4. **Google Fonts URLs** are Stylesheets (`fonts.googleapis.com/css2`), not direct font files — Theme JSON `fontFamilies.fontFace` expects font files; practical approaches: (A) register `fontFamily` name in Theme JSON and **keep enqueueing** the Google URL from stored metadata, or (B) parse/generate `@font-face` (heavier). The plan should pick (A) unless you invest in parsing.
5. **`skin`**: Today, `default` skips custom color CSS output; `custom` enables it. After migration, “custom palette” is equivalent to **user palette entries** in global styles; consider deprecating `skin` in favor of “user has customized colors” detectable from merged JSON.

---

## 4. Suggested migration flag

| Key | Example | Behavior |
|-----|---------|----------|
| Option (recommended) | `origamiez_mig_gs_v1` | Set after successful one-shot migration; value can be timestamp or `1`. Enables future `v2` without collision. |
| Alternative | `theme_mod` e.g. `_origamiez_mig_gs_v1` | Keeps data theme-scoped when switching parent/child; slightly less visible than a dedicated option. |

**Guards:**

- Run only for users with `edit_theme_options` (or during `after_setup_theme` with a scheduled admin notice if migration fails).
- If user global styles already contain substantial custom data, prefer **merge** (fill missing slugs only) or **abort + admin notice** — product decision.

---

## 5. Field mapping: Color (`theme_mod` → Theme JSON)

Customizer registers these in [`ColorSettings`](../../origamiez/app/Customizer/Settings/ColorSettings.php).  
**Target column** describes where migrated user data should land in the **user Theme JSON** layer (same paths apply conceptually if you mirror defaults into `theme.json`).

| `theme_mod` key | Customizer default | Existing `theme.json` slug / note | Target path (user layer) | CSS / front notes |
|-----------------|-------------------|-----------------------------------|--------------------------|-------------------|
| `skin` | `default` | N/A (behavioral) | *No direct JSON field*; after migration, infer “customized” from palette diffs or drop in favor of merged data | Controls whether legacy `InlineStyleGenerator` emitted colors; remove once front uses presets only |
| `primary_color` | `#111111` | `primary` (`theme.json` default **`#111111`**, aligned with Customizer in Phase 1) | `settings.color.palette[]` entry with `"slug": "primary"` | Maps to `--wp--preset--color--primary` |
| `secondary_color` | `#f5f7fa` | `secondary` | `settings.color.palette[]` → `secondary` | |
| `body_color` | `#333333` | `body` | `settings.color.palette[]` → `body`; optionally `styles.typography.color` / `styles.elements.body.color.text` | Align with `styles.color.text` in theme file |
| `heading_color` | `#111111` | `heading` | `settings.color.palette[]` → `heading`; `styles.elements.heading.color.text` | |
| `link_color` | `#111111` | `primary` used for links in theme file | **Decision:** Prefer dedicated slug `primary` **or** add `link` preset if you split link from primary | Theme file uses `styles.elements.link.color.text` → `primary` |
| `link_hover_color` | `#00589f` | `link-hover` | `settings.color.palette[]` → `link-hover`; `styles.elements.link.:hover.color.text` | |
| `main_menu_color` | `#111111` | *Not in theme palette today* | **Add slug** e.g. `main-menu-text` in `settings.color.palette` (+ default in `theme.json`) | Classic header uses `--main-menu-color` in SCSS |
| `main_menu_bg_color` | `#ffffff` | *Not in palette* | **Add** `main-menu-bg` | |
| `main_menu_hover_color` | `#00589f` | *Not in palette* | **Add** `main-menu-hover` | |
| `main_menu_active_color` | `#111111` | *Not in palette* | **Add** `main-menu-active` | |
| `line_1_bg_color` | `#e8ecf1` | `line-1-bg` | `settings.color.palette[]` → `line-1-bg` | |
| `line_2_bg_color` | `#f0f2f5` | `line-2-bg` | → `line-2-bg` | |
| `line_3_bg_color` | `#f8fafc` | `line-3-bg` | → `line-3-bg` | |
| `footer_sidebars_bg_color` | `#222222` | `footer-sidebars-bg` | → `footer-sidebars-bg` | |
| `footer_sidebars_text_color` | `#a0a0a0` | `footer-sidebars-text` | → `footer-sidebars-text` | |
| `footer_sidebars_widget_heading_color` | `#ffffff` | `footer-sidebars-widget-heading` | → `footer-sidebars-widget-heading` | |
| `footer_end_bg_color` | `#111111` | `footer-end-bg` | → `footer-end-bg` | |
| `footer_end_text_color` | `#a0a0a0` | `footer-end-text` | → `footer-end-text` | |
| `black_light_color` | `#f8fafc` | *No dedicated slug in theme file* | **Add** e.g. `black-light` to palette + `_variables.scss` bridge | Used in `InlineStyleGenerator` as `--black_light` |
| `metadata_color` | `#666666` | `metadata` | → `metadata` | |
| `color_success` | `#27ae60` | *No slug in theme file* | **Add** e.g. `success` | `--color-success` in SCSS |

### 4.1 Post-migration styles hooks (recommended)

To keep editor and front aligned, user JSON should also update **`styles`** where the theme file already references presets:

- `styles.color.text` → `var(--wp--preset--color--body)` (already in theme file).
- `styles.elements.heading.color.text` → `heading` preset.
- `styles.elements.link` / `:hover` → `primary` + `link-hover` (or dedicated link slug if introduced).

Navigation / header colors may require **`styles.blocks["core/navigation"]`** in addition to palette tokens for block-based headers.

---

## 6. Field mapping: Typography (`theme_mod` → Theme JSON)

For each **font object** below, rules are stored as:

| Suffix (`theme_mod`) | Meaning | Theme JSON `typography` property |
|----------------------|---------|----------------------------------|
| `{slug}_is_enable` | `0` / `1` | If `0`, skip migrating that group |
| `{slug}_family` | CSS stack string | `fontFamily` |
| `{slug}_size` | e.g. `18px` | `fontSize` |
| `{slug}_style` | `normal` / `italic` / `oblique` | `fontStyle` |
| `{slug}_weight` | e.g. `700` | `fontWeight` (string acceptable) |
| `{slug}_line_height` | e.g. `1.5` | `lineHeight` |

### 6.1 Font object → JSON path

| Font object slug (`theme_mod` prefix) | Semantic role | Target Theme JSON path (user layer) | Coverage notes |
|--------------------------------------|----------------|----------------------------------------|----------------|
| `font_body` | Body copy | `styles.elements.body.typography` | Add `elements.body` in user JSON if absent |
| `font_h1` | Heading 1 | `styles.elements.h1.typography` | Merges with theme file `elements.heading` for shared props; prefer explicit `h1` |
| `font_h2` | Heading 2 | `styles.elements.h2.typography` | |
| `font_h3` | Heading 3 | `styles.elements.h3.typography` | |
| `font_h4` | Heading 4 | `styles.elements.h4.typography` | |
| `font_h5` | Heading 5 | `styles.elements.h5.typography` | |
| `font_h6` | Heading 6 | `styles.elements.h6.typography` | |
| `font_menu` | Primary menu UI | `styles.blocks["core/navigation"].typography` | Classic PHP menus are **not** the Navigation block — may still need CSS variables / template work |
| `font_site_title` | Site title | `styles.blocks["core/site-title"].typography` | Affects block-based titles; classic header may need bridge |
| `font_site_subtitle` | Tagline | `styles.blocks["core/site-tagline"].typography` | Same as above |
| `font_widget_title` | Widget headings | *No first-class WP element* | Options: (1) `settings.custom.origamiez.widgetTitle.*` + map to `--font-widget-title*` in PHP, (2) global `styles.blocks["core/heading"]` (too broad), (3) keep small legacy inline layer |

---

## 7. Field mapping: Google Fonts slots

| `theme_mod` key | Example | Target (recommended) | Notes |
|-----------------|---------|----------------------|-------|
| `google_font_0_name` | `Open Sans` | `settings.typography.fontFamilies[]` with unique `slug` e.g. `origamiez-google-0`, `name`, `fontFamily`: `"Open Sans", sans-serif` | Name is display/stack hint; actual face loading is via URL today |
| `google_font_0_src` | `https://fonts.googleapis.com/css2?...` | **Also store** under `settings.custom.origamiez.googleFonts[0].src` **or** keep option/meta for enqueue | Theme JSON `fontFace.src` expects font files; **continue enqueuing** the stylesheet URL from this string unless you generate real `fontFace` |
| `google_font_1_*`, `google_font_2_*` | … | Same pattern with indices `1`, `2` | Count follows `origamiez_get_number_of_google_fonts` |

**Implementation strategy (pragmatic):** Migration writes **font family registration** into Theme JSON for editor visibility, and **persists the Google CSS URL** in a custom bucket or duplicate `theme_mod` until `FontManager` reads from a single resolver (merged JSON + custom).

---

## 8. Phased implementation plan

| Phase | Scope | Deliverables |
|-------|--------|--------------|
| **0 – Inventory** | Freeze public `theme_mod` keys for Color/Typography/Google Fonts; document deprecations | Changelog + this spec kept current |
| **1 – Theme defaults** | Add missing palette slugs (`main-menu-*`, `black-light`, `success`, optional `link`) to `origamiez/theme.json`; align defaults with intended brand (reconcile `#111111` vs `#222222` for primary) | **Done:** `theme.json` palette + primary/heading `#111111`; `_tokens.scss`, `_variables.scss`, `InlineStyleGenerator` preset fallbacks; slug `link` still deferred (element link uses `primary`). |
| **2 – Migration routine** | One-shot: read listed `theme_mod`s → merge into user global styles JSON; set `origamiez_mig_gs_v1`; merge policy for existing user data | **`GlobalStylesCustomizerMigrator`** (`origamiez/app/Migration/GlobalStylesCustomizerMigrator.php`): runs on **`admin_init`** (priority 30) when `edit_theme_options`, idempotent via option **`origamiez_mig_gs_v1`** (also **`skipped-incompatible-wp`** / **`skipped-no-theme-json`** on old WP or no `theme.json`). Fill-missing merge for palette slugs, `fontFamilies`, `styles.elements` / `styles.blocks`, **`settings.custom.origamiez`**. Errors → **`origamiez_mig_gs_v1_error`** + one-time **`admin_notices`**. Filter **`origamiez_global_styles_migration_enabled`**, **`origamiez_global_styles_migration_patch`**. Requires **WordPress 5.9+** (`WP_Theme_JSON`, `wp_global_styles` CPT). Re-test: `delete_option( 'origamiez_mig_gs_v1' );`. |
| **3 – Customizer UX** | Remove controls; show notice + link to `admin_url( 'site-editor.php' )` | **Done:** `SiteEditorNoticeControl` + `ColorSettings` / `TypographySettings` register `origamiez_site_editor_notice` only (core **Colors** section + typography / Google Fonts panels). Filter `origamiez_site_editor_admin_url`. |
| **4 – Front-end bridge** | Replace `InlineStyleGenerator` color/font reads with merged Theme JSON outputs **or** rely on `wp_enqueue_global_styles` + preset variables; update `GeneralClassProvider` for `skin` deprecation | **Done:** `ThemeJsonAppearanceBridge` (`origamiez_mig_gs_v1` array = active); merged data via `WP_Theme_JSON_Resolver::get_merged_data()` (**WP 6.2+**); colors: no legacy theme_mod inline when active (Core global styles + `_tokens.scss`); typography: inline from merged `styles` + `settings.custom.origamiez.widgetTitleTypography`; Google Fonts: `StylesheetManager` uses `get_dynamic_google_fonts_for_enqueue()` (JSON then theme_mod). **`FontManager::enqueue`** no-op (avoid duplicate handles). Body class **`origamiez-global-styles-bridge`**. Filters: **`origamiez_theme_json_appearance_bridge_active`**. |
| **5 – Cleanup** | Remove dead callbacks, optional `remove_theme_mod` batch (dangerous — only after verifying parity) | **Done:** Removed unused `origamiez_skin_custom_callback` and `origamiez_font_*` helpers from `inc/customizer-callbacks.php` (child themes that referenced these strings as `active_callback` must switch to custom callbacks). Added `LegacyAppearanceThemeModKeys` for the canonical key list + `all_keys()`. No automatic purge shipped — see §11. |

---

## 9. Risks and testing checklist

| Risk | Mitigation |
|------|------------|
| Invalid / partial Theme JSON breaks Site Editor | Validate merged structure against WP version under test; feature-flag migration |
| Classic header/menu ignores block `styles` | Keep CSS custom properties driven from merged resolver or SCSS bridges until templates migrate |
| Child theme `theme_mod` isolation | Document that migration runs per theme; consider copying mods on child activation |
| User edited Site Editor before theme update | Merge-only or skip + notice |
| Google Fonts: Theme JSON vs enqueue mismatch | Single resolver service used by both Site Editor and `FontManager` |

**Tests:** Snapshot global styles post content before/after migration; visual diff key templates; verify `$merged` `WP_Theme_JSON` API on min supported WP version (per `AGENTS.md`).

---

## 10. Related documentation

- [04-customizer-service.md](./04-customizer-service.md) — Customizer architecture  
- [03-asset-management.md](./03-asset-management.md) — Enqueue and inline styles  
- [05-configuration-management.md](./05-configuration-management.md) — `ConfigManager` usage  

---

## 11. Phase 5 — Optional legacy `theme_mod` purge

After migration + visual QA, developers may delete stale mods so the database matches Site Editor-only workflows. **Back up `wp_options` / the theme_mods row first.**

- Programmatic list: `Origamiez\Migration\LegacyAppearanceThemeModKeys::all_keys()` (includes `google_font_{i}_*` up to `origamiez_get_number_of_google_fonts`).
- Purge example (WP-CLI / maintenance mode, **after backup** — removes legacy fallbacks if the bridge is later turned off):  
  `wp eval 'foreach ( \\Origamiez\\Migration\\LegacyAppearanceThemeModKeys::all_keys() as $k ) { remove_theme_mod( $k ); }'`  
  Run only when you intend to drop unstored Customizer state; child themes may still read some of these keys if customized.

**Semver / communication:** Removing global Customizer callback functions is a **backward-compatibility break** for code that referenced them by name; document in release notes for the version that contains Phase 5.

---

*Last updated: aligns with Origamiez theme sources under `origamiez/` and `assets/sass/` as of the document authoring date.*
