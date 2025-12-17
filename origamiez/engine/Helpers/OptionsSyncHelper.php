<?php
/**
 * Options Sync Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Helpers;

/**
 * Class OptionsSyncHelper
 */
class OptionsSyncHelper {

	/**
	 * Sync Unyson options
	 *
	 * @param array $new_values The new values.
	 */
	public static function sync_unyson_options( array $new_values ): void {
		foreach ( $new_values as $key => $value ) {
			if ( 'logo' === $key ) {
				if ( isset( $value['url'] ) && isset( $value['attachment_id'] ) ) {
					$value = esc_url( $value['url'] );
				}
			}
			set_theme_mod( $key, $value );
		}
	}

	/**
	 * Get option
	 *
	 * @param string $key The key.
	 * @param mixed  $default The default value.
	 * @return mixed
	 */
	public static function get_option( string $key, mixed $default = false ): mixed {
		return get_option( $key, $default );
	}

	/**
	 * Set option
	 *
	 * @param string $key The key.
	 * @param mixed  $value The value.
	 * @return bool
	 */
	public static function set_option( string $key, mixed $value ): bool {
		return update_option( $key, $value );
	}

	/**
	 * Get theme mod
	 *
	 * @param string $key The key.
	 * @param mixed  $default The default value.
	 * @return mixed
	 */
	public static function get_theme_mod( string $key, mixed $default = false ): mixed {
		return get_theme_mod( $key, $default );
	}

	/**
	 * Set theme mod
	 *
	 * @param string $key The key.
	 * @param mixed  $value The value.
	 */
	public static function set_theme_mod( string $key, mixed $value ): void {
		set_theme_mod( $key, $value );
	}

	/**
	 * Delete theme mod
	 *
	 * @param string $key The key.
	 */
	public static function delete_theme_mod( string $key ): void {
		remove_theme_mod( $key );
	}
}
