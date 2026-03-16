# Template System

## Description
The Origamiez theme utilizes a modular and structured template system, extending the core WordPress template hierarchy. By breaking down complex templates into granular "Template Parts," the theme achieves high code reusability, easier maintenance, and flexible layout configurations.

## Core Architecture
- **Main Files**: 
    - `index.php`, `single.php`, `page.php`, `archive.php`: Standard WordPress entry points.
    - `header.php`, `footer.php`: Global wrappers.
- **Dependencies**: 
    - `get_template_part()`: WordPress function used extensively to load modular parts.
    - `parts/` (Directory): Central location for all modular template fragments.
- **Patterns Used**: 
    - **Atomic Design Principles**: Large templates are composed of smaller, reusable atoms and molecules located in the `parts/` directory.
    - **Contextual Loading**: Template parts are often loaded based on the current theme settings (e.g., choosing between different header layouts).

## Implementation Details
- **Template Parts Structure**: 
    - `parts/header/`: Contains header layout variations (e.g., `header-left-right.php`).
    - `parts/archive/`: Layouts for archive pages (e.g., `archive-two-cols.php`).
    - `parts/metadata/`: Components for post metadata (date, author, category).
    - `parts/single/`: Post-specific elements like author info, tags, and related posts.
    - `parts/widgets/`: Front-end HTML templates for custom theme widgets.
    - `parts/sidebar-*.php`: Individual sidebar templates moved from the root to `parts/`.
    - `parts/footer-*.php`: Footer layout variations moved from the root to `parts/`.
- **Layout Selection**: The theme uses Customizer settings to determine which template parts to load. Root template files (like `header.php`, `footer.php`, `sidebar.php`) act as entry points that dynamically load the appropriate part from the `parts/` directory based on theme configurations.
- **Key Functions/Methods**:
    - `get_template_part('parts/folder/file')`: Standard method for including modular components.
    - `\Origamiez\Helpers\LayoutHelper::get_wrap_classes()`: Helper to get consistent container classes.

## Maintenance & Development
- **Customizing a Component**: 
    - Locate the specific component in the `parts/` directory and modify its HTML/PHP.
    - To override a part without changing the original, use a WordPress child theme.
- **Adding a New Layout**: 
    - Create a new file in the appropriate `parts/` sub-directory.
    - Add a new option in the Customizer to allow the user to select this layout.
    - Update the entry point file to respect the new Customizer choice.

## Related Files
- `origamiez/parts/` (Directory)
- `origamiez/header.php`
- `origamiez/footer.php`
- `origamiez/sidebar.php`
- `origamiez/index.php`
- `origamiez/archive.php`
- `origamiez/single.php`
