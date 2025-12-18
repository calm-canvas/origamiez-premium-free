<?php

use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Config\FontCustomizerConfig;
use Origamiez\Engine\Config\SocialConfig;
use Origamiez\Engine\Display\AuthorDisplay;
use Origamiez\Engine\Helpers\FormatHelper;
use Origamiez\Engine\Helpers\MetadataHelper;

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

function origamiez_get_author_infor()
{
    $author = new AuthorDisplay();
    $author->display();
}

function origamiez_get_socials()
{
    return SocialConfig::get_socials();
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
