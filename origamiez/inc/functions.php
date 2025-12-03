<?php
function origamiez_enqueue_scripts()
{
    global $is_IE;
    $dir = get_template_directory_uri();
    /**
     * --------------------------------------------------
     * STYLESHEETS
     * --------------------------------------------------
     */
    // LIBS.
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'font-awesome', "$dir/css/fontawesome.css", array(), null);
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'jquery-owl-carousel', "$dir/css/owl.carousel.css", array(), null);
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'jquery-owl-theme', "$dir/css/owl.theme.default.css", array(), null);
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'jquery-superfish', "$dir/css/superfish.css", array(), null);
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'jquery-navgoco', "$dir/css/jquery.navgoco.css", array(), null);    
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'jquery-poptrox', "$dir/css/jquery.poptrox.css", array(), null);
    // STYLE.
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'style', get_stylesheet_uri(), array(), null);
    // RESPONSIVE.
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'responsive', "$dir/css/responsive.css", array(), null);
    // CUSTOM COLOR WITH CSS VARIABLES.
    $skin = get_theme_mod('skin', 'default');
    if ('custom' === $skin) {
        $css_variables = ':root {';
        $css_variables .= '--body-color: ' . get_theme_mod('body_color', '#666666') . ';';
        $css_variables .= '--heading-color: ' . get_theme_mod('heading_color', '#333333') . ';';
        $css_variables .= '--link-color: ' . get_theme_mod('link_color', '#333333') . ';';
        $css_variables .= '--link-hover-color: ' . get_theme_mod('link_hover_color', '#E74C3C') . ';';
        $css_variables .= '--primary-color: ' . get_theme_mod('primary_color', '#E74C3C') . ';';
        $css_variables .= '--secondary-color: ' . get_theme_mod('secondary_color', '#F9F9F9') . ';';
        $css_variables .= '--main-menu-color: ' . get_theme_mod('main_menu_color', '#666666') . ';';
        $css_variables .= '--line-1-color: ' . get_theme_mod('line_1_color', '#555555') . ';';
        $css_variables .= '--line-2-color: ' . get_theme_mod('line_2_color', '#DDDDDD') . ';';
        $css_variables .= '--line-3-color: ' . get_theme_mod('line_3_color', '#E5E5E5') . ';';
        $css_variables .= '--footer-sidebars-bg-color: ' . get_theme_mod('footer_sidebars_bg_color', '#293535') . ';';
        $css_variables .= '--footer-sidebars-text-color: ' . get_theme_mod('footer_sidebars_text_color', '#999999') . ';';
        $css_variables .= '--footer-widget-title-color: ' . get_theme_mod('footer_widget_title_color', '#FFFFFF') . ';';
        $css_variables .= '--footer-info-bg-color: ' . get_theme_mod('footer_info_bg_color', '#111111') . ';';
        $css_variables .= '--footer-info-text-color: ' . get_theme_mod('footer_info_text_color', '#999999') . ';';
        $css_variables .= '--white: #FFFFFF;';
        $css_variables .= '--black: #000000;';
        $css_variables .= '--black-light: #DFDFDF;';
        $css_variables .= '--overlay-white: rgba(255, 255, 255, 0.5);';
        $css_variables .= '--overlay-black: rgba(0, 0, 0, 0.5);';
        $css_variables .= '--facebook-color: #3B5998;';
        $css_variables .= '--twitter-color: #00A0D1;';
        $css_variables .= '--google-plus-color: #C63D2D;';
        $css_variables .= '--pinterest-color: #910101;';
        $css_variables .= '--rss-color: #FA9B39;';
        $css_variables .= '--metadata-color: #777777;';
        $css_variables .= '}';
        wp_add_inline_style(ORIGAMIEZ_PREFIX . 'style', $css_variables);
    }
    // GOOGLE FONT.
    if ('off' !== _x('on', 'Google font: on or off', 'origamiez')) {
        $google_fonts_url = add_query_arg('family', urlencode('Roboto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap|Neuton:ital,wght@0,400;0,700;1,400&display=swap'), '//fonts.googleapis.com/css');
        wp_enqueue_style(ORIGAMIEZ_PREFIX . 'google-fonts', $google_fonts_url);
    }
    // DYNAMIC FONT.
    $font_groups = array();
    $number_of_google_fonts = (int)apply_filters('origamiez_get_number_of_google_fonts', 3);
    if ($number_of_google_fonts) {
        for ($i = 0; $i < $number_of_google_fonts; $i++) {
            $font_family = get_theme_mod(sprintf('google_font_%s_name', $i), '');
            $font_src = get_theme_mod(sprintf('google_font_%s_src', $i), '');
            if ($font_family && $font_src) {
                $font_family_slug = origamiez_get_str_uglify($font_family);
                $font_groups['dynamic'][$font_family_slug] = $font_src;
            }
        }
    }
    foreach ($font_groups as $font_group) {
        if ($font_group) {
            foreach ($font_group as $font_slug => $font) {
                wp_enqueue_style(ORIGAMIEZ_PREFIX . $font_slug, $font, array(), null);
            }
        }
    }
    $typography_path = sprintf('%s/typography/default.css', get_stylesheet_directory());
    $typography_src = "$dir/typography/default.css";
    if (file_exists($typography_path)) {
        $typography_src = sprintf('%s/typography/default.css', get_stylesheet_directory_uri());
    }
    wp_enqueue_style(ORIGAMIEZ_PREFIX . 'typography', $typography_src, array(), null);
    /**
     * --------------------------------------------------
     * SCRIPTS.
     * --------------------------------------------------
     */
    if (is_singular()) {
        wp_enqueue_script('comment-reply');
    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('hoverIntent');
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'modernizr', "$dir/js/modernizr.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'bootstrap', "$dir/js/bootstrap.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-easing', "$dir/js/jquery.easing.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-fitvids', "$dir/js/jquery.fitvids.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-navgoco', "$dir/js/jquery.navgoco.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-poptrox', "$dir/js/jquery.poptrox.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-transit', "$dir/js/jquery.transit.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-owl-carousel', "$dir/js/owl.carousel.js", array('jquery'), null, true);    
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'jquery-superfish', "$dir/js/superfish.js", array('jquery'), null, true);
    wp_enqueue_script(ORIGAMIEZ_PREFIX . 'origamiez-init', "$dir/js/script.js", array('jquery'), null, true);
    wp_localize_script(ORIGAMIEZ_PREFIX . 'origamiez-init', 'origamiez_vars', apply_filters('get_origamiez_vars', array(
        'info' => array(
            'home_url' => esc_url(home_url()),
            'template_uri' => get_template_directory_uri(),
            'affix' => '',
        ),
        'config' => array(
            'is_enable_lightbox' => (int)get_theme_mod('is_enable_lightbox', 1),
            'is_enable_convert_flat_menus' => (int)get_theme_mod('is_enable_convert_flat_menus', 1),
            'is_use_gallery_popup' => (int)get_theme_mod('is_use_gallery_popup', 1),
        ),
    )));
    /**
     * --------------------------------------------------
     * IE FIX.
     * --------------------------------------------------
     */
    if ($is_IE) {
        wp_enqueue_script(ORIGAMIEZ_PREFIX . 'html5', "$dir/js/html5shiv.js", array(), null, true);
        wp_enqueue_script(ORIGAMIEZ_PREFIX . 'respond', "$dir/js/respond.js", array(), null, true);
    }
    /*
    * --------------------------------------------------
    * CUSTOM FONT.
    * --------------------------------------------------
    */
    $rules = array(
        'family' => 'font-family',
        'size' => 'font-size',
        'style' => 'font-style',
        'weight' => 'font-weight',
        'line_height' => 'line-height',
    );
    $font_objects = array(
        'font_body' => 'body',
        'font_menu' => '#main-menu a',
        'font_site_title' => '#site-home-link #site-title',
        'font_site_subtitle' => '#site-home-link #site-desc',
        'font_widget_title' => 'h2.widget-title',
        'font_h1' => 'h1',
        'font_h2' => 'h2',
        'font_h3' => 'h3',
        'font_h4' => 'h4',
        'font_h5' => 'h5',
        'font_h6' => 'h6',
    );
    foreach ($font_objects as $font_object_slug => $font_object) {
        $is_enable = (int)get_theme_mod("{$font_object_slug}_is_enable", 0);
        if ($is_enable) {
            foreach ($rules as $rule_slug => $rule) {
                $font_data = get_theme_mod("{$font_object_slug}_{$rule_slug}");
                if (!empty($font_data)) {
                    $tmp = sprintf('%s {%s: %s;}', $font_object, $rule, $font_data);
                    wp_add_inline_style(ORIGAMIEZ_PREFIX . 'typography', $tmp);
                }
            }
        }
    }
    /*
    * --------------------------------------------------
    * CUSTOM CSS.
    * --------------------------------------------------
    */
    $css = wp_kses(get_theme_mod('custom_css'), origamiez_get_allowed_tags());
    if (!empty($css)) {
        wp_add_inline_style(ORIGAMIEZ_PREFIX . 'style', $css);
    }
}

