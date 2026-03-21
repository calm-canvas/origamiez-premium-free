# Technical Documentation Index

This directory contains the technical specifications for the Origamiez WordPress theme.

## Documentation Files

1.  **[01-architecture-overview.md](./01-architecture-overview.md)**: High-level overview of the theme's core architecture, including `ThemeBootstrap`, the Dependency Injection (DI) Container, and the initialization process.
2.  **[02-hook-system.md](./02-hook-system.md)**: Documentation of the `HookRegistry` and how the theme organizes WordPress actions and filters into modular hook classes.
3.  **[03-asset-management.md](./03-asset-management.md)**: Details on the `AssetManager`, enqueuing logic, and integration with the modern build system (Vite).
4.  **[04-customizer-service.md](./04-customizer-service.md)**: Explanation of the `CustomizerService` and the structured approach to registering theme settings and controls.
5.  **[05-configuration-management.md](./05-configuration-management.md)**: Deep dive into the `ConfigManager` and specialized configuration classes for skins, layouts, and typography.
6.  **[06-layout-and-display.md](./06-layout-and-display.md)**: Covers `BodyClassManager`, `BreadcrumbGenerator`, and other display-related helpers.
7.  **[07-widgets-and-sidebars.md](./07-widgets-and-sidebars.md)**: Documentation of the `WidgetFactory` and `SidebarRegistry` for managing theme widgets and sidebars.
8.  **[08-template-system.md](./08-template-system.md)**: Overview of the WordPress template hierarchy used in the theme and the modular `parts/` directory.
9.  **[09-plugin-integrations.md](./09-plugin-integrations.md)**: Details on the integration layers for third-party plugins like WooCommerce and bbPress.
10. **[10-development-guide.md](./10-development-guide.md)**: Best practices for development, maintenance, and extending the theme's functionality.
11. **[11-security-and-optimization.md](./11-security-and-optimization.md)**: Details on the `SecurityHooks` and HTTP security headers.
12. **[12-post-features.md](./12-post-features.md)**: Documentation for post formats, metadata, and dynamic post classes.
13. **[13-customizer-to-site-editor-migration.md](./13-customizer-to-site-editor-migration.md)**: Plan and field mapping for migrating Color, Typography, and Google Fonts from `theme_mod` / Customizer to Site Editor Theme JSON (user global styles).

## Documentation Template
All technical documentation files follow the standard format defined in **[template.md](./template.md)**.
