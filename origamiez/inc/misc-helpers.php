<?php

use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Helpers\MetadataHelper;

/**
 * Get the metadata prefix.
 *
 * @param bool $echo Whether to echo the prefix.
 * @return string The metadata prefix.
 */
function origamiez_get_metadata_prefix( $echo = true ) {
	return MetadataHelper::get_metadata_prefix( $echo );
}

/**
 * Get allowed HTML tags configuration.
 *
 * @return array Allowed HTML tags.
 */
function origamiez_get_allowed_tags() {
	return AllowedTagsConfig::get_allowed_tags();
}

/**
 * Create a filter callback that returns a static numeric value.
 *
 * Use this factory to generate filter callbacks dynamically without
 * needing individual functions for each numeric value. This replaces
 * the need for multiple origamiez_return_X() functions.
 *
 * @param int $value The numeric value to return.
 * @return callable A function that returns the specified value.
 */
function origamiez_create_value_callback( $value ) {
	return static function () use ( $value ) {
		return $value;
	};
}

/**
 * Get or create a cached numeric filter callback.
 *
 * Caches closures to avoid recreating them repeatedly, improving
 * performance when the same numeric value is used as a filter callback.
 *
 * @param int $value The numeric value to return.
 * @return callable The cached callback function.
 */
function origamiez_get_value_callback( $value ) {
	static $callbacks = array();

	if ( ! isset( $callbacks[ $value ] ) ) {
		$callbacks[ $value ] = origamiez_create_value_callback( $value );
	}

	return $callbacks[ $value ];
}