function origamiez_body_class($classes)
{
    if (is_single()) {
        array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single');
        if (1 === (int)get_theme_mod('is_show_border_for_images', 1)) {
            $classes[] = 'origamiez-show-border-for-images';
        }
    } else if (is_page()) {
        if (in_array(basename(get_page_template()), array(
            'template-page-fullwidth-centered.php',
            'template-page-fullwidth.php'
        ), true)) {
            array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single', 'origamiez-layout-full-width');
        } else if ('template-page-magazine.php' === basename(get_page_template())) {
            array_push($classes, 'origamiez-page-magazine', 'origamiez-layout-right-sidebar', 'origamiez-layout-single', 'origamiez-layout-full-width');
            $sidebar_right = apply_filters('origamiez_get_current_sidebar', 'right', 'right');
            if (!is_active_sidebar($sidebar_right)) {
                $classes[] = 'origamiez-missing-sidebar-right';
            }
        } else {
            array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single', 'origamiez-layout-static-page');
        }
    } else if (is_archive() || is_home()) {
        array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-blog');
        switch (get_theme_mod('taxonomy_thumbnail_style', 'thumbnail-left')) {
            case 'thumbnail-right':
                $classes[] = 'origamiez-layout-blog-thumbnail-right';
                break;
            case 'thumbnail-full-width':
                $classes[] = 'origamiez-layout-blog-thumbnail-full-width';
                break;
            default:
                $classes[] = 'origamiez-layout-blog-thumbnail-left';
                break;
        }
        if (is_home() || is_tag() || is_category() || is_author() || is_day() || is_month() || is_year()) {
            $taxonomy_layout = get_theme_mod('taxonomy_layout', 'two-cols');
            if ($taxonomy_layout) {
                $classes[] = "origamiez-taxonomy-{$taxonomy_layout}";
            }
        }
    } elseif (is_search()) {
        array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-blog');
    } else if (is_404()) {
        array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single', 'origamiez-layout-full-width');
    }
    $bg_image = get_background_image();
    $bg_color = get_background_color();
    if ($bg_image || $bg_color) {
        $classes[] = 'origamiez_custom_bg';
    } else {
        $classes[] = 'without_bg_slides';
    }
    if (1 !== (int)get_theme_mod('use_layout_fullwidth', '0')) {
        $classes[] = 'origamiez-boxer';
    } else {
        $classes[] = 'origamiez-fluid';
    }
    if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') || is_active_sidebar('footer-5')) {
        $classes[] = 'origamiez-show-footer-area';
    }
    $skin = get_theme_mod('skin', 'default');
    if ($skin) {
        $classes[] = sprintf('origamiez-skin-%s', $skin);
    }
    $header_style = get_theme_mod('header_style', 'left-right');
    if ($header_style) {
        $classes[] = sprintf('origamiez-header-style-%s', $header_style);
    }
    if (is_single()) {
        $single_post_layout = get_theme_mod('single-post-layout', 'two-cols');
        $classes[] = "origamiez-single-post-{$single_post_layout}";
    }
    if (is_home() || is_archive() || is_single()) {
        $sidebar_right = apply_filters('origamiez_get_current_sidebar', 'right', 'right');
        if (!is_active_sidebar($sidebar_right)) {
            $classes[] = 'origamiez-missing-sidebar-right';
        }
        $sidebar_left = apply_filters('origamiez_get_current_sidebar', 'left', 'left');
        if (!is_active_sidebar($sidebar_left)) {
            $classes[] = 'origamiez-missing-sidebar-left';
        }
    }

    return $classes;
}

