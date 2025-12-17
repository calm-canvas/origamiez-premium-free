<?php


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
    do_action('origamiez_print_breadcrumb');
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
            'color' => '#1769ff',
        ),
        'bitbucket' => array(
            'icon' => 'fa-brands fa-bitbucket',
            'label' => esc_attr__('Bitbucket', 'origamiez'),
            'color' => '#0052cc',
        ),
        'codepen' => array(
            'icon' => 'fa-brands fa-codepen',
            'label' => esc_attr__('Codepen', 'origamiez'),
            'color' => '#000000',
        ),
        'delicious' => array(
            'icon' => 'fa-brands fa-delicious',
            'label' => esc_attr__('Delicious', 'origamiez'),
            'color' => '#3399ff',
        ),
        'deviantart' => array(
            'icon' => 'fa-brands fa-deviantart',
            'label' => esc_attr__('Deviantart', 'origamiez'),
            'color' => '#05cc47',
        ),
        'digg' => array(
            'icon' => 'fa-brands fa-digg',
            'label' => esc_attr__('Digg', 'origamiez'),
            'color' => '#1b5891',
        ),
        'dribbble' => array(
            'icon' => 'fa-brands fa-dribbble',
            'label' => esc_attr__('Dribbble', 'origamiez'),
            'color' => '#ea4c89',
        ),
        'dropbox' => array(
            'icon' => 'fa-brands fa-dropbox',
            'label' => esc_attr__('Dropbox', 'origamiez'),
            'color' => '#0061ff',
        ),
        'facebook' => array(
            'icon' => 'fa-brands fa-facebook',
            'label' => esc_attr__('Facebook', 'origamiez'),
            'color' => '#1877f2',
        ),
        'flickr' => array(
            'icon' => 'fa-brands fa-flickr',
            'label' => esc_attr__('Flickr', 'origamiez'),
            'color' => '#0063dc',
        ),
        'foursquare' => array(
            'icon' => 'fa-brands fa-foursquare',
            'label' => esc_attr__('Foursquare', 'origamiez'),
            'color' => '#fa7343',
        ),
        'git' => array(
            'icon' => 'fa-brands fa-git',
            'label' => esc_attr__('Git', 'origamiez'),
            'color' => '#f1502f',
        ),
        'github' => array(
            'icon' => 'fa-brands fa-github',
            'label' => esc_attr__('Github', 'origamiez'),
            'color' => '#333333',
        ),
        'google-plus' => array(
            'icon' => 'fa-brands fa-google-plus',
            'label' => esc_attr__('Google plus', 'origamiez'),
            'color' => '#ea4335',
        ),
        'instagram' => array(
            'icon' => 'fa-brands fa-instagram',
            'label' => esc_attr__('Instagram', 'origamiez'),
            'color' => '#e4405f',
        ),
        'jsfiddle' => array(
            'icon' => 'fa-brands fa-jsfiddle',
            'label' => esc_attr__('JsFiddle', 'origamiez'),
            'color' => '#007bb6',
        ),
        'linkedin' => array(
            'icon' => 'fa-brands fa-linkedin',
            'label' => esc_attr__('linkedin', 'origamiez'),
            'color' => '#0a66c2',
        ),
        'pinterest' => array(
            'icon' => 'fa-brands fa-pinterest',
            'label' => esc_attr__('Pinterest', 'origamiez'),
            'color' => '#e60023',
        ),
        'reddit' => array(
            'icon' => 'fa-brands fa-reddit',
            'label' => esc_attr__('Reddit', 'origamiez'),
            'color' => '#ff4500',
        ),
        'soundcloud' => array(
            'icon' => 'fa-brands fa-soundcloud',
            'label' => esc_attr__('Soundcloud', 'origamiez'),
            'color' => '#ff5500',
        ),
        'spotify' => array(
            'icon' => 'fa-brands fa-spotify',
            'label' => esc_attr__('Spotify', 'origamiez'),
            'color' => '#1db954',
        ),
        'stack-exchange' => array(
            'icon' => 'fa-brands fa-stack-exchange',
            'label' => esc_attr__('Stack exchange', 'origamiez'),
            'color' => '#f48024',
        ),
        'stack-overflow' => array(
            'icon' => 'fa-brands fa-stack-overflow',
            'label' => esc_attr__('Stack overflow', 'origamiez'),
            'color' => '#f48024',
        ),
        'stumbleupon' => array(
            'icon' => 'fa-brands fa-stumbleupon',
            'label' => esc_attr__('Stumbleupon', 'origamiez'),
            'color' => '#eb4823',
        ),
        'tumblr' => array(
            'icon' => 'fa-brands fa-tumblr',
            'label' => esc_attr__('Tumblr', 'origamiez'),
            'color' => '#36465d',
        ),
        'twitter' => array(
            'icon' => 'fa-brands fa-twitter',
            'label' => esc_attr__('Twitter', 'origamiez'),
            'color' => '#1da1f2',
        ),
        'vimeo' => array(
            'icon' => 'fa-brands fa-vimeo-square',
            'label' => esc_attr__('Vimeo', 'origamiez'),
            'color' => '#1ab7ea',
        ),
        'youtube' => array(
            'icon' => 'fa-brands fa-youtube',
            'label' => esc_attr__('Youtube', 'origamiez'),
            'color' => '#ff0000',
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
    do_action('origamiez_print_button_readmore');
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
}

/**
 * Sanitize and validate search query
 */
function origamiez_sanitize_search_query( $query ) {
}



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
}


/**
 * Track failed login attempts
 */
function origamiez_track_failed_login( $username ) {
}

/**
 * Clear login attempts on successful login
 */
function origamiez_clear_login_attempts( $user_login ) {
}


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
