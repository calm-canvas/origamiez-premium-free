Origamiez - Wordpress Theme

Origamiez is a modern WordPress theme designed for professional blogs, magazines, forums, and online stores. With intelligent responsive design, Origamiez delivers exceptional user experience across all devices.

Developed and maintained by @tranthethang with a commitment to continuous updates.

Origamiez combines simplicity with professional power. The theme offers outstanding features: multi-language support, unlimited color schemes, 8 customizable widgets, seamless integration with WooCommerce, bbPress, SEO-optimized structure, and dark mode support. Built with Bootstrap 5.3 and modern Vite build tool, ensuring fast performance and unlimited customization possibilities.


## 1. Theme Features

- Fully responsive, mobile-first design with HTML5 & CSS3
- Bootstrap 5.3.8 framework with custom theme overrides
- Font Awesome 6.4.0 icon library
- Advanced customization with Theme Customizer API
- Multiple blog layouts for flexible content presentation
- Unlimited color schemes with built-in color customizer
- 8 custom widgets for extended functionality
- Multi-language support with Polylang plugin
- Plugin compatibility:
  - bbPress for forum functionality
  - WooCommerce for e-commerce
  - Contact Form 7 for contact forms
- SEO-optimized with proper semantic HTML structure
- Ready for translations with .mo/.po files included
- Dark mode support
- Fast asset loading with Vite build system

## 2. Technical Documentation

Detailed technical specifications and development guides are available in the ./docs directory:
- Core Theme Specs: Architecture, Hook System, Asset Management, Customizer, and more.
- Docker Documentation: Stack overview and usage guides for development.

## 3. Compatible Plugins

