---
description: Repository Information Overview
alwaysApply: true
---

# Origamiez WordPress Theme Information

## Summary

Origamiez is a flexible WordPress theme designed for magazine, newspaper, and forum websites. It features a responsive layout with extensive customization options including multiple layouts, color schemes, and widget areas. The theme supports various post formats and integrates with popular plugins like WooCommerce and bbPress.

## Structure

- **origamiez/**: Main theme directory with PHP templates, assets, and functionality
- **assets/**: Source files for CSS (SASS) and JavaScript
- **bin/**: Installation and startup scripts
- **docker/**: Docker configuration and database snapshots
- **.zencoder/**: Configuration for Zencoder

## Language & Runtime

**Language**: PHP, JavaScript, SASS
**PHP Version**: 7.4+ (Tested up to 8.3)
**WordPress Version**: 5.5+ (Tested up to 6.9.0)
**Build System**: Vite
**Package Managers**: Composer (PHP), pnpm/npm (JavaScript)

## Dependencies

**PHP Dependencies**:

- php-di/php-di: 5.4 (Dependency Injection Container)

**JavaScript Dependencies**:

- bootstrap: 5.3.0
- @fortawesome/fontawesome-free: 6.4.0
- owl.carousel: 2.3.4
- jquery-poptrox
- superfish: 1.7.10
- Navgoco

**Development Dependencies**:

- laravel-mix: 6.0.49
- webpack: 5.60.0
- sass: 1.63.6
- postcss: 8.3.11

## Infrastructure & Commands

Use the `Makefile` to manage the development environment efficiently:

- `make setup`: Initializes the environment (creates `.env`, `override.ini`, and checks Docker networks).
- `make up`: Full startup (runs `setup` then `docker compose up -d`).
- `make down`: Stops all containers.
- `make restart`: Restarts all services.
- `make remove`: Destroys containers and removes all associated volumes (clean slate).

## Build & Installation

```bash
# Start Docker containers
make up

# Run installation script
./bin/init.sh

# Install npm dependencies
pnpm install

# Run development server
pnpm dev

# Compile assets
pnpm build

# Watch for changes during development
pnpm watch
```

## Code Quality & Formatting

Always run these commands before submitting changes to ensure consistency:

### PHP (WordPress Coding Standards)

- `composer format`: Checks for PHP coding standard violations.
- `composer fix`: Automatically fixes PHP coding standard violations using PHPCBF.

### JavaScript/CSS (Prettier & ESLint)

- `pnpm format`: Formats all frontend assets using Prettier.
- `pnpm lint:fix`: Runs ESLint with auto-fix enabled for JS/TS files.

## Coding & Naming Conventions

### PHP (WordPress & PSR-4)

- **Standard**: Follow [WordPress Coding Standards (WPCS)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- **Naming**:
    - **Classes**: `PascalCase` (e.g., `ThemeOptions`).
    - **Methods/Functions**: `snake_case` (e.g., `get_option`).
    - **Variables**: `snake_case`.
    - **Files (Classes)**: Follow PSR-4 naming within `app/` (e.g., `app/Core/Container.php` holds `Origamiez\Core\Container`).
- **Prefixing**: Always prefix global functions and constants with `origamiez_`.

### CSS / SASS

- **Naming**: Follow WordPress-style naming (similar to BEM but using hyphens).
    - **Selectors**: `kebab-case` (e.g., `.origamiez-header-bottom`).
    - **Prefixing**: Use `origamiez-` prefix for theme-specific components.
- **Variables**: Use CSS Custom Properties (Variables) prefixed with `--`.

### JavaScript / TypeScript

- **Naming**:
    - **Variables/Functions**: `camelCase` (e.g., `initMainMenu`).
    - **Constants**: `UPPER_SNAKE_CASE`.
    - **Classes**: `PascalCase`.
- **Global Object**: Use `Origamier` namespace to encapsulate theme logic.

## Docker

**Docker Image**: wordpress:php8.3-apache
**Configuration**:

- Custom PHP configuration in docker/config/override.ini
- Database and media restoration scripts in docker/snapshot/
- WordPress runs on port configured in .env (WP_PORT)
- Uses Apache as web server
- Includes wp-cli for WordPress management
- Includes scheduler service (Ofelia) for WP-Cron

## Main Files & Resources

**Entry Points**:

- functions.php: Theme initialization and setup
- index.php: Main template file
- style.css: Theme metadata and compiled styles

**Configuration**:

- webpack.mix.js: Asset compilation configuration
- composer.json: PHP dependency management
- package.json: JavaScript dependency management
- docker-compose.yml: Docker environment setup

## Testing

**Access**:

- WordPress Admin: http://localhost:8001/wp-admin/
- Username: root
- Password: secret

## Documentation

Detailed technical specifications and guides are available in the `./docs` directory.

- **Core Theme Specifications (`./docs/specs/`)**:
    - **[Architecture Overview](./docs/specs/01-architecture-overview.md)**: Theme core & DI Container
    - **[Hook System](./docs/specs/02-hook-system.md)**: HookRegistry & modular hooks
    - **[Asset Management](./docs/specs/03-asset-management.md)**: CSS/JS enqueuing & build system
    - **[Customizer Service](./docs/specs/04-customizer-service.md)**: Theme options & builders
    - **[Configuration Management](./docs/specs/05-configuration-management.md)**: ConfigManager & specialized configs
    - **[Layout and Display](./docs/specs/06-layout-and-display.md)**: Body classes & breadcrumbs
    - **[Widgets and Sidebars](./docs/specs/07-widgets-and-sidebars.md)**: Custom widgets & sidebar registry
    - **[Template System](./docs/specs/08-template-system.md)**: Modular template parts
    - **[Plugin Integrations](./docs/specs/09-plugin-integrations.md)**: WooCommerce & bbPress layers
    - **[Development Guide](./docs/specs/10-development-guide.md)**: Best practices & workflows
    - **[Security and Optimization](./docs/specs/11-security-and-optimization.md)**: Security hooks & HTTP headers
    - **[Post Features](./docs/specs/12-post-features.md)**: Post formats, metadata & classes
    - **[Full Documentation Index](./docs/specs/index.md)**
- **Docker Documentation (`./docs/docker/`)**:
    - **[Docker Architecture](./docs/docker/architecture.md)**: Detailed stack and service overview
    - **[Usage Guide](./docs/docker/usage.md)**: Commands for development, backup, and restore

## Theme Structure

The theme follows WordPress standards with template files in the root, and specialized directories:

- **app/**: Core PHP classes with PSR-4 autoloading
- **inc/**: Theme includes (widgets, customizer, functions)
- **parts/**: Template parts for modular development
- **plugins/**: Integration with third-party plugins
- **skin/**: Theme skin/color variations
- **typography/**: Typography style variations
