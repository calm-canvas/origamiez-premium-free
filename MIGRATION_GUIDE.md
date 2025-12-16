# Origamiez Theme Refactoring - Migration Guide

## Overview

This guide helps developers understand the refactoring changes and how to work with the new OOP engine while maintaining backward compatibility.

---

## What Changed?

### Code Organization

**Before Refactoring:**
```
origamiez/
├── inc/
│   ├── functions.php (938 lines)
│   ├── customizer.php (600+ lines)
│   ├── sidebar.php (76 lines)
│   └── classes/
│       ├── abstract-widget.php
│       ├── abstract-widget-type-b.php
│       └── abstract-widget-type-c.php
```

**After Refactoring:**
```
origamiez/
├── inc/
│   ├── functions.php (853 lines - refactored)
│   ├── widget.php (maintained)
│   └── classes/
│       ├── abstract-widget-type-b.php (refactored)
│       └── abstract-widget-type-c.php (refactored)
├── engine/
│   ├── Config/ (configuration management)
│   ├── Assets/ (CSS/JS enqueuing)
│   ├── Hooks/ (hook registration)
│   ├── Layout/ (body classes, sidebars)
│   ├── Display/ (breadcrumbs, comments, etc.)
│   ├── Security/ (sanitizers, validators, headers)
│   ├── Customizer/ (customizer settings and controls)
│   ├── Post/ (post formatting, metadata)
│   ├── Widgets/ (widget factory, sidebar registry)
│   ├── Utils/ (utilities)
│   ├── Providers/ (utility generators)
│   ├── Container.php (dependency injection)
│   ├── ThemeBootstrap.php (orchestrator)
│   └── index.php (bootstrap entry point)
└── vendor/ (autoloading)
```

---

## Key Architecture Changes

### 1. Dependency Injection Container

All major services are now managed by a PSR-11 compliant container.

**Access Container Services:**
```php
use Origamiez\Engine\Container;
use Origamiez\Engine\Config\ConfigManager;

$container = Container::getInstance();
$config = $container->get('config_manager');

// Or directly access singleton instances:
$config = ConfigManager::getInstance();
```

### 2. Wrapper Functions (Backward Compatible)

All original functions are preserved and now delegate to engine classes:

```php
// Old code still works - it calls the engine:
origamiez_get_breadcrumb();          // → BreadcrumbGenerator
origamiez_body_class($classes);      // → BodyClassManager
origamiez_archive_post_class($classes); // → PostClassManager
origamiez_sanitize_checkbox($input); // → SanitizationManager
```

### 3. New Engine Classes

For advanced usage, you can instantiate engine classes directly:

```php
// Direct usage (advanced)
$breadcrumb = new \Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator();
$breadcrumb->displayBreadcrumb();

// Or get from container (recommended)
$container = \Origamiez\Engine\Container::getInstance();
$generator = $container->get('breadcrumb_generator');
$generator->displayBreadcrumb();
```

---

## Migration Path for Custom Code

### Scenario 1: You're using wrapper functions (No changes needed!)

Your existing theme customizations will continue to work:

```php
// This still works exactly the same:
add_filter('body_class', 'your_custom_body_class_callback');

function your_custom_body_class_callback($classes) {
    // This still works:
    $classes = origamiez_body_class($classes);
    
    // Your custom logic:
    $classes[] = 'custom-class';
    
    return $classes;
}
```

### Scenario 2: You're extending the theme (Recommended new approach)

Use engine classes for more control:

```php
// Add custom body class provider (uses provider pattern)
use Origamiez\Engine\Container;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class CustomBodyClassProvider implements BodyClassProviderInterface {
    public function provide(array $classes = []): array {
        if (is_front_page()) {
            $classes[] = 'is-home-page';
        }
        return $classes;
    }
}

// Register it:
add_action('origamiez_engine_booted', function() {
    $container = Container::getInstance();
    $manager = $container->get('body_class_manager');
    $manager->registerProvider(new CustomBodyClassProvider());
});
```

### Scenario 3: You're adding custom sanitizers

```php
use Origamiez\Engine\Security\SanitizationManager;
use Origamiez\Engine\Security\Sanitizers\SanitizerInterface;

class CustomSanitizer implements SanitizerInterface {
    public function sanitize($value) {
        // Your sanitization logic
        return wp_kses_post($value);
    }
}

// Register it:
add_action('origamiez_engine_booted', function() {
    $manager = SanitizationManager::getInstance();
    $manager->register('custom', new CustomSanitizer());
});

// Use it:
$sanitizer = SanitizationManager::getInstance();
$clean = $sanitizer->sanitize($dirty, 'custom');
```

---

## File-by-File Migration Guide

### origamiez/inc/functions.php

**Changes:**
- 90-line `origamiez_get_breadcrumb()` → 3-line wrapper
- `origamiez_sanitize_*()` functions → use SanitizationManager
- `origamiez_add_security_headers()` → use SecurityHeaderManager
- Login tracking functions → use LoginAttemptTracker

**What to do:**
- ✅ Keep calling these functions (they work the same)
- ✅ Or access engine classes directly if you want more control

