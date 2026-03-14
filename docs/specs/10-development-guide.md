# Development Guide

## Description
This guide outlines the best practices and recommended workflows for developing, extending, and maintaining the Origamiez WordPress theme. Following these standards ensures that the codebase remains clean, modular, and consistent across all components.

## Core Development Standards
- **Coding Style**: Follow the [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/) and [JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/).
- **Naming Conventions**: 
    - Use `PascalCase` for classes (e.g., `ThemeBootstrap`).
    - Use `snake_case` for methods and variables (e.g., `get_config_manager`).
    - Prefix all non-namespaced functions and constants with `origamiez_`.
- **Modularity**: Always prefer creating a new class or component instead of adding logic to a global file like `functions.php`.

## Implementation Details (Best Practices)
- **Dependency Injection**: 
    - Use the `Container` for all theme services. 
    - Avoid direct instantiation of complex classes; instead, register them as singletons or bindings in `ThemeBootstrap::setup_container()`.
- **Hook Management**: 
    - All actions and filters should be registered via a `HookProviderInterface` class and the `HookRegistry`.
    - Group related hooks together into specialized provider classes.
- **Asset Development**: 
    - Source assets (SASS/JS) reside in the `assets/` directory at the project root.
    - Use **Laravel Mix** for compilation. 
    - Run `npm run watch` during development to automatically recompile assets on save.
- **Customizer Options**: 
    - Define new theme settings within a class implementing `SettingsInterface`.
    - Use the `CustomizerService` for registration.

## Maintenance & Development Workflow
1.  **Environment Setup**: 
    - Use the provided Docker environment for consistent development across team members.
    - Run `./bin/init.sh` to initialize the project and restore the database snapshot.
2.  **Making Changes**: 
    - For logic changes, identify the correct `engine/` sub-directory.
    - For layout changes, look into the `parts/` directory.
    - For style changes, edit the SASS files in `assets/`.
3.  **Testing**: 
    - Before submitting changes, perform manual verification of key layouts (Page Magazine, Archive, Single Post).
    - Ensure compatibility with WooCommerce and bbPress if modifying core display logic.
4.  **Deployment**: 
    - Always run `npm run build` before pushing to production to ensure minified and versioned assets are generated.
    - Do not commit the `vendor/` or `node_modules/` directories.

## Related Resources
- `origamiez/engine/` (Core PHP logic)
- `assets/` (Source assets)
- `webpack.mix.js` (Build configuration)
- `docker-compose.yml` (Development environment)
