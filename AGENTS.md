# AGENTS.md - Project Instructions for AI Agents

## Project Identity

- **Name**: Origamiez
- **Purpose**: A flexible, high-performance WordPress theme for magazines, newspapers, and e-commerce.
- **Vibe**: Professional, modular, and extensible. It bridges traditional WordPress development with modern engineering practices (Vite, Dependency Injection, PSR-4).

## Tech Stack & Environment

- **PHP**: 7.4+ (Fully optimized for PHP 8.3+).
- **WordPress**: 5.5+ (Tested up to 6.9.0).
- **Frontend**: Vite-based build system, SASS (modern structure), Bootstrap 5.3.
- **Dependencies**: PHP-DI (Dependency Injection), Font Awesome 6.4.0, Owl Carousel.
- **Environment**: Fully containerized with Docker (Apache/PHP 8.3).

## Architecture & Coding Standards

- **Core Logic**: Located in `app/` using PSR-4 autoloading.
- **Dependency Injection**: Managed via `php-di/php-di` (see `app/Core/Container.php`).
- **Hook System**: Centralized registration via `HookRegistry`. Avoid manual `add_action` in random files.
- **UI Components**: Modular template parts in `parts/`. Use `get_template_part()` for reuse.
- **Asset Management**: Enqueued through specialized services (see `docs/specs/03-asset-management.md`).
- **Standards**: Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/) for PHP and modern ES6+ for JavaScript.

## Directory Structure

- `app/`: Core PHP classes (Business logic, Services, Registry).
- `inc/`: Theme-specific inclusions (Widgets, Customizer, classic hooks).
- `parts/`: Reusable HTML template parts.
- `assets/`: Source SASS and JS files.
- `origamiez/`: The final theme package folder.
- `docs/`: Comprehensive technical specifications.
- `docker/`: Infrastructure configuration.

## Development Workflow

1.  **Start Environment**: `docker compose up -d`
2.  **Initialize**: `./bin/init.sh`
3.  **Frontend Development**: `npm run dev` (Vite HMR) or `npm run watch`.
4.  **Production Build**: `npm run build`.

## Coding & Naming Conventions

### PHP (WordPress & PSR-4)

- **Standard**: Follow [WordPress Coding Standards (WPCS)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- **Naming**:
    - **Classes**: `PascalCase` (e.g., `ThemeOptions`).
    - **Methods/Functions**: `snake_case` (e.g., `get_option`).
    - **Variables**: `snake_case`.
    - **Files (Classes)**: Follow PSR-4 naming within `app/` (e.g., `app/Core/Container.php` holds `Origamiez\Core\Container`).
    - **Files (Templates)**: `kebab-case.php` (e.g., `single-post.php`).
- **Prefixing**: Always prefix global functions and constants with `origamiez_` to avoid collisions.

### CSS / SASS

- **Naming**: Follow **WordPress-style naming** (similar to BEM but using hyphens).
    - **Selectors**: `kebab-case` (e.g., `.origamiez-header-bottom`).
    - **Prefixing**: Use `origamiez-` prefix for theme-specific components.
- **Variables**: Use CSS Custom Properties (Variables) prefixed with `--` (e.g., `--primary-color`).
- **Structure**: Organize SCSS into modular files (mixins, variables, overrides, plugins).

### JavaScript / TypeScript

- **Naming**:
    - **Variables/Functions**: `camelCase` (e.g., `initMainMenu`).
    - **Constants**: `UPPER_SNAKE_CASE` (e.g., `MAX_RETRIES`).
    - **Classes**: `PascalCase`.
- **Global Object**: Use `Origamier` (or similar theme-specific namespace) to encapsulate theme logic and avoid global scope pollution.
- **Library Usage**: Prefer jQuery (standard for WP) but use modern ES6+ features where applicable.

## Infrastructure & Commands

Use the `Makefile` to manage the development environment efficiently:

- `make setup`: Initializes the environment (creates `.env`, `override.ini`, and checks Docker networks).
- `make up`: Full startup (runs `setup` then `docker compose up -d`).
- `make down`: Stops all containers.
- `make restart`: Restarts all services.
- `make remove`: Destroys containers and removes all associated volumes (clean slate).

## Code Quality & Formatting

Always run these commands before submitting changes to ensure consistency:

### PHP (WordPress Coding Standards)

- `composer format`: Checks for PHP coding standard violations.
- `composer fix`: Automatically fixes PHP coding standard violations using PHPCBF.

### JavaScript/CSS (Prettier & ESLint)

- `pnpm format`: Formats all frontend assets using Prettier.
- `pnpm lint:fix`: Runs ESLint with auto-fix enabled for JS/TS files.

## AI Guidelines

- **Be Minimalist**: Only modify necessary files. Do not create documentation unless asked.
- **Respect Patterns**: Check `app/` for existing service patterns before adding new global functions.
- **Use Hooks**: Always look for existing hooks or register new ones through the `HookRegistry`.
- **Reference Docs**: Always consult `./docs/specs/` for deep architectural understanding.
- **Context Awareness**: Origamiez is designed for both free and premium features; maintain compatibility with the core structure.
