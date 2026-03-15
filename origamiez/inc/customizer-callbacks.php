<?php
/**
 * Customizer Callbacks
 *
 * @package Origamiez
 */

/**
 * Top bar enable callback
 *
 * @return mixed
 */
function origamiez_top_bar_enable_callback() {
	return get_theme_mod( 'is_display_top_bar', 1 );
}

/**
 * Skin custom callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_skin_custom_callback( $control ) {
	return 'custom' === $control->manager->get_setting( 'skin' )->value();
}

/**
 * Font enable callback helper
 *
 * @param string $font_name Font name.
 * @return bool
 */
function origamiez_font_enable_callback( $font_name ) {
	$setting_name = "font_{$font_name}_is_enable";
	return 1 === (int) get_theme_mod( $setting_name, 0 );
}

/**
 * Font body enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_body_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'body' );
}

/**
 * Font menu enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_menu_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'menu' );
}

/**
 * Font site title enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_site_title_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'site_title' );
}

/**
 * Font site subtitle enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_site_subtitle_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'site_subtitle' );
}

/**
 * Font widget title enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_widget_title_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'widget_title' );
}

/**
 * Font h1 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h1_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'h1' );
}

/**
 * Font h2 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h2_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'h2' );
}

/**
 * Font h3 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h3_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'h3' );
}

/**
 * Font h4 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h4_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'h4' );
}

/**
 * Font h5 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h5_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'h5' );
}

/**
 * Font h6 enable callback
 *
 * @param object $control Customizer control.
 * @return bool
 */
function origamiez_font_h6_enable_callback( $control ) {
	unset( $control );
	return origamiez_font_enable_callback( 'h6' );
}
