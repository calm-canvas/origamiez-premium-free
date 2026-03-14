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
    - `parts/header/`: Contains different header layout variations (e.g., `header-left-right.php`).
    - `parts/archive/`: Layouts for archive pages (e.g., `archive-two-cols.php`).
    - `parts/metadata/`: Small components for post metadata (date, author, category).
    - `parts/single/`: Post-specific elements like author info, tags, and related posts.
    - `parts/widgets/`: Front-end HTML templates for the custom theme widgets.
- **Layout Selection**: The theme uses Customizer settings to determine which specific template parts to load. For example, `header.php` may dynamically load a part from `parts/header/` based on the user's choice in the Customizer.
- **Key Functions/Methods**:
    - `get_template_part('parts/folder/file')`: Standard method for including modular components.
    - `origamiez_get_template_part()` (if used): A potential theme wrapper for the standard WordPress function that might pass context or data.

## Maintenance & Development
- **Customizing a Component**: 
    - Locate the specific component in the `parts/` directory and modify its HTML/PHP.
    - To override a part without changing the original, use a WordPress child theme.
- **Adding a New Layout**: 
    - Create a new file in the appropriate `parts/` sub-directory.
    - Add a new option in the Customizer to allow the user to select this layout.
    - Update the main template file (e.g., `archive.php`) to respect the new Customizer choice.
- **Common Issues**: 
    - **Missing Files**: Ensure that all `get_template_part` calls point to valid file paths within the theme directory.

## Related Files
- `origamiez/parts/` (Directory)
- `origamiez/header.php`
- `origamiez/footer.php`
- `origamiez/index.php`
- `origamiez/archive.php`
- `origamiez/single.php`