- Forum: bbPress (https://wordpress.org/plugins/bbpress/)
- Contact Form: Contact Form 7 (https://wordpress.org/plugins/contact-form-7/)
- Multi-language: Polylang (https://wordpress.org/plugins/polylang/)
- E-commerce: WooCommerce (https://wordpress.org/plugins/woocommerce/)

## 4. Support

Get free support with tickets on GitHub: https://github.com/calm-canvas/origamiez-premium-free

## 5. Version History

### 4.4.2 (2026/03/25)

- Refactor: Customizer helpers, InlineStyleGenerator, shared template parts; widget registration via WidgetFactory
- Quality: ESLint es2020, globalThis in JS; PHP cleanup
- Chore: Sonar scannerwork / gitignore
- Security: NOSONAR on intentional security hook
- Update: Customizer → Site Editor migration target version is 4.4.2 (`GlobalStylesCustomizerMigrator::MIGRATION_TARGET_VERSION`); filter `origamiez_global_styles_migration_target_version`

### 4.4.1 (2026/03/22)

- Security: CSP worker-src; improved img-src (site host http/https, uploads/CDN origins)
- Styles: image height auto; hover and border tweaks; remove commented CSS
- Refactor: GlobalStylesThemeJsonMerger; template-part constants; widgets and migrator cleanup
- Quality: JS parseInt radix; accessibility and require_once fixes
- Update: Customizer → Site Editor migration target version is 4.4.1 (`GlobalStylesCustomizerMigrator::MIGRATION_TARGET_VERSION`); filter `origamiez_global_styles_migration_target_version`

### 4.4.0 (2026/03/21)

- Update: Customizer → Site Editor global styles migration runs only when the Origamiez engine theme Version is 4.4.0 (`GlobalStylesCustomizerMigrator::MIGRATION_TARGET_VERSION`); filter `origamiez_global_styles_migration_target_version`

### 4.3.1 (2026/03/20)

- New: Site Editor–first appearance pipeline (theme.json palette expansion, migration to user global styles, ThemeJsonAppearanceBridge)
- New: Customizer Colors / Typography / Google fonts panels show Site Editor notice; see theme docs for migration spec
- Update: Google Fonts enqueued via StylesheetManager only
- Breaking: Removed unused global Customizer callbacks origamiez_skin_custom_callback and origamiez_font_* from inc/customizer-callbacks.php

### 4.0.0 (2026/03/15)

- New: Optimized and refactored Docker stack for better development environment
- New: Integrate ESLint and Prettier with @wordpress/eslint-plugin and @wordpress/prettier-config
- Update: Modernize build system and asset management
- Update: Tested and updated for WordPress 6.9.0 and PHP 8.3 compatibility
- Improve: Added init.sh for streamlined environment initialization
- Improve: Updated theme metadata and refined tags in style.css

### 3.1.0 (2026-02-25)

- Improve: Refactor Docker configuration using YAML extensions (x-common and x-environment)
- New: Add scheduler service using Ofelia for automated WP-Cron task execution
- Update: Enhance cli and wordpress services with shared environment and volume configurations
- Update: Docker image updated to php8.3-apache

### 3.0.0 (2025-12-03)

- New: Migrate build system from Laravel Mix to Vite for faster development and better performance
- New: Refactor SCSS architecture with improved imports and organization
- Update: Bootstrap from v3 to v5.3.0 with custom overrides
- Update: Font Awesome from v4 to v6.4.0
- Update: Enhance typography and color variables system
- Improve: Modernize menu styles and interactions
- Improve: Refactor code structure for better readability and maintainability
- Improve: Update Docker configuration to WordPress 6.8 with PHP 8.4
- Improve: Consolidate plugin styles for bbPress and WooCommerce
- Update: All dependencies to latest stable versions

### 2.2.0 (2023-08-20)

- Fix responsive & mobile menu
- Update: Third party libraries and jQuery plugins to latest versions

### 2.x Versions (2023 and earlier)

Includes versions 2.2.0, 2.1.x, 2.0.x with continuous improvements to plugin compatibility, responsive design, and theme customization options.

### 1.3.5 - 1.3.0 (2017 - 2015)

- Major improvements to widget options and language support
- Enhanced typography and customization API integration
- WordPress 4.4-4.7 compatibility updates

### 1.2.9 - 1.2.0 (2015)

- Fixed critical layout issues with widget "Posts Grid"
- Added custom fonts, new page templates, and footer customization
- Improved gallery styling and mobile responsiveness

### 1.1.9 - 1.1.0 (2015)

- WooCommerce plugin compatibility
- New custom widgets and sidebar layouts
- Customizer features for single post and blog layouts
- Theme Customization API implementation

### 1.0.9 - 1.0.0 (2015)

- Initial releases with core theme functionality
- Bootstrap 3 and Font Awesome 4 integration
- Option Tree plugin and custom post format support
- Foundation for responsive design and widget system

## 6. Sources and Credits

### Images

Demo images are sourced from Gratisography (https://gratisography.com/), a free stock photo library offering high-quality images under the Gratisography License.

### Stylesheets & Scripts

Built with modern development tools and open-source libraries:

- Bootstrap: v5.3.8
  - http://getbootstrap.com
  - Licensed under MIT

- Font Awesome: v6.4.0
  - https://fontawesome.com
  - Licensed under MIT

- Owl Carousel: v2.3.4
  - Licensed under MIT

- Superfish: v1.7.10
  - jQuery plugin for dropdown menus
  - Licensed under MIT

- jQuery Poptrox
  - Lightweight media viewer
  - Licensed under MIT

- FitVids: v2.1.1
  - Responsive video embeds
  - Licensed under WTFPL

- jQuery Match Height: v0.7.2
  - Equal height matching for elements
  - Licensed under MIT

- Popper.js: v2.11.7
  - Positioning engine
  - Licensed under MIT

- Vite: v5.0.0
  - Modern build tool and development server
  - Licensed under MIT

## 7. Limitations

Footer menu does not support multi-level dropdown menus.

---

We appreciate your trust in choosing Origamiez for your projects. Happy creating!

**— Tran The Thang**
