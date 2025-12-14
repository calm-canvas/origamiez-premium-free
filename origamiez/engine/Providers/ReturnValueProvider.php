<?php

namespace Origamiez\Engine\Providers;

class ReturnValueProvider {

	public static function return10(): int {
		return 10;
	}

	public static function return0(): int {
		return 0;
	}

	public static function return1(): int {
		return 1;
	}

	public static function returnTrue(): bool {
		return true;
	}

	public static function returnFalse(): bool {
		return false;
	}

	public static function returnEmpty(): string {
		return '';
	}

	public static function returnNull(): null {
		return null;
	}

	public static function return3ColumnsClass(): string {
		return 'col-lg-3';
	}

	public static function return4ColumnsClass(): string {
		return 'col-lg-4';
	}

	public static function return6ColumnsClass(): string {
		return 'col-lg-6';
	}

	public static function return12ColumnsClass(): string {
		return 'col-lg-12';
	}

	public static function getFooterColumnClasses( int $columnCount = 4 ): string {
		switch ( $columnCount ) {
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
				return 'col-lg-' . floor( 12 / $columnCount );
		}
	}
}