function origamiez_global_wapper_open()
{
    if (1 !== (int)get_theme_mod('use_layout_fullwidth', 0)) {
        echo '<div class="container">';
    }
}

function origamiez_global_wapper_close()
{
    if (1 !== (int)get_theme_mod('use_layout_fullwidth', 0)) {
        echo '<div class="close">';
    }
}

function origamiez_archive_post_class($classes)
{
    global $wp_query;
    if (0 === $wp_query->current_post) {
        $classes[] = 'origamiez-first-post';
    }

    return $classes;
}

function origamiez_get_format_icon($format)
{
    if ($format == 'video') {
        $icon = 'fa fa-play';
    } elseif ($format == 'audio') {
        $icon = 'fa fa-headphones';
    } elseif ($format == 'image') {
        $icon = 'fa fa-camera';
    } elseif ($format == 'gallery') {
        $icon = 'fa fa-picture-o';
    } else {
        $icon = 'fa fa-pencil';
    }

    return apply_filters('origamiez_get_format_icon', $icon, $format);
}

function origamiez_get_shortcode($content, $shortcodes = array(), $enable_multi = false)
{
    $data = array();
    $regex_matches = '';
    $regex_pattern = get_shortcode_regex();
    preg_match_all('/' . $regex_pattern . '/s', $content, $regex_matches);
    foreach ($regex_matches[0] as $shortcode) {
        $regex_matches_new = '';
        preg_match('/' . $regex_pattern . '/s', $shortcode, $regex_matches_new);
        if (in_array($regex_matches_new[2], $shortcodes, true)) :
            $data[] = array(
                'shortcode' => $regex_matches_new[0],
                'type' => $regex_matches_new[2],
                'content' => $regex_matches_new[5],
                'atts' => shortcode_parse_atts($regex_matches_new[3]),
            );
            if (false === $enable_multi) {
                break;
            }
        endif;
    }

    return $data;
}

