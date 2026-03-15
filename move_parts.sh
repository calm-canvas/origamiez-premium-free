#!/bin/bash
cd origamiez

# Move files
find . -maxdepth 1 \( -name "sidebar-*.php" -o -name "header-*.php" -o -name "footer-*.php" \) -not -name "sidebar.php" -exec mv {} parts/ \;

# Replace get_sidebar('...') with get_template_part('parts/sidebar', '...')
find . -name "*.php" -type f -exec sed -i '' "s/get_sidebar( '\([^']*\)' )/get_template_part( 'parts\/sidebar', '\1' )/g" {} +
find . -name "*.php" -type f -exec sed -i '' "s/get_sidebar( \"\([^\"]*\)\" )/get_template_part( 'parts\/sidebar', '\1' )/g" {} +

# We also need to fix occurrences like get_template_part( 'sidebar-right' )
find . -name "*.php" -type f -exec sed -i '' "s/get_template_part( 'sidebar-\([^']*\)' )/get_template_part( 'parts\/sidebar', '\1' )/g" {} +

