<?php

use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Config\FontCustomizerConfig;
use Origamiez\Engine\Config\SocialConfig;
use Origamiez\Engine\Display\AuthorDisplay;
use Origamiez\Engine\Display\CommentDisplay;
use Origamiez\Engine\Display\CommentFormBuilder;
use Origamiez\Engine\Helpers\FormatHelper;
use Origamiez\Engine\Helpers\MetadataHelper;
use Origamiez\Engine\Helpers\OptionsSyncHelper;
use Origamiez\Engine\Helpers\StringHelper;
use Origamiez\Engine\Security\SanitizationHelper;
use Origamiez\Engine\Security\SecurityHeaderManager;
use Origamiez\Engine\Security\Validators\LoginAttemptTracker;
use Origamiez\Engine\Security\Validators\NonceSecurity;
use Origamiez\Engine\Security\Validators\SearchQueryValidator;

function origamiez_get_format_icon($format)
{
    return FormatHelper::get_format_icon($format);
}

function origamiez_get_breadcrumb()
{
    do_action('origamiez_print_breadcrumb');
}

function origamiez_top_bar_enable_callback()
{
    return get_theme_mod('is_display_top_bar', 1);
}

function origamiez_skin_custom_callback($control)
{
    return 'custom' === $control->manager->get_setting('skin')->value();
}

function _origamiez_font_enable_callback($font_name)
{
    $setting_name = "font_{$font_name}_is_enable";
    return 1 === (int)get_theme_mod($setting_name, 0);
}

function origamiez_font_body_enable_callback($control)
{
    return _origamiez_font_enable_callback('body');
}

function origamiez_font_menu_enable_callback($control)
{
    return _origamiez_font_enable_callback('menu');
}

function origamiez_font_site_title_enable_callback($control)
{
    return _origamiez_font_enable_callback('site_title');
}

function origamiez_font_site_subtitle_enable_callback($control)
{
    return _origamiez_font_enable_callback('site_subtitle');
}

function origamiez_font_widget_title_enable_callback($control)
{
    return _origamiez_font_enable_callback('widget_title');
}

function origamiez_font_h1_enable_callback($control)
{
    return _origamiez_font_enable_callback('h1');
}

function origamiez_font_h2_enable_callback($control)
{
    return _origamiez_font_enable_callback('h2');
}

function origamiez_font_h3_enable_callback($control)
{
    return _origamiez_font_enable_callback('h3');
}

function origamiez_font_h4_enable_callback($control)
{
    return _origamiez_font_enable_callback('h4');
}

function origamiez_font_h5_enable_callback($control)
{
    return _origamiez_font_enable_callback('h5');
}

function origamiez_font_h6_enable_callback($control)
{
    return _origamiez_font_enable_callback('h6');
}

function origamiez_list_comments($comment, $args, $depth)
{
    $display = new CommentDisplay($comment, $args, $depth);
    $display->display();
}

function origamiez_comment_form($args = array(), $post_id = null)
{
    if (null === $post_id) {
        $post_id = get_the_ID();
    }
    $form = new CommentFormBuilder($post_id, $args);
    $form->display();
}

function origamiez_get_author_infor()
{
    $author = new AuthorDisplay();
    $author->display();
}

function origamiez_get_socials()
{
    return SocialConfig::get_socials();
}

function origamiez_get_str_uglify($string)
{
    return StringHelper::uglify($string);
}


function origamiez_get_metadata_prefix($echo = true)
{
    return MetadataHelper::get_metadata_prefix($echo);
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
    return AllowedTagsConfig::get_allowed_tags();
}

function origamiez_get_button_readmore()
{
    do_action('origamiez_print_button_readmore');
}

function origamiez_save_unyson_options($option_key, $old_value, $new_value)
{
    if ('fw_theme_settings_options:origamiez' === $option_key) {
        if (is_array($old_value) && is_array($new_value)) {
            OptionsSyncHelper::sync_unyson_options($new_value);
        }
    }
}

/**
 * Security Functions
 */

/**
 * Verify search form nonce
 */
function origamiez_verify_search_nonce()
{
    return NonceSecurity::verify_nonce();
}

/**
 * Sanitize and validate search query
 */
function origamiez_sanitize_search_query($query)
{
    return SearchQueryValidator::validate($query);
}


/**
 * Sanitize checkbox input
 */
function origamiez_sanitize_checkbox($input)
{
    return SanitizationHelper::sanitize_checkbox($input);
}

/**
 * Sanitize select input
 */
function origamiez_sanitize_select($input, $setting)
{
    $choices = $setting->manager->get_control($setting->id)->choices;
    return SanitizationHelper::sanitize_select($input, $choices, $setting->default);
}


/**
 * Add security headers
 */
function origamiez_add_security_headers()
{
    SecurityHeaderManager::add_headers();
}


/**
 * Track failed login attempts
 */
function origamiez_track_failed_login($username)
{
    LoginAttemptTracker::track_failed_attempt($username);
}

/**
 * Clear login attempts on successful login
 */
function origamiez_clear_login_attempts($user_login)
{
    LoginAttemptTracker::clear_attempts($user_login);
}


/**
 * Sanitize database inputs
 */
function origamiez_sanitize_db_input($input, $type = 'text')
{
    return SanitizationHelper::sanitize_db_input($input, $type);
}

/**
 * Get available font families for customizer
 */
function origamiez_get_font_families()
{
    return FontCustomizerConfig::get_font_families();
}

/**
 * Get available font sizes for customizer
 */
function origamiez_get_font_sizes()
{
    return FontCustomizerConfig::get_font_sizes();
}

/**
 * Get available font styles for customizer
 */
function origamiez_get_font_styles()
{
    return FontCustomizerConfig::get_font_styles();
}

/**
 * Get available font weights for customizer
 */
function origamiez_get_font_weights()
{
    return FontCustomizerConfig::get_font_weights();
}

/**
 * Get available line heights for customizer
 */
function origamiez_get_font_line_heighs()
{
    return FontCustomizerConfig::get_font_line_heights();
}
