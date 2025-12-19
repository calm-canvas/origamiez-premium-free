<?php

function origamiez_top_bar_enable_callback() {
	return get_theme_mod( 'is_display_top_bar', 1 );
}

function origamiez_skin_custom_callback( $control ) {
	return 'custom' === $control->manager->get_setting( 'skin' )->value();
}

function _origamiez_font_enable_callback( $font_name ) {
	$setting_name = "font_{$font_name}_is_enable";
	return 1 === (int) get_theme_mod( $setting_name, 0 );
}

function origamiez_font_body_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'body' );
}

function origamiez_font_menu_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'menu' );
}

function origamiez_font_site_title_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'site_title' );
}

function origamiez_font_site_subtitle_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'site_subtitle' );
}

function origamiez_font_widget_title_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'widget_title' );
}

function origamiez_font_h1_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'h1' );
}

function origamiez_font_h2_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'h2' );
}

function origamiez_font_h3_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'h3' );
}

function origamiez_font_h4_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'h4' );
}

function origamiez_font_h5_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'h5' );
}

function origamiez_font_h6_enable_callback( $control ) {
	return _origamiez_font_enable_callback( 'h6' );
}