function origamiez_human_time_diff($from)
{
    $periods = array(
        esc_attr__('second', 'origamiez'),
        esc_attr__('minute', 'origamiez'),
        esc_attr__('hour', 'origamiez'),
        esc_attr__('day', 'origamiez'),
        esc_attr__('week', 'origamiez'),
        esc_attr__('month', 'origamiez'),
        esc_attr__('year', 'origamiez'),
        esc_attr__('decade', 'origamiez'),
    );
    $lengths = array('60', '60', '24', '7', '4.35', '12', '10');
    $now = current_time('timestamp');
    // Determine tense of date.
    if ($now > $from) {
        $difference = $now - $from;
        $tense = esc_attr__('ago', 'origamiez');
    } else {
        $difference = $from - $now;
        $tense = esc_attr__('from now', 'origamiez');
    }
    for ($j = 0; ($difference >= $lengths[$j] && $j < count($lengths) - 1); $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if (1 !== $difference) {
        $periods[$j] .= esc_attr__('s', 'origamiez');
    }

    return "$difference $periods[$j] {$tense}";
}

function origamiez_get_breadcrumb()
{
    global $post, $wp_query;
    $current_class = 'current-page';
    $prefix = '&nbsp;&rsaquo;&nbsp;';
    $breadcrumb_before = '<div class="breadcrumb">';
    $breadcrumb_after = '</div>';
    $breadcrumb_home = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url(home_url()) . '" itemprop="url"><span itemprop="title">' . esc_attr__('Home', 'origamiez') . '</span></a></span>';
    $breadcrumb = $breadcrumb_home;
    if (is_archive()) {
        if (is_tag()) {
            $term = get_term(get_queried_object_id(), 'post_tag');
            $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, $term->name);
        } else if (is_category()) {
            $terms_link = explode($prefix, substr(get_category_parents(get_queried_object_id(), true, $prefix), 0, (strlen($prefix) * -1)));
            $n = count($terms_link);
            if ($n > 1) {
                for ($i = 0; $i < ($n - 1); $i++) {
                    $breadcrumb .= $prefix . $terms_link[$i];
                }
            }
            $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_category_by_ID(get_queried_object_id()));
        } else if (is_year() || is_month() || is_day()) {
            $m = get_query_var('m');
            $date = array('y' => null, 'm' => null, 'd' => null);
            if (strlen($m) >= 4) {
                $date['y'] = substr($m, 0, 4);
            }
            if (strlen($m) >= 6) {
                $date['m'] = substr($m, 4, 2);
            }
            if (strlen($m) >= 8) {
                $date['d'] = substr($m, 6, 2);
            }
            if ($date['y']) {
                if (is_year()) {
                    $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, $date['y']);
                }
            } else {
                $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_year_link($date['y']), $date['y']);
            }
            if ($date['m']) {
                if (is_month()) {
                    $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, date('F', mktime(0, 0, 0, $date['m'])));
                }
            } else {
                $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_month_link($date['y'], $date['m']), date('F', mktime(0, 0, 0, $date['m'])));
            }
            if ($date['d']) {
                if (is_day()) {
                    $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, $date['d']);
                }
            } else {
                $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_day_link($date['y'], $date['m'], $date['d']), $date['d']);
            }
        } else if (is_author()) {
            $author_id = get_queried_object_id();
            $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, sprintf(esc_attr__('Posts created by %1$s', 'origamiez'), get_the_author_meta('display_name', $author_id)));
        }
    } else if (is_search()) {
        $s = get_search_query();
        $c = $wp_query->found_posts;
        $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, sprintf(esc_attr__('Searched for "%s" return %s results', 'origamiez'), $s, $c));
    } else if (is_singular()) {
        if (is_page()) {
            $post_ancestors = get_post_ancestors($post);
            if ($post_ancestors) {
                $post_ancestors = array_reverse($post_ancestors);
                foreach ($post_ancestors as $crumb) {
                    $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_permalink($crumb), esc_html(get_the_title($crumb)));
                }
            }
            $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url" href="%2$s"><span itemprop="title">%3$s</span></a></span>', $current_class, get_permalink(get_queried_object_id()), esc_html(get_the_title(get_queried_object_id())));
        } else if (is_single()) {
            $categories = get_the_category(get_queried_object_id());
            if ($categories) {
                foreach ($categories as $category) {
                    $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_category_link($category->term_id), $category->name);
                }
            }
            $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url" href="%2$s"><span itemprop="title">%3$s</span></a></span>', $current_class, get_permalink(get_queried_object_id()), esc_html(get_the_title(get_queried_object_id())));
        }
    } else if (is_404()) {
        $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, esc_attr__('Page not found', 'origamiez'));
    } else {
        $breadcrumb .= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, esc_attr__('Latest News', 'origamiez'));
    }
    echo wp_kses($breadcrumb_before, origamiez_get_allowed_tags());
    echo wp_kses(apply_filters('origamiez_get_breadcrumb', $breadcrumb, $current_class, $prefix), origamiez_get_allowed_tags());
    echo wp_kses($breadcrumb_after, origamiez_get_allowed_tags());
}

function origamiez_get_author_infor()
{
    global $post;
    $user_id = $post->post_author;
    $description = get_the_author_meta('description', $user_id);
    $email = get_the_author_meta('user_email', $user_id);
    $name = get_the_author_meta('display_name', $user_id);
    $url = trim(get_the_author_meta('user_url', $user_id));
    $link = !$url ? get_author_posts_url($user_id) : $url;
    ?>
    <div id="origamiez-post-author">
        <div class="origamiez-author-info clearfix">
            <a href="<?php echo esc_url($link); ?>" class="origamiez-author-avatar">
                <?php echo wp_kses(get_avatar($email, 90), origamiez_get_allowed_tags()); ?>
            </a>
            <div class="origamiez-author-detail">
                <p class="origamiez-author-name"><?php esc_html_e('Author:', 'origamiez'); ?>&nbsp;<a
                            href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a></p>
                <p class="origamiez-author-bio"><?php echo wp_kses($description, origamiez_get_allowed_tags()); ?></p>
            </div>
        </div>
    </div>
    <?php
}

