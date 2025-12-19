<?php

use Origamiez\Engine\ThemeBootstrap;

const ORIGAMIEZ_PREFIX = 'origamiez_';
$dir                   = trailingslashit( get_template_directory() );

require_once $dir . '/vendor/autoload.php';

add_action(
	'after_setup_theme',
	function () {
		$bootstrap = new ThemeBootstrap();
		$bootstrap->boot();
	}
);

/*
HOOK CALLBACK
--------------------
All callback functions for action hooks & filter hooks.
--------------------
*/
require_once $dir . 'inc/config.php';
require $dir . 'inc/functions.php';

/*
PLUGINS
--------------------
Setup - config for compatible plugins.
--------------------
*/
require $dir . 'plugins/bbpress/index.php';
require $dir . 'plugins/dw-question-and-answer/index.php';
require $dir . 'plugins/woocommerce/index.php';
