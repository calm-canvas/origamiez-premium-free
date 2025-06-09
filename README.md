# Origamiez

Origamiez is a flexible WordPress theme designed for magazine, newspaper, and forum websites. It features a clean, professional layout with extensive customization options including unlimited color schemes, multiple sidebars, rich post formats, and top banner areas. Fully responsive, Origamiez looks great on any device and is easy to customize and use.

This WordPress theme was originally designed and coded by COLOURS THEME.

## Features

- Responsive design that works on all devices
- Multiple layout options (full-width, magazine, three-column)
- Extensive widget areas for flexible content placement
- Custom widgets for enhanced functionality
- Support for post formats (standard, gallery, video, audio)
- Integration with popular plugins (WooCommerce, bbPress, DW Question & Answer)
- Translation-ready with multiple languages included
- SEO-friendly markup

## Requirements

- Docker & Docker Compose
- PHP 8.2
- Composer
- Node.js 18.x

## Installation

```shell
docker compose up -d &&
./bin/install.sh
```

## Development Access

- WordPress Admin: http://localhost:8001/wp-admin/
- Username: root
- Password: secret

## Documentation

Comprehensive documentation is available in the `docs` folder:

- [Developer Guide](docs/developer-guide.md) - Technical documentation for theme developers
- [User Guide](docs/user-guide.md) - End-user documentation for website administrators

## Theme Structure

The theme follows WordPress best practices and includes:

- Customizer integration for theme options
- Template parts for modular development
- Custom widget classes for consistent styling
- Plugin integrations for extended functionality

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This theme is licensed under the GNU General Public License v3.0.

## References

- [MySQL Database Management](https://sebhastian.com/mysql-drop-all-tables/)