function origamiez_list_comments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    <article class="comment-body clearfix" id="div-comment-23">
        <span class="comment-avatar pull-left"><?php echo wp_kses_post( get_avatar($comment->comment_author_email, $args['avatar_size']) ); ?></span>
        <footer class="comment-meta">
            <div class="comment-author vcard">
                <span class="fn"><?php comment_author_link(); ?></span>
            </div><!-- .comment-author -->
            <div class="comment-metadata">
                <span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>
                <a href="#"><?php comment_time(get_option('date_format') . ' - ' . get_option('time_format')); ?></a>
                <?php comment_reply_link(array_merge($args, array(
                    'before' => '<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>&nbsp;',
                    'depth' => $depth,
                    'max_depth' => $args['max_depth']
                ))); ?>
                <?php edit_comment_link(esc_attr__('Edit', 'origamiez'), '<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>&nbsp;', ''); ?>
            </div><!-- .comment-metadata -->
        </footer><!-- .comment-meta -->
        <div class="comment-content">
            <?php comment_text(); ?>
        </div><!-- .comment-content -->
    </article><!-- .comment-body -->
    <?php
}

function origamiez_comment_form($args = array(), $post_id = null)
{
    if (null === $post_id) {
        $post_id = get_the_ID();
    }
    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';
    $args = wp_parse_args($args);
    if (!isset($args['format'])) {
        $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
    }
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $html5 = 'html5' === $args['format'];
    $fields = array();
    $fields['author'] = '<div class="comment-form-info row clearfix">';
    $fields['author'] .= '<div class="comment-form-field col-sm-4">';
    $fields['author'] .= '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />';
    $fields['author'] .= '<span class="comment-icon fa fa-user"></span>';
    $fields['author'] .= '</div>';
    $fields['email'] = '<div class="comment-form-field col-sm-4">';
    $fields['email'] .= '<input id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />';
    $fields['email'] .= '<span class="comment-icon fa fa-envelope"></span>';
    $fields['email'] .= '</div>';
    $fields['url'] = '<div class="comment-form-field col-sm-4">';
    $fields['url'] .= '<input id="url" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />';
    $fields['url'] .= '<span class="comment-icon fa fa-link"></span>';
    $fields['url'] .= '</div>';
    $fields['url'] .= '</div>';
    $fields = apply_filters('comment_form_default_fields', $fields);
    $comment_field = '<p class="comment-form-comment">';
    $comment_field .= '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>';
    $comment_field .= '</p>';
    $defaults = array(
        'fields' => $fields,
        'comment_field' => $comment_field,
        'must_log_in' => '<p class="must-log-in">' . sprintf(esc_html__('You must be <a href="%s">logged in</a> to post a comment.', 'origamiez'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'logged_in_as' => '<p class="logged-in-as">' . sprintf(esc_html__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'origamiez'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => esc_attr__('Leave a Reply', 'origamiez'),
        'title_reply_to' => esc_attr__('Leave a Reply to %s', 'origamiez'),
        'cancel_reply_link' => esc_attr__('Cancel reply', 'origamiez'),
        'label_submit' => esc_attr__('Post Comment', 'origamiez'),
        'format' => 'xhtml',
    );
    $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
    ?>
    <?php if (comments_open($post_id)) : ?>
    <?php
    do_action('comment_form_before');
    ?>
    <div class="comment-respond" id="respond">
        <h2 id="reply-title"
            class="comment-reply-title widget-title clearfix"><?php comment_form_title($args['title_reply'], $args['title_reply_to']); ?>
            <small><?php cancel_comment_reply_link($args['cancel_reply_link']); ?></small></h2>
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
            <?php echo wp_kses(htmlspecialchars_decode($args['must_log_in']), origamiez_get_allowed_tags()); ?>
            <?php
            do_action('comment_form_must_log_in_after');
            ?>
        <?php else : ?>
            <form action="<?php echo esc_url(home_url('/wp-comments-post.php')); ?>" method="post"
                  id="<?php echo esc_attr($args['id_form']); ?>"
                  class="comment-form origamiez-widget-content clearfix" <?php echo esc_attr($html5 ? ' novalidate' : ''); ?>>
                <?php do_action('comment_form_top'); ?>
                <?php if (is_user_logged_in()) : ?>
                    <?php echo wp_kses(htmlspecialchars_decode(apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity)), origamiez_get_allowed_tags()); ?>
                    <?php do_action('comment_form_logged_in_after', $commenter, $user_identity); ?>
                <?php else : ?>
                    <?php echo wp_kses($args['comment_notes_before'], origamiez_get_allowed_tags()); ?>
                    <?php
                    do_action('comment_form_before_fields');
                    foreach ((array)$args['fields'] as $name => $field) {
                        echo wp_kses(apply_filters("comment_form_field_{$name}", $field), origamiez_get_allowed_tags());
                    }
                    do_action('comment_form_after_fields');
                    ?>
                <?php endif; ?>
                <?php echo wp_kses(apply_filters('comment_form_field_comment', $args['comment_field']), origamiez_get_allowed_tags()); ?>
                <?php echo wp_kses($args['comment_notes_after'], origamiez_get_allowed_tags()); ?>
                <p class="form-submit">
                    <input name="submit" type="submit" id="<?php echo esc_attr($args['id_submit']); ?>"
                           value="<?php echo esc_attr($args['label_submit']); ?>"/>
                    <?php comment_id_fields($post_id); ?>
                </p>
                <?php do_action('comment_form', $post_id); ?>
            </form>
        <?php endif; ?>
    </div><!-- #respond -->
    <?php
    do_action('comment_form_after');
else :
    do_action('comment_form_comments_closed');
endif;
}

function origamiez_get_socials()
{
    return array(
        'behance' => array(
            'icon' => 'fa-brands fa-behance',
            'label' => esc_attr__('Behance', 'origamiez'),
            'color' => '',
        ),
        'bitbucket' => array(
            'icon' => 'fa-brands fa-bitbucket',
            'label' => esc_attr__('Bitbucket', 'origamiez'),
            'color' => '',
        ),
        'codepen' => array(
            'icon' => 'fa-brands fa-codepen',
            'label' => esc_attr__('Codepen', 'origamiez'),
            'color' => '',
        ),
        'delicious' => array(
            'icon' => 'fa-brands fa-delicious',
            'label' => esc_attr__('Delicious', 'origamiez'),
            'color' => '',
        ),
        'deviantart' => array(
            'icon' => 'fa-brands fa-deviantart',
            'label' => esc_attr__('Deviantart', 'origamiez'),
            'color' => '',
        ),
        'digg' => array(
            'icon' => 'fa-brands fa-digg',
            'label' => esc_attr__('Digg', 'origamiez'),
            'color' => '#1b5891',
        ),
        'dribbble' => array(
            'icon' => 'fa-brands fa-dribbble',
            'label' => esc_attr__('Dribbble', 'origamiez'),
            'color' => '',
        ),
        'dropbox' => array(
            'icon' => 'fa-brands fa-dropbox',
            'label' => esc_attr__('Dropbox', 'origamiez'),
            'color' => '',
        ),
        'facebook' => array(
            'icon' => 'fa-brands fa-facebook',
            'label' => esc_attr__('Facebook', 'origamiez'),
            'color' => '#3B5998',
        ),
        'flickr' => array(
            'icon' => 'fa-brands fa-flickr',
            'label' => esc_attr__('Flickr', 'origamiez'),
            'color' => '',
        ),
        'foursquare' => array(
            'icon' => 'fa-brands fa-foursquare',
            'label' => esc_attr__('Foursquare', 'origamiez'),
            'color' => '',
        ),
        'git' => array(
            'icon' => 'fa-brands fa-git',
            'label' => esc_attr__('Git', 'origamiez'),
            'color' => '',
        ),
        'github' => array(
            'icon' => 'fa-brands fa-github',
            'label' => esc_attr__('Github', 'origamiez'),
            'color' => '',
        ),
        'google-plus' => array(
            'icon' => 'fa-brands fa-google-plus',
            'label' => esc_attr__('Google plus', 'origamiez'),
            'color' => '#C63D2D',
        ),
        'instagram' => array(
            'icon' => 'fa-brands fa-instagram',
            'label' => esc_attr__('Instagram', 'origamiez'),
            'color' => '',
        ),
        'jsfiddle' => array(
            'icon' => 'fa-brands fa-jsfiddle',
            'label' => esc_attr__('JsFiddle', 'origamiez'),
            'color' => '#007bb6',
        ),
        'linkedin' => array(
            'icon' => 'fa-brands fa-linkedin',
            'label' => esc_attr__('linkedin', 'origamiez'),
            'color' => '#007bb6',
        ),
        'pinterest' => array(
            'icon' => 'fa-brands fa-pinterest',
            'label' => esc_attr__('Pinterest', 'origamiez'),
            'color' => '#910101',
        ),
        'reddit' => array(
            'icon' => 'fa-brands fa-reddit',
            'label' => esc_attr__('Reddit', 'origamiez'),
            'color' => '#ff1a00',
        ),
        'soundcloud' => array(
            'icon' => 'fa-brands fa-soundcloud',
            'label' => esc_attr__('Soundcloud', 'origamiez'),
            'color' => '',
        ),
        'spotify' => array(
            'icon' => 'fa-brands fa-spotify',
            'label' => esc_attr__('Spotify', 'origamiez'),
            'color' => '',
        ),
        'stack-exchange' => array(
            'icon' => 'fa-brands fa-stack-exchange',
            'label' => esc_attr__('Stack exchange', 'origamiez'),
            'color' => '',
        ),
        'stack-overflow' => array(
            'icon' => 'fa-brands fa-stack-overflow',
            'label' => esc_attr__('Stack overflow', 'origamiez'),
            'color' => '',
        ),
        'stumbleupon' => array(
            'icon' => 'fa-brands fa-stumbleupon',
            'label' => esc_attr__('Stumbleupon', 'origamiez'),
            'color' => '#EB4823',
        ),
        'tumblr' => array(
            'icon' => 'fa-brands fa-tumblr',
            'label' => esc_attr__('Tumblr', 'origamiez'),
            'color' => '#32506d',
        ),
        'twitter' => array(
            'icon' => 'fa-brands fa-twitter',
            'label' => esc_attr__('Twitter', 'origamiez'),
            'color' => '#00A0D1',
        ),
        'vimeo' => array(
            'icon' => 'fa-brands fa-vimeo-square',
            'label' => esc_attr__('Vimeo', 'origamiez'),
            'color' => '',
        ),
        'youtube' => array(
            'icon' => 'fa-brands fa-youtube',
            'label' => esc_attr__('Youtube', 'origamiez'),
            'color' => '#cc181e',
        ),
        'rss' => array(
            'icon' => 'fa-brands fa-rss',
            'label' => esc_attr__('Rss', 'origamiez'),
            'color' => '#FA9B39',
        ),
    );
}

function origamiez_get_wrap_classes()
{
    if (1 === (int)get_theme_mod('use_layout_fullwidth', 0)) {
        echo 'container';
    }
}

function origamiez_get_str_uglify($string)
{
    $string = preg_replace('/\s+/', ' ', $string);
    $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);

    return strtolower(str_replace(' ', '_', $string));
}

function origamiez_add_first_and_last_class_for_menuitem($items)
{
    $items[1]->classes[] = 'origamiez-menuitem-first';
    $items[count($items)]->classes[] = 'origamiez-menuitem-last';

    return $items;
}

function origamiez_widget_order_class()
{
    global $wp_registered_sidebars, $wp_registered_widgets;
    // Grab the widgets.
    $sidebars = wp_get_sidebars_widgets();
    if (empty($sidebars)) {
        return;
    }
    // Loop through each widget and change the class names.
    foreach ($sidebars as $sidebar_id => $widgets) {
        if (empty($widgets)) {
            continue;
        }
        $number_of_widgets = count($widgets);
        foreach ($widgets as $i => $widget_id) {
            if (isset($wp_registered_widgets[$widget_id]['classname'])) {
                $wp_registered_widgets[$widget_id]['classname'] .= ' origamiez-widget-order-' . $i;
                // Add first widget class.
                if (0 === $i) {
                    $wp_registered_widgets[$widget_id]['classname'] .= ' origamiez-widget-first';
                }
                // Add last widget class.
                if (($i + 1) === $number_of_widgets) {
                    $wp_registered_widgets[$widget_id]['classname'] .= ' origamiez-widget-last';
                }
            }
        }
    }
}

function origamiez_remove_hardcoded_image_size($html)
{
    return preg_replace('/(width|height)="\d+"\s/', '', $html);
}

function origamiez_register_new_image_sizes()
{
    add_image_size('origamiez-square-xs', 55, 55, true);
    add_image_size('origamiez-lightbox-full', 960, null);
    add_image_size('origamiez-blog-full', 920, 500, true);
    add_image_size('origamiez-square-m', 480, 480, true);
    add_image_size('origamiez-square-md', 480, 320, true);
    add_image_size('origamiez-posts-slide-metro', 620, 620, true);
    add_image_size('origamiez-grid-l', 380, 255, true);
}

function origamiez_get_image_src($post_id = 0, $size = 'thumbnail')
{
    $thumb = get_the_post_thumbnail($post_id, $size);
    if (!empty($thumb)) {
        $_thumb = array();
        $regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
        preg_match($regex, $thumb, $_thumb);
        $thumb = $_thumb[2];
    }

    return $thumb;
}

function origamiez_get_metadata_prefix($echo = true)
{
    $prefix = apply_filters('origamiez_get_metadata_prefix', '&horbar;');
    if ($echo) {
        echo $prefix ;
    } else {
        return $prefix;
    }
}

function origamiez_return_10()
{
    return 10;
}

function origamiez_return_15()
{
    return 15;
}

function origamiez_return_20()
{
    return 20;
}

function origamiez_return_30()
{
    return 30;
}

function origamiez_return_60()
{
    return 60;
}

function origamiez_set_classes_for_footer_three_cols($classes)
{
    return array('col-xs-12', 'col-sm-4', 'col-md-4');
}

function origamiez_set_classes_for_footer_two_cols($classes)
{
    return array('col-xs-12', 'col-sm-6', 'col-md-6');
}

function origamiez_set_classes_for_footer_one_cols($classes)
{
    return array('col-xs-12', 'col-sm-12', 'col-md-12');
}

function origamiez_get_allowed_tags()
{
    $allowed_tag = wp_kses_allowed_html('post');
    $allowed_tag['div']['data-place'] = array();
    $allowed_tag['div']['data-latitude'] = array();
    $allowed_tag['div']['data-longitude'] = array();
    $allowed_tag['iframe']['src'] = array();
    $allowed_tag['iframe']['height'] = array();
    $allowed_tag['iframe']['width'] = array();
    $allowed_tag['iframe']['frameborder'] = array();
    $allowed_tag['iframe']['allowfullscreen'] = array();
    $allowed_tag['input']['class'] = array();
    $allowed_tag['input']['id'] = array();
    $allowed_tag['input']['name'] = array();
    $allowed_tag['input']['value'] = array();
    $allowed_tag['input']['type'] = array();
    $allowed_tag['input']['checked'] = array();
    $allowed_tag['select']['class'] = array();
    $allowed_tag['select']['id'] = array();
    $allowed_tag['select']['name'] = array();
    $allowed_tag['select']['value'] = array();
    $allowed_tag['select']['type'] = array();
    $allowed_tag['option']['selected'] = array();
    $allowed_tag['style']['types'] = array();
    $microdata_tags = array(
        'div',
        'section',
        'article',
        'a',
        'span',
        'img',
        'time',
        'figure'
    );
    foreach ($microdata_tags as $tag) {
        $allowed_tag[$tag]['itemscope'] = array();
        $allowed_tag[$tag]['itemtype'] = array();
        $allowed_tag[$tag]['itemprop'] = array();
    }

    return apply_filters('origamiez_get_allowed_tags', $allowed_tag);
}

function origamiez_get_button_readmore()
{
    ?>
    <p class="origamiez-readmore-block">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="origamiez-readmore-button">
            <?php esc_html_e('Read more &raquo;', 'origamiez'); ?>
        </a>
    </p>
    <?php
}

function origamiez_save_unyson_options($option_key, $old_value, $new_value)
{
    if ('fw_theme_settings_options:origamiez' === $option_key) {
        if (is_array($old_value) && is_array($new_value)) {
            foreach ($new_value as $key => $value) {
                if ($key == 'logo') {
                    if (isset($value['url']) && isset($value['attachment_id'])) {
                        $value = esc_url($value['url']);
                    }
                }
                set_theme_mod($key, $value);
            }
        }
    }
}

/**
 * Security Functions
 */

/**
 * Verify search form nonce
 */
function origamiez_verify_search_nonce() {
    if ( is_search() && isset( $_GET['search_nonce'] ) ) {
        if ( ! wp_verify_nonce( $_GET['search_nonce'], 'origamiez_search_form_nonce' ) ) {
            wp_die( esc_html__( 'Security check failed. Please try again.', 'origamiez' ) );
        }
    }
}
add_action( 'init', 'origamiez_verify_search_nonce' );

/**
 * Sanitize and validate search query
 */
function origamiez_sanitize_search_query( $query ) {
    if ( is_search() && ! is_admin() && $query->is_main_query() ) {
        $search_term = get_search_query();
        if ( ! empty( $search_term ) ) {
            // Sanitize the search term
            $sanitized_term = sanitize_text_field( $search_term );
            // Limit search term length
            $sanitized_term = substr( $sanitized_term, 0, 100 );
            $query->set( 's', $sanitized_term );
        }
    }
}
add_action( 'pre_get_posts', 'origamiez_sanitize_search_query' );



/**
 * Sanitize checkbox input
 */
function origamiez_sanitize_checkbox( $input ) {
    return ( isset( $input ) && true === (bool) $input ) ? true : false;
}

/**
 * Sanitize select input
 */
function origamiez_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


/**
 * Add security headers
 */
function origamiez_add_security_headers() {
    if ( ! is_admin() ) {
        header( 'X-Content-Type-Options: nosniff' );
        header( 'X-Frame-Options: SAMEORIGIN' );
        header( 'X-XSS-Protection: 1; mode=block' );
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
        
        // Basic Content Security Policy
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' *.googleapis.com *.gstatic.com; ";
        $csp .= "img-src 'self' data: *.gravatar.com *.wp.com; ";
        $csp .= "font-src 'self' *.googleapis.com *.gstatic.com; ";
        $csp .= "connect-src 'self'; ";
        $csp .= "frame-src 'self' *.youtube.com *.vimeo.com; ";
        $csp .= "object-src 'none'; ";
        $csp .= "base-uri 'self';";
        
        header( 'Content-Security-Policy: ' . $csp );
    }
}
add_action( 'send_headers', 'origamiez_add_security_headers' );


/**
 * Track failed login attempts
 */
function origamiez_track_failed_login( $username ) {
    $username = sanitize_user( $username );
    $attempts = get_transient( 'origamiez_login_attempts_' . $username );
    $attempts = $attempts ? $attempts + 1 : 1;
    set_transient( 'origamiez_login_attempts_' . $username, $attempts, 15 * MINUTE_IN_SECONDS );
}
add_action( 'wp_login_failed', 'origamiez_track_failed_login' );

/**
 * Clear login attempts on successful login
 */
function origamiez_clear_login_attempts( $user_login ) {
    delete_transient( 'origamiez_login_attempts_' . sanitize_user( $user_login ) );
}
add_action( 'wp_login', 'origamiez_clear_login_attempts' );


/**
 * Sanitize database inputs
 */
function origamiez_sanitize_db_input( $input, $type = 'text' ) {
    switch ( $type ) {
        case 'int':
            return absint( $input );
        case 'float':
            return floatval( $input );
        case 'email':
            return sanitize_email( $input );
        case 'url':
            return esc_url_raw( $input );
        case 'key':
            return sanitize_key( $input );
        default:
            return sanitize_text_field( $input );
    }
}