### origamiez/inc/classes/abstract-widget-type-b.php & type-c.php

**Changes:**
- Widget types now use composition instead of inheritance
- `print_metadata()` → `WidgetTypeB::renderMetadata()`
- `print_excerpt()` → `WidgetTypeB::renderExcerpt()`

**What to do:**
- ✅ If you subclassed these widget types, they'll continue to work
- ✅ New widgets should extend `engine/Widgets/AbstractWidget.php`

### Configuration

**Old way:**
```php
// Manual configuration scattered throughout code
define('SOME_CONSTANT', 'value');
```

**New way:**
```php
use Origamiez\Engine\Config\ConfigManager;

$config = ConfigManager::getInstance();
$width = $config->get('theme.content_width');
$option = $config->getThemeOption('custom_setting');
```

---

## Hook Reference

### New Hooks

**Engine Bootstrap Complete:**
```php
add_action('origamiez_engine_booted', function() {
    // Fired after all engine services are initialized
    // Use this to add custom providers, settings, sanitizers, etc.
});
```

### Existing Hooks (Still Working)

All WordPress hooks still work:
- `after_setup_theme` - Theme setup
- `wp_enqueue_scripts` - Asset enqueuing
- `body_class` - Body classes
- `post_class` - Post classes
- `customize_register` - Customizer registration
- `widgets_init` - Widget registration

---

## Performance Considerations

### Lazy Loading

Engine services are lazy-loaded - they're only instantiated when needed:

```php
$container = Container::getInstance();

// These don't instantiate services:
if ($container->has('custom_service')) {
    // These do instantiate:
    $service = $container->get('custom_service');
}
```

### Singleton Pattern

Key services use singleton pattern to avoid duplication:

```php
// Both return the SAME instance:
$config1 = ConfigManager::getInstance();
$config2 = ConfigManager::getInstance();
assert($config1 === $config2); // true
```

### Memory Impact

- Wrapper functions add minimal overhead (3-5 lines each)
- Engine initialization is cached via singletons
- No performance degradation compared to original code

---

## Troubleshooting

### Issue: "Class not found" error

**Solution:** Ensure `vendor/autoload.php` is loaded:
```php
require_once get_template_directory() . '/vendor/autoload.php';
```

This is already done in `origamiez/functions.php`.

### Issue: Custom hooks not firing

**Solution:** Check if you're hooking into the right place:

```php
// Wrong - fires before engine is booted:
add_action('init', function() {
    $container = Container::getInstance();
    // Services may not be initialized yet
});

// Right - fires after engine is booted:
add_action('origamiez_engine_booted', function() {
    $container = Container::getInstance();
    // All services are ready
});
```

### Issue: Wrapper functions not working

**Solution:** Ensure `inc/functions.php` is loaded:
```php
// functions.php loading order:
1. require 'inc/functions.php'   // wrapper functions
2. require 'vendor/autoload.php' // PSR-4 autoloading
3. require 'engine/index.php'    // engine bootstrap
```

---

## Testing Your Custom Code

### Test Backward Compatibility

```php
// Ensure your wrapper functions still work:
$this->assertTrue(function_exists('origamiez_get_breadcrumb'));
$this->assertTrue(function_exists('origamiez_sanitize_checkbox'));

// Test that engine classes are accessible:
$this->assertTrue(class_exists('Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator'));
```

### Test Engine Services

```php
// Test container:
$container = Container::getInstance();
$this->assertInstanceOf(Container::class, $container);

// Test singletons:
$config1 = ConfigManager::getInstance();
$config2 = ConfigManager::getInstance();
$this->assertSame($config1, $config2);
```

---

## Frequently Asked Questions

### Q: Do I need to update my code?
**A:** No! All wrapper functions work the same way. Update only if you want to use new features.

### Q: Can I still use hooks?
**A:** Yes! All WordPress hooks still work. Use `origamiez_engine_booted` for engine-dependent code.

### Q: How do I add custom settings?
**A:** Create a class implementing `SettingsInterface` and register it in `origamiez_engine_booted`.

### Q: Where do I put custom code?
**A:** Use a child theme or a custom plugin that hooks into `origamiez_engine_booted`.

### Q: Is this faster/slower?
**A:** Same performance. Lazy loading and singletons ensure efficiency.

### Q: Can I disable the engine?
**A:** No, but wrapper functions provide the original procedural interface, so you can ignore the OOP layer if needed.

---

## Resources

- **REFACTOR_PLAN.md** - Complete refactoring documentation
- **engine/README.md** - Engine architecture guide (if available)
- **WordPress Plugin Handbook** - For hook reference
- **PSR-11** - Container Interface specification

---

## Getting Help

1. Check REFACTOR_PLAN.md for detailed documentation
2. Review engine class implementations for usage examples
3. Check wrapper functions in `inc/functions.php` for migration patterns
4. Read original `functions.php` comments for feature description

---

**Last Updated**: December 2025  
**Refactoring Status**: Complete (Phase 13)  
**Compatibility**: WordPress 5.5 - 6.8.3, PHP 7.4+
