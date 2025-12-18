<?php
/**
 * Return Value Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Providers;

/**
 * Class ReturnValueProvider
 *
 * Provides factory methods for generating callbacks that return static values.
 * Consolidates multiple similar return_X() methods into a single, reusable pattern.
 */
class ReturnValueProvider {

	/**
	 * Cache for generic value callbacks.
	 *
	 * @var array
	 */
	private static array $value_cache = array();

	/**
	 * Cache for bootstrap column class callbacks.
	 *
	 * @var array
	 */
	private static array $column_class_cache = array();

	/**
	 * Create a callback that returns a specific value.
	 *
	 * @param mixed $value The value to return.
	 * @return callable The callback function.
	 */
	public static function create_value_callback( $value ): callable {
		return static function () use ( $value ) {
			return $value;
		};
	}

	/**
	 * Get a cached callback that returns a specific value.
	 *
	 * @param mixed $value The value to return.
	 * @return callable The cached callback function.
	 */
	public static function get_value_callback( $value ): callable {
		$key = is_scalar( $value ) ? $value : serialize( $value );

		if ( ! isset( self::$value_cache[ $key ] ) ) {
			self::$value_cache[ $key ] = self::create_value_callback( $value );
		}

		return self::$value_cache[ $key ];
	}

	/**
	 * Get bootstrap column class for given column count.
	 *
	 * Maps column counts to Bootstrap grid classes. For example:
	 * - 1 column = 'col-lg-12'
	 * - 3 columns = 'col-lg-4'
	 * - 4 columns = 'col-lg-3'
	 *
	 * @param int $column_count The number of columns.
	 * @return string The Bootstrap column class.
	 */
	public static function get_column_class( int $column_count ): string {
		if ( ! isset( self::$column_class_cache[ $column_count ] ) ) {
			self::$column_class_cache[ $column_count ] = self::calculate_column_class( $column_count );
		}

		return self::$column_class_cache[ $column_count ];
	}

	/**
	 * Calculate bootstrap column class for footer.
	 *
	 * @param int $column_count The number of columns.
	 * @return string The Bootstrap column class.
	 */
	private static function calculate_column_class( int $column_count ): string {
		$class_map = array(
			1 => 'col-lg-12',
			2 => 'col-lg-6',
			3 => 'col-lg-4',
			4 => 'col-lg-3',
			5 => 'col-lg-2 col-lg-offset-1',
		);

		if ( isset( $class_map[ $column_count ] ) ) {
			return $class_map[ $column_count ];
		}

		return 'col-lg-' . floor( 12 / $column_count );
	}

	/**
	 * Get footer column classes (for backward compatibility).
	 *
	 * @param int $column_count The column count.
	 * @return string
	 */
	public static function get_footer_column_classes( int $column_count = 4 ): string {
		return self::get_column_class( $column_count );
	}
}
