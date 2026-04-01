# Post Features

## Description
The Origamiez theme provides a robust set of features for enhancing post display, including support for standard WordPress post formats (Gallery, Video, Audio), dynamic CSS classes, and contextual metadata. These features are managed through specialized managers that provide consistent formatting and layout across different post types.

## Core Architecture
- **Main Classes**: 
    - `Origamiez\Post\PostClassManager` (`origamiez/app/Post/PostClassManager.php`)
    - `Origamiez\Post\PostFormatter` (`origamiez/app/Post/PostFormatter.php`)
    - `Origamiez\Post\MetadataManager` (`origamiez/app/Post/MetadataManager.php`)
- **Dependencies**: 
    - `PostIconFactory`: Generates FontAwesome icons based on the current post format.
- **Patterns Used**: 
    - **Formatter Pattern**: `PostFormatter` encapsulates the logic for styling different post formats.
    - **Factory Pattern**: `PostIconFactory` creates icon elements based on format input.
    - **Observer (Hooks)**: `PostClassManager` hooks into `post_class` to inject theme-specific classes.

## Implementation Details
- **Dynamic Post Classes**: 
    - `PostClassManager` adds classes like `origamiez-post`, `origamiez-post-[format]`, and `origamiez-has-thumbnail` to the standard WordPress `post_class()` output.
- **Post Formats Support**: 
    - `PostFormatter` provides helper methods to extract specific content from post formats (e.g., the first video URL or the first gallery image).
    - It ensures that content is correctly presented based on whether the post is a `standard`, `gallery`, `video`, or `audio` type.
- **Metadata Management**: 
    - `MetadataManager` centralizes the generation of post metadata blocks (date, author, categories, tags, comments count).
- **Key Functions/Methods**:
    - `PostClassManager::get_post_classes(classes)`: Injects theme-specific post classes.
    - `PostFormatter::format_content(content)`: Tailors post content based on the assigned format.
    - `PostIconFactory::create(format)`: Returns the appropriate FontAwesome icon string for a given format.
- **Related posts query (legacy helpers)**:
    - Single-post “related posts” blocks use `WP_Query` arguments built in `origamiez/inc/misc-helpers.php`.
    - `origamiez_resolve_related_post_id( $post_id )`: resolves the effective post ID (explicit ID or global `$post`).
    - `origamiez_related_posts_tax_query_for_tags( $resolved_id )` and `origamiez_related_posts_tax_query_for_categories( $resolved_id )`: return `tax_query` clause sets for tags or categories, or `null` when none apply.
    - `origamiez_get_related_posts_query_args( $post_id, $default_count )`: assembles final query args using Customizer mods `get_related_post_by` and `number_of_related_posts`, excluding the current post.

## Maintenance & Development
- **Customizing Post Icons**: 
    - Modify the mapping in `PostIconFactory.php` to change which FontAwesome icons represent each post format.
- **Adding a New Metadata Block**: 
    - Define the metadata logic in `MetadataManager.php` and call it from the corresponding template part in `parts/metadata/`.
- **Common Issues**: 
    - **Post Class Conflicts**: Ensure that new classes added to the `post_class` filter do not conflict with core WordPress or plugin classes.

## Related Files
- `origamiez/app/Post/` (Directory)
- `origamiez/inc/misc-helpers.php` (Related posts query helpers; shared utilities)
- `origamiez/parts/metadata/` (Directory)
- `origamiez/content.php` (Where post classes and formats are applied)
