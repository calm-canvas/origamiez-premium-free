<?php
/**
 * Origamiez functions and definitions
 *
 * @package Origamiez
 */

use Origamiez\ThemeBootstrap;

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
require_once $dir . 'inc/config.php'; // NOSONAR.
require_once $dir . 'inc/functions.php'; // NOSONAR.
