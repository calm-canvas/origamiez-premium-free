<?php
/**
 * Index
 *
 * @package Origamiez
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Origamiez\ThemeBootstrap;

$bootstrap = new ThemeBootstrap();
$bootstrap->boot();

return $bootstrap;
