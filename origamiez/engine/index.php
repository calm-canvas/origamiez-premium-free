<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Origamiez\Engine\ThemeBootstrap;

require_once __DIR__ . '/Helpers/BackwardCompatibilityFunctions.php';

$bootstrap = new ThemeBootstrap();
$bootstrap->boot();

return $bootstrap;
