---
description: Repository Information Overview
alwaysApply: true
---

# Origamiez WordPress Theme Information

## Summary
Origamiez is a flexible WordPress theme designed for magazine, newspaper, and forum websites. It features a responsive layout with extensive customization options including multiple layouts, color schemes, and widget areas. The theme supports various post formats and integrates with popular plugins like WooCommerce, bbPress, and DW Question & Answer.

## Structure
- **origamiez/**: Main theme directory with PHP templates, assets, and functionality
- **assets/**: Source files for CSS (SASS) and JavaScript
- **bin/**: Installation and startup scripts
- **docker/**: Docker configuration and database snapshots
- **.zencoder/**: Configuration for Zencoder

## Language & Runtime
**Language**: PHP, JavaScript, SASS
**PHP Version**: 7.4+ (Tested up to 8.4)
**WordPress Version**: 5.5+ (Tested up to 6.8.3)
**Build System**: Laravel Mix (webpack wrapper)
**Package Managers**: Composer (PHP), npm (JavaScript)

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

## Build & Installation
```bash
# Start Docker containers
docker compose up -d

# Run installation script
./bin/install.sh

# Install npm dependencies
npm install

# Compile assets
npx mix

# Watch for changes during development
npx mix watch

# Compile for production
npx mix --production
```

## Docker
**Docker Image**: wordpress:php8.4-fpm
**Configuration**: 
- Custom PHP configuration in docker/config/php.ini
- Database and media restoration scripts in docker/snapshot/
- WordPress runs on port 8001 by default (configurable in .env)
- Uses Nginx as web server with PHP-FPM
- Includes wp-cli for WordPress management

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

## Theme Structure
The theme follows WordPress standards with template files in the root, and specialized directories:
- **app/**: Core PHP classes with PSR-4 autoloading
- **inc/**: Theme includes (widgets, customizer, functions)
- **parts/**: Template parts for modular development
- **plugins/**: Integration with third-party plugins
- **skin/**: Theme skin/color variations
- **typography/**: Typography style variations