<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Origamiez\Engine\ThemeBootstrap;

$bootstrap = new ThemeBootstrap();
$bootstrap->boot();

return $bootstrap;
