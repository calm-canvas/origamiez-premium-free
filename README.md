# Origamiez - WordPress Magazine & Forum Theme

A flexible, modern WordPress theme designed for magazine, newspaper, and forum websites. Built with responsive design, extensive customization options, and robust plugin integration support.

## Features

- **Responsive Design**: Fully responsive layout that works seamlessly across all devices
- **Multiple Layouts**: Various layout options for magazine, newspaper, and forum displays
- **Customizable**: Extensive customizer options for colors, typography, and layouts
- **Widget Areas**: Multiple widget regions for flexible content placement
- **Plugin Integration**: Built-in support for:
  - WooCommerce (e-commerce)
  - bbPress (forums)
  - DW Question & Answer
- **Post Formats**: Support for multiple post formats (standard, gallery, video, audio, etc.)
- **Performance Optimized**: Fast loading with optimized assets and caching
- **Translation Ready**: Multi-language support with translation files

## Tech Stack

- **Language**: PHP 7.4+, JavaScript (ES6), SCSS/CSS
- **CMS**: WordPress 5.5+
- **Frontend**: Bootstrap 5.3, Font Awesome 6.4
- **Build System**: Laravel Mix (webpack wrapper)
- **Package Managers**: npm (JavaScript), Composer (PHP)
- **Containerization**: Docker + PHP-FPM + Nginx + Supervisor
- **Database**: MySQL 8.0

## Prerequisites

Before getting started, ensure you have:

