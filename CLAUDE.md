# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Origamiez is a WordPress theme designed for magazine, newspaper, and forum websites. It's built with PHP, SCSS/CSS, JavaScript, and uses Docker for development environment setup. The theme features responsive design, multiple layout options, custom widgets, and plugin integrations (WooCommerce, bbPress, DW Question & Answer).

## Development Environment

### Initial Setup
```bash
# Start Docker containers and run installation
docker compose up -d && ./bin/install.sh
```

### Access URLs
- WordPress Admin: http://localhost:8000/wp-admin/
- Username: admin
- Password: admin

### Key Commands

#### Asset Building
```bash
# Build assets for development
npm run dev

# Watch files and rebuild on changes  
npm run watch
```

#### Docker Operations
```bash
# Access container shell
docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) bash

# Install Composer dependencies (inside container)
cd /var/www/html/wp-content/themes/origamiez && composer install
```

## Architecture

### Directory Structure
- `origamiez/` - Main theme directory containing WordPress theme files
- `assets/` - Source SCSS and JavaScript files for compilation
- `docker/` - Docker configuration and database snapshots
- `docs/` - Documentation files
- `bin/` - Shell scripts for setup and maintenance

### Key Files
- `functions.php` - Main theme setup and WordPress hooks
- `origamiez/inc/functions.php` - Theme utility functions and asset enqueuing
- `origamiez/app/Core/ServiceContainer.php` - Dependency injection container using PHP-DI
- `webpack.mix.js` - Laravel Mix configuration for asset compilation
- `style.scss` - Main stylesheet entry point

### Theme Architecture
- **Template System**: Standard WordPress template hierarchy with custom template parts in `parts/`
- **Widget System**: Custom widget classes in `origamiez/inc/classes/` extending abstract base classes
- **Plugin Integration**: Dedicated directories for bbPress, WooCommerce, and DW Q&A in `origamiez/plugins/`
- **Customizer Integration**: Theme options managed through WordPress Customizer
- **Multi-language Support**: Translation files in `origamiez/languages/`

### Asset Pipeline
Laravel Mix handles:
- SCSS compilation from `assets/sass/` to `origamiez/css/`
- JavaScript bundling from `assets/js/` to `origamiez/js/`
- Third-party library integration (Bootstrap, FontAwesome, Owl Carousel, etc.)
- String replacement for version management and path fixes

### Code Organization
- **PSR-4 Autoloading**: Classes in `origamiez/app/` use `Origamiez\` namespace
- **Dependency Injection**: PHP-DI container for service management
- **WordPress Standards**: Follows WordPress coding standards and template hierarchy
- **Modular Templates**: Template parts organized by functionality in `parts/` subdirectories

## Development Workflow

1. Make changes to source files in `assets/` directory
2. Run `npm run watch` for automatic rebuilding during development
3. Test changes in Docker environment at http://localhost:8000
4. For PHP changes, modify files in `origamiez/` directory directly
5. Use `composer install` inside Docker container for PHP dependencies