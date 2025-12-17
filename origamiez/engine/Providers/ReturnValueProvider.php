<?php
/**
 * Return Value Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Providers;

/**
 * Class ReturnValueProvider
 */
class ReturnValueProvider {

	/**
	 * Return 10
	 *
	 * @return int
	 */
	public static function return_10(): int {
		return 10;
	}

	/**
	 * Return 0
	 *
	 * @return int
	 */
	public static function return_0(): int {
		return 0;
	}

	/**
	 * Return 1
	 *
	 * @return int
	 */
	public static function return_1(): int {
		return 1;
	}

	/**
	 * Return true
	 *
	 * @return bool
	 */
	public static function return_true(): bool {
		return true;
	}

	/**
	 * Return false
	 *
	 * @return bool
	 */
	public static function return_false(): bool {
		return false;
	}

	/**
	 * Return empty
	 *
	 * @return string
	 */
	public static function return_empty(): string {
		return '';
	}

	/**
	 * Return null
	 *
	 * @return null
	 */
	public static function return_null(): null {
		return null;
	}

	/**
	 * Return 3 columns class
	 *
	 * @return string
	 */
	public static function return_3_columns_class(): string {
		return 'col-lg-3';
	}

	/**
	 * Return 4 columns class
	 *
	 * @return string
	 */
	public static function return_4_columns_class(): string {
		return 'col-lg-4';
	}

	/**
	 * Return 6 columns class
	 *
	 * @return string
	 */
	public static function return_6_columns_class(): string {
		return 'col-lg-6';
	}

	/**
	 * Return 12 columns class
	 *
	 * @return string
	 */
	public static function return_12_columns_class(): string {
		return 'col-lg-12';
	}

	/**
	 * Get footer column classes
	 *
	 * @param int $column_count The column count.
	 * @return string
	 */
	public static function get_footer_column_classes( int $column_count = 4 ): string {
		switch ( $column_count ) {
			case 1:
				return 'col-lg-12';
			case 2:
				return 'col-lg-6';
			case 3:
				return 'col-lg-4';
			case 4:
				return 'col-lg-3';
			case 5:
				return 'col-lg-2 col-lg-offset-1';
			default:
				return 'col-lg-' . floor( 12 / $column_count );
		}
	}
}
