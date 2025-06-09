# Origamiez WordPress Theme - Developer Guide

## Overview

Origamiez is a flexible WordPress theme designed for magazine, newspaper, and forum websites. This developer guide provides information about the theme's architecture, customization options, and development workflow.

## Project Structure

```
origamiez/
├── app/                  # Core application files
├── css/                  # CSS stylesheets
├── images/               # Theme images
├── inc/                  # Theme includes
│   ├── classes/          # PHP classes
│   ├── customizer.php    # Theme customization
│   ├── functions.php     # Helper functions
│   ├── sidebar.php       # Sidebar registration
│   └── widget.php        # Widget registration
├── js/                   # JavaScript files
├── languages/            # Translation files
├── parts/                # Template parts
├── plugins/              # Plugin integrations
│   ├── bbpress/          # bbPress integration
│   ├── dw-question-and-answer/ # DW Q&A integration
│   └── woocommerce/      # WooCommerce integration
├── skin/                 # Theme skins
├── typography/           # Typography styles
└── various template files (index.php, header.php, etc.)
```

## Development Environment

### Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18.x
- Docker & Docker Compose

### Local Development Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/tranthethang/origamiez.git
   cd origamiez
   ```

2. Start the Docker containers:
   ```bash
   docker compose up -d
   ```

3. Run the installation script:
   ```bash
   ./bin/install.sh
   ```

4. Access the WordPress admin at http://localhost:8001/wp-admin/
   - Username: root
   - Password: secret

### Build Process

The theme uses Laravel Mix (webpack wrapper) for asset compilation:

1. Install dependencies:
   ```bash
   npm install
   ```

2. Compile assets:
   ```bash
   npx mix
   ```

3. Watch for changes:
   ```bash
   npx mix watch
   ```

## Theme Architecture

### Core Constants and Prefixes

- `ORIGAMIEZ_PREFIX`: Used as a prefix for all theme-specific functions and variables

### Theme Setup

The theme setup is initialized in `functions.php` with the `origamiez_theme_setup()` function, which:

- Loads text domain for translations
- Registers theme features
- Sets up image sizes
- Registers navigation menus
- Adds action and filter hooks

### Template Hierarchy

The theme follows WordPress standard template hierarchy with additional custom templates:

- `template-page-fullwidth.php`: Full-width page template
- `template-page-fullwidth-centered.php`: Full-width centered page template
- `template-page-magazine.php`: Magazine-style page template
- `template-page-three-cols.php`: Three-column page template
- `template-page-three-cols-slm.php`: Three-column page template with specific layout

### Sidebars and Widget Areas

The theme includes multiple widget areas:

- Main Top
- Main Center Top
- Main Center Left
- Main Center Right
- Main Center Bottom
- Main Bottom
- Left Sidebar
- Right Sidebar
- Footer (1-5)

### Custom Widget Classes

The theme includes abstract widget classes to maintain consistent styling:

- `Abstract_Widget`: Base widget class
- `Abstract_Widget_Type_B`: Extended widget type
- `Abstract_Widget_Type_C`: Extended widget type

### Plugin Integrations

The theme includes custom integrations for:

- bbPress
- DW Question & Answer
- WooCommerce

## Customization

### Theme Customizer

The theme uses WordPress Customizer API for theme options. Customizer settings are defined in `inc/customizer.php`.

Key customization areas:

- Layout options
- Color schemes
- Typography settings
- Header options
- Footer options

### Adding Custom Widgets

1. Create a new widget class that extends one of the abstract widget classes
2. Register the widget in `inc/widget.php`

Example:
```php
class My_Custom_Widget extends Abstract_Widget {
    // Widget implementation
}

function register_my_custom_widget() {
    register_widget('My_Custom_Widget');
}
add_action('widgets_init', 'register_my_custom_widget');
```

### Adding Custom Templates

1. Create a new template file in the theme root directory
2. Add the template header comment:
```php
<?php
/**
 * Template Name: My Custom Template
 */
```

## Coding Standards

The theme follows WordPress coding standards:

- PHP: [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- CSS: [WordPress CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)
- JavaScript: [WordPress JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)

## Deployment

1. Compile production assets:
   ```bash
   npx mix --production
   ```

2. Upload the theme to the WordPress themes directory

## Troubleshooting

### Common Issues

1. **Theme not appearing in WordPress admin**
   - Ensure the theme folder is correctly named `origamiez`
   - Check file permissions

2. **Styling issues after updates**
   - Clear browser cache
   - Recompile assets with `npx mix`

3. **Plugin compatibility issues**
   - Check for updates to plugin integration files in the `plugins/` directory

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

The Origamiez theme is licensed under the GNU General Public License v3.