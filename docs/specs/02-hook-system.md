# Hook System

## Description
The Origamiez theme utilizes a centralized `HookRegistry` to manage WordPress actions and filters. Instead of scattering `add_action` and `add_filter` calls throughout the codebase, hooks are organized into modular "Hook Provider" classes, promoting better separation of concerns and easier debugging.

## Core Architecture
- **Main Class/File**: `Origamiez\Hooks\HookRegistry` (`origamiez/app/Hooks/HookRegistry.php`)
- **Dependencies**: 
    - `Origamiez\Hooks\HookProviderInterface`: Interface for all hook provider classes.
- **Patterns Used**: 
    - **Registry Pattern**: Central location for registering and tracking hooks.
    - **Provider Pattern**: Modular classes (Providers) supply the hook definitions to the registry.
    - **Fluent Interface**: The `HookRegistry` methods are chainable.

## Implementation Details
- **How it works**: 
    1.  **Registry Initialization**: The `HookRegistry` is managed via the PHP-DI container.
    2.  **Hook Providers**: Classes implementing `HookProviderInterface` are created to group related hooks (e.g., `ThemeHooks`, `FrontendHooks`, `SecurityHooks`).
    3.  **Registration**: `ThemeBootstrap` calls `$hook_registry->register_hooks( new SomeHookProvider() )`.
    4.  **Internal Tracking**: The `HookRegistry` wraps the standard WordPress `add_action` and `add_filter` functions and stores a copy of the hook metadata in an internal `$hooks` array.
- **Key Functions/Methods**:
    - `HookRegistry::add_action(hook, callback, priority, accepted_args)`: Registers an action hook.
    - `HookRegistry::add_filter(hook, callback, priority, accepted_args)`: Registers a filter hook.
    - `HookRegistry::register_hooks(HookProviderInterface provider)`: Accepts a provider and calls its `register()` method.
    - `HookProviderInterface::register(HookRegistry registry)`: Method where providers define their hooks.

## Maintenance & Development
- **Adding New Hooks**: 
    1.  Identify the appropriate Hook Provider (e.g., `app/Hooks/Hooks/FrontendHooks.php`).
    2.  Add the `add_action` or `add_filter` call within the provider's `register()` method.
    3.  Implement the callback method within the same provider class.
- **Debugging**: Use `$hook_registry->get_hooks()` to inspect all hooks registered through the theme's engine.
- **Common Issues**: 
    - **Priority Conflicts**: Ensure priorities are explicitly set if multiple providers hook into the same WordPress event.
    - **Missing Registration**: Remember to register new Hook Provider classes in `ThemeBootstrap::register_hooks()`.

## Related Files
- `origamiez/app/Hooks/HookRegistry.php`
- `origamiez/app/Hooks/HookProviderInterface.php`
- `origamiez/app/Hooks/Hooks/ThemeHooks.php`
- `origamiez/app/Hooks/Hooks/FrontendHooks.php`
- `origamiez/app/Hooks/Hooks/SecurityHooks.php`
- `origamiez/app/Hooks/Plugins/BbpressHooks.php`
- `origamiez/app/Hooks/Plugins/WoocommerceHooks.php`