- **Docker**: Latest version installed ([Docker Installation Guide](https://docs.docker.com/get-docker/))
- **Docker Compose**: Version 2.0+ ([Docker Compose Installation](https://docs.docker.com/compose/install/))
- **Node.js**: Version 16+ for asset building ([Node.js Download](https://nodejs.org/))
- **Git**: For version control ([Git Installation](https://git-scm.com/))
- **MySQL Server**: Running independently (not containerized with this project)

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/tranthethang/origamiez.git
cd origamiez
```

### 2. Environment Configuration

Copy the example environment file and adjust settings:

```bash
cp .env.example .env
```

Edit `.env` with your configuration:

```env
WP_PORT=8000                           # WordPress port
WORDPRESS_DEBUG=1                      # Debug mode
WORDPRESS_DB_USER=root                 # MySQL username
WORDPRESS_DB_PASSWORD=password102           # MySQL password
WORDPRESS_DB_NAME=origamiez            # Database name
WORDPRESS_DB_HOST=your-mysql-host:3306 # MySQL host (adjust if not using default)
WORDPRESS_DB_PORT=3306                 # MySQL port
WORDPRESS_DB_CHARSET=utf8mb4           # Character set
WORDPRESS_TABLE_PREFIX=wp_             # Table prefix
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

This installs all required packages:
- Bootstrap 5.3 for styling
- Font Awesome 6.4 for icons
- Owl Carousel for sliders
- jQuery plugins for interactive features

### 4. Start Docker Container

Ensure your MySQL server is running and accessible, then start the WordPress container:

```bash
docker compose up -d
```

This command:
- Builds the Docker image (on first run)
- Starts the WordPress container with Nginx + PHP-FPM
- Exposes the application on port defined in `.env` (default: 8000)

### 5. Initialize WordPress

Run the installation script to restore database and PHP dependencies:

```bash
./bin/install.sh
```

This script:
- Restores WordPress database from snapshot
- Installs PHP dependencies via Composer
- Sets up the theme environment

### 6. Compile Assets

Build CSS and JavaScript from source files:

```bash
# Development build (with sourcemaps)
npm run dev

# Watch for changes (auto-rebuild on file changes)
npm run watch

# Production build (optimized and minified)
npm run production
```

### 7. Access WordPress

Open your browser and navigate to:

```
http://localhost:8000/wp-admin/
```

**Credentials** (from snapshot):
- **Username**: `admin`
- **Password**: `admin`

## Project Structure

```
origamiez/
├── assets/                 # Source files for compilation
│   ├── js/                # JavaScript source files
│   └── sass/              # SCSS stylesheets
├── bin/                   # Shell scripts
│   ├── install.sh        # Installation script
│   └── bash.sh           # Docker shell access
├── docker/               # Docker configuration
│   ├── config/          # PHP and other configs
│   ├── snapshot/        # Database and SQL files
│   └── media/           # Media files backup
├── origamiez/            # Main theme directory (WordPress theme root)
│   ├── app/             # PHP classes (PSR-4 autoloading)
│   ├── css/             # Compiled stylesheets
│   ├── inc/             # Theme functions and features
│   ├── js/              # Compiled JavaScript
│   ├── parts/           # Template parts for modular development
│   ├── plugins/         # Plugin integrations (bbPress, WooCommerce, etc.)
│   ├── skin/            # Theme color/skin variations
│   ├── typography/      # Typography variations
│   ├── functions.php    # Main theme setup and hooks
│   ├── index.php        # Main template file
│   └── style.css        # Theme metadata
├── Dockerfile           # Container image definition
├── docker-compose.yml   # Docker services configuration
├── webpack.mix.js       # Laravel Mix build configuration
├── package.json         # npm dependencies
└── README.md           # This file
```

## Development Workflow

### Making Changes

1. **Source Files**: Edit SCSS/JavaScript in `assets/` directory
2. **Watch Mode**: Run `npm run watch` for automatic recompilation
3. **PHP**: Edit WordPress template files directly in `origamiez/` directory
4. **View Changes**: Refresh browser at `http://localhost:8000`

### File Organization

- **PHP**: `origamiez/` - Direct WordPress templates
- **Styles**: `assets/sass/` → compiled to `origamiez/css/`
- **Scripts**: `assets/js/` → compiled to `origamiez/js/`
- **Theme Options**: `origamiez/inc/customizer.php`

### Code Standards

The project follows WordPress coding standards:
- WordPress PHP standards for server-side code
- PSR-4 autoloading for classes in `origamiez/app/`
- Dependency injection via PHP-DI container
- Modular template parts in `origamiez/parts/`

## Docker Configuration

### Container Details

- **Image**: WordPress with PHP 8.3-FPM
- **Web Server**: Nginx
- **Process Manager**: Supervisor
- **User**: Non-root user (owp) for security
- **Port**: Configurable via `WP_PORT` in `.env`

### Useful Docker Commands

Access container shell:
```bash
docker compose exec wordpress bash
```

View container logs:
```bash
docker compose logs -f wordpress
```

Stop containers:
```bash
docker compose down
```

Restart container:
```bash
docker compose restart wordpress
```

Monitor container health:
```bash
docker compose ps
```

### Volume Mounts

The following directories are mounted to the container:

- `./origamiez/` → `/var/www/html/wp-content/themes/origamiez`
- `./plugins/` → `/var/www/html/wp-content/plugins`
- `./docker/snapshot/` → `/tmp/snapshot` (database restore files)
- `./docker/config/php.ini` → PHP configuration

## Building & Compilation

### Available npm Scripts

```bash
# Development build with source maps
npm run dev

# Watch files and auto-rebuild during development
npm run watch

# Production build (minified and optimized)
npm run production

# Build and watch in one command
npm run build
```

### Build Output

- **SCSS** → `origamiez/css/style.css`
- **JavaScript** → `origamiez/js/app.js`
- **Maps**: Development builds include source maps for debugging

### Webpack Configuration

Laravel Mix configuration in `webpack.mix.js` handles:
- SCSS compilation and PostCSS processing
- JavaScript bundling and minification
- Third-party library integration
- Asset versioning for cache busting

## Database Management

### Restore Database

To restore the included database snapshot:

```bash
docker compose exec wordpress /tmp/snapshot/restore.sh
```

### Backup Current Database

Create a backup of your current database:

```bash
docker compose exec wordpress mysqldump -h ${WORDPRESS_DB_HOST} \
  -u ${WORDPRESS_DB_USER} -p${WORDPRESS_DB_PASSWORD} \
  ${WORDPRESS_DB_NAME} > backup.sql
```

### MySQL Client Inside Container

Access MySQL CLI:

```bash
docker compose exec wordpress mysql -h ${WORDPRESS_DB_HOST} \
  -u ${WORDPRESS_DB_USER} -p${WORDPRESS_DB_PASSWORD} \
  ${WORDPRESS_DB_NAME}
```

## Troubleshooting

### Container Won't Start

1. Check if port 8000 is already in use:
   ```bash
   lsof -i :8000
   ```
   
2. View container logs:
   ```bash
   docker compose logs wordpress
   ```

3. Verify MySQL is running and accessible:
   ```bash
   docker compose exec wordpress mysql -h ${WORDPRESS_DB_HOST} -u root -p${WORDPRESS_DB_PASSWORD} -e "SELECT 1"
   ```

### Asset Changes Not Showing

1. Ensure watch/build completed:
   ```bash
   npm run dev
   ```

2. Clear WordPress cache if using a cache plugin

3. Hard refresh browser (Ctrl+Shift+R or Cmd+Shift+R)

### Permission Errors

If you encounter permission issues:

```bash
# Reset permissions (inside container)
docker compose exec wordpress chown -R owp:owp /var/www/html/wp-content/themes/origamiez
```

### Database Connection Issues

Verify MySQL credentials in `.env` match your MySQL server:
- Check `WORDPRESS_DB_HOST` and port are correct
- Verify `WORDPRESS_DB_USER` and `WORDPRESS_DB_PASSWORD`
- Confirm database exists: `WORDPRESS_DB_NAME`

## Performance Optimization

The theme includes several optimizations:

- **Lazy Loading**: For images and content
- **Asset Minification**: CSS and JavaScript are minified in production
- **Caching Headers**: Static assets cached with far-future headers
- **Security Headers**: Security headers configured in Nginx
- **Database Queries**: Optimized WordPress queries

## Security

Security features implemented:

- **Non-root User**: Theme runs as non-root user (owp)
- **Security Headers**: X-Frame-Options, X-Content-Type-Options, X-XSS-Protection
- **Disabled Functions**: PHP dangerous functions disabled by default
- **File Permissions**: Restrictive permissions on sensitive directories
- **Environment Variables**: Database credentials not hardcoded

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add YourFeature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a Pull Request

## License

This theme is licensed under the GPL-2.0 License. See [LICENSE.md](LICENSE.md) for details.

## Support

For issues, questions, or suggestions:
- Open an issue on [GitHub Issues](https://github.com/yourusername/origamiez/issues)
- Check existing documentation in `docs/` directory
- Review WordPress plugin documentation for integrated plugins

## Changelog

### Version 1.0.0
- Initial release with responsive design
- Multiple layout options
- WooCommerce, bbPress, and DW Q&A integration
- Docker containerization with optimized configuration

---

**Last Updated**: November 2024  
**Maintainer**: Tran The Thang (tranthethang@gmail.com)
