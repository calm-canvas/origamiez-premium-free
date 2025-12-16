<?php
const ORIGAMIEZ_PREFIX = 'origamiez_';
$dir                   = trailingslashit( get_template_directory() );

/*
INIT
--------------------
Register Theme Features
--------------------
*/
function origamiez_theme_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'custom-background',
		array(
			'default-color'      => '',
			'default-attachment' => 'fixed',
		)
	);
	add_theme_support(
		'custom-header',
		apply_filters(
			'origamiez_custom_header_args',
			array(
				'header-text' => false,
				'width'       => 468,
				'height'      => 60,
				'flex-height' => true,
				'flex-width'  => true,
			)
		)
	);
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		)
	);
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );
	add_theme_support( 'editor_style' );
	add_editor_style( 'editor-style.css' );
	\Origamiez\Engine\Helpers\ImageSizeManager::register();
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 817;
	}
}

add_action( 'after_setup_theme', 'origamiez_theme_setup' );

/*
PLUGINS
--------------------
Setup - config for compatible plugins.
--------------------
*/
// 1: bbPress
require $dir . 'plugins/bbpress/index.php';
// 2: DW Question & Answer
require $dir . 'plugins/dw-question-and-answer/index.php';
// 3: WooCommerce
require $dir . 'plugins/woocommerce/index.php';

/*
AUTOLOAD & ENGINE BOOTSTRAP
--------------------
Load autoloader and initialize the Origamiez engine with dependency injection,
asset management, hooks, and layout management.
--------------------
*/
require_once $dir . '/vendor/autoload.php';
require_once $dir . 'engine/index.php';

add_filter( 'use_widgets_block_editor', '__return_false' );

function origamiez_set_classes_for_footer_one_cols( $classes ) {
	return array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
}

function origamiez_set_classes_for_footer_two_cols( $classes ) {
	return array( 'col-xs-12', 'col-sm-6', 'col-md-6' );
}

function origamiez_set_classes_for_footer_three_cols( $classes ) {
	return array( 'col-xs-12', 'col-sm-4', 'col-md-4' );
}
