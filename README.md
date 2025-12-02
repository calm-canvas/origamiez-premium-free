# Origamiez - WordPress Magazine & Forum Theme

A flexible WordPress theme for magazines, news sites, and forums. Responsive, highly customizable, with powerful plugin integrations.

## Features

- **Responsive**: Compatible with all devices
- **Multiple Layouts**: Magazine, news, and forum
- **Customization**: Colors, typography, layout
- **Flexible Widgets**: Multiple content areas
- **Plugin Integration**: WooCommerce, bbPress, DW Q&A
- **Post Formats**: Supports various formats
- **Performance**: Asset optimization, caching
- **Multilingual**: Translation-ready

## Technology Stack

- **Languages**: PHP 7.4+, JavaScript ES6, SCSS
- **CMS**: WordPress 5.5+
- **Frontend**: Bootstrap 5.3, Font Awesome 6.4
- **Build Tool**: Laravel Mix (webpack)
- **Package Managers**: npm, Composer
- **Containerization**: Docker + Nginx + PHP-FPM
- **Database**: MySQL 8.0

## Requirements

- **Docker** ([install](https://docs.docker.com/get-docker/))
- **Docker Compose** 2.0+ ([install](https://docs.docker.com/compose/install/))
- **Node.js** 16+ ([download](https://nodejs.org/))
- **Git** ([install](https://git-scm.com/))
- **MySQL Server** (running separately)

## Installation

### 1. Clone

```bash
git clone https://github.com/tranthethang/origamiez.git
cd origamiez
```

### 2. Configuration

```bash
cp .env.example .env
```

Edit `.env`:

```env
WP_PORT=8001
WORDPRESS_DB_USER=root
WORDPRESS_DB_PASSWORD=secret
WORDPRESS_DB_NAME=origamiez
WORDPRESS_DB_HOST=mysql:3306
```

### 3. Docker Setup

```bash
# Start the containers
docker compose up -d

# Check the status
docker compose ps
```

### 4. Dependencies

```bash
# npm packages
npm install

# PHP dependencies
docker compose exec wordpress composer install
```

### 5. Initialize

```bash
./bin/install.sh
```

### 6. Build Assets

```bash
# Dev build
npm run dev

# Watch
npm run watch

# Production
npm run production
```

### 7. Access

```
http://localhost:8001/wp-admin/
```

**Login**: `root` / `secret`

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

1. **Source Files**: Edit SCSS/JavaScript in the `assets/` directory
2. **Watch Mode**: Run `npm run watch` for automatic recompilation
3. **PHP**: Edit WordPress template files directly in the `origamiez/` directory
4. **View Changes**: Refresh your browser at `http://localhost:8000`

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

1. Ensure the watch/build process has completed:
   ```bash
   npm run dev
   ```

2. Clear the WordPress cache if you are using a caching plugin

3. Hard refresh your browser (Ctrl+Shift+R or Cmd+Shift+R)

### Permission Errors

If you encounter permission issues:

```bash
# Reset permissions (inside container)
docker compose exec wordpress chown -R owp:owp /var/www/html/wp-content/themes/origamiez
```

### Database Connection Issues

Verify that the MySQL credentials in `.env` match your MySQL server:
- Check if `WORDPRESS_DB_HOST` and the port are correct
- Verify `WORDPRESS_DB_USER` and `WORDPRESS_DB_PASSWORD`
- Confirm the database exists: `WORDPRESS_DB_NAME`

## Performance Optimization

The theme includes several optimizations:

- **Lazy Loading**: For images and content
- **Asset Minification**: CSS and JavaScript are minified for production
- **Caching Headers**: Static assets are cached with far-future headers
- **Security Headers**: Security headers are configured in Nginx
- **Database Queries**: Optimized WordPress queries

## Security

The following security features are implemented:

- **Non-root User**: The theme runs as a non-root user (owp)
- **Security Headers**: X-Frame-Options, X-Content-Type-Options, X-XSS-Protection
- **Disabled Functions**: Dangerous PHP functions are disabled by default
- **File Permissions**: Restrictive permissions are set on sensitive directories
- **Environment Variables**: Database credentials are not hardcoded

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
- Check the existing documentation in the `docs/` directory
- Review the WordPress plugin documentation for integrated plugins

## Changelog

### Version 1.0.0
- Initial release with responsive design
- Multiple layout options
- WooCommerce, bbPress, and DW Q&A integration
- Docker containerization with an optimized configuration

---

**Last Updated**: November 2024  
**Maintainer**: Tran The Thang (tranthethang@gmail.com)
