<?php
/**
 * Origamiez functions and definitions
 *
 * @package Origamiez
 */

use Origamiez\ThemeBootstrap;

const ORIGAMIEZ_PREFIX  = 'origamiez_';
const ORIGAMIEZ_VERSION = '4.3.1';
$dir                    = trailingslashit( get_template_directory() );

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
