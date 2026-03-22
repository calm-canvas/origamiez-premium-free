<?php
/**
 * Sanitization Helper
 *
 * @package Origamiez
 */

namespace Origamiez\Security;

/**
 * Class SanitizationHelper
 *
 * Provides helper methods for common sanitization operations.
 */
class SanitizationHelper {

	/**
	 * Get the sanitization manager instance.
	 *
	 * @return SanitizationManager
	 */
	private static function get_manager(): SanitizationManager {
		return SanitizationManager::get_instance();
	}

	/**
	 * Sanitize checkbox input.
	 *
	 * @param mixed $input The input to sanitize.
	 *
	 * @return bool
	 */
	public static function sanitize_checkbox( $input ): bool {
		return self::get_manager()->sanitize_checkbox( $input );
	}

	/**
	 * Sanitize select input.
	 *
	 * @param mixed $input The input to sanitize.
	 * @param array $choices The allowed choices.
	 * @param mixed $default_value The default value.
	 *
	 * @return mixed
	 */
	public static function sanitize_select( $input, array $choices = array(), $default_value = '' ) {
		return self::get_manager()->sanitize_select( $input, $choices, $default_value );
	}

	/**
	 * Sanitize database input by type.
	 *
	 * @param mixed  $input The input to sanitize.
	 * @param string $type The type of sanitization ('int', 'float', 'email', 'url', 'key', 'text').
	 *
	 * @return mixed
	 */
	public static function sanitize_db_input( $input, string $type = 'text' ) {
		$result = null;
		switch ( $type ) {
			case 'int':
				$result = absint( $input );
				break;
			case 'float':
				$result = floatval( $input );
				break;
			case 'email':
				$result = self::get_manager()->sanitize_email( $input );
				break;
			case 'url':
				$result = self::get_manager()->sanitize_url( $input );
				break;
			case 'key':
				$result = sanitize_key( $input );
				break;
			default:
				$result = self::get_manager()->sanitize_text( $input );
				break;
		}

		return $result;
	}

	/**
	 * Sanitize text input.
	 *
	 * @param mixed $input The input to sanitize.
	 *
	 * @return mixed
	 */
	public static function sanitize_text( $input ) {
		return self::get_manager()->sanitize_text( $input );
	}

	/**
	 * Sanitize email input.
	 *
	 * @param mixed $input The input to sanitize.
	 *
	 * @return mixed
	 */
	public static function sanitize_email( $input ) {
		return self::get_manager()->sanitize_email( $input );
	}

	/**
	 * Sanitize URL input.
	 *
	 * @param mixed $input The input to sanitize.
	 *
	 * @return mixed
	 */
	public static function sanitize_url( $input ) {
		return self::get_manager()->sanitize_url( $input );
	}

	/**
	 * Sanitize textarea input.
	 *
	 * @param mixed $input The input to sanitize.
	 *
	 * @return mixed
	 */
	public static function sanitize_textarea( $input ) {
		return self::get_manager()->sanitize_textarea( $input );
	}
}
