<?php
/**
 * Verification script for LayoutConfig refactor.
 */

// Mock WordPress function if not exists
if ( ! function_exists( 'apply_filters' ) ) {
	function apply_filters( $tag, $value ) {
		echo "apply_filters called for tag: $tag\n";
		return $value;
	}
}

// Include necessary files
require_once __DIR__ . '/../origamiez/engine/Config/AbstractConfigRegistry.php';
require_once __DIR__ . '/../origamiez/engine/Config/LayoutConfig.php';

use Origamiez\Engine\Config\LayoutConfig;

echo "Instantiating LayoutConfig...\n";
$layout_config = new LayoutConfig();

echo "Getting all layouts...\n";
$layouts = $layout_config->get_all_layouts();

if ( empty( $layouts ) ) {
	echo "ERROR: No layouts found.\n";
	exit( 1 );
}

echo "Found " . count( $layouts ) . " layouts.\n";

// Check for specific layouts
$expected_layouts = [ 'default', 'fullwidth', 'magazine' ];
foreach ( $expected_layouts as $id ) {
	if ( ! isset( $layouts[ $id ] ) ) {
		echo "ERROR: Expected layout '$id' not found.\n";
		exit( 1 );
	}
	echo "Layout '$id' exists.\n";
}

// Check constants (after refactor)
if ( defined( 'Origamiez\Engine\Config\LayoutConfig::DEFAULT_SIDEBAR' ) ) {
	echo "Constant DEFAULT_SIDEBAR exists: " . LayoutConfig::DEFAULT_SIDEBAR . "\n";
} else {
	echo "NOTICE: Constant DEFAULT_SIDEBAR does not exist yet (expected before refactor).\n";
}

echo "Verification successful.\n";
