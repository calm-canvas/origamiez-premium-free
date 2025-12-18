<?php
const ORIGAMIEZ_PREFIX = 'origamiez_';
$dir                   = trailingslashit( get_template_directory() );

require_once $dir . '/vendor/autoload.php';

add_action(
	'after_setup_theme',
	function () {
		$bootstrap = new \Origamiez\Engine\ThemeBootstrap();
		$bootstrap->boot();
	}
);

/*
HOOK CALLBACK
--------------------
All callback functions for action hooks & filter hooks.
--------------------
*/
require $dir . 'inc/functions.php';
/*
API
--------------------
All classes (abstract & utility).
--------------------
*/
require $dir . 'inc/classes/abstract-widget.php';
require $dir . 'inc/classes/abstract-widget-type-b.php';
require $dir . 'inc/classes/abstract-widget-type-c.php';
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
add_filter( 'use_widgets_block_editor', '__return_false' );
