<?php

namespace Origamiez\Engine\Providers;

class GridClassGenerator {

	private array $gridClasses = array();
	private int $columns       = 1;

	public function __construct( int $columns = 1 ) {
		$this->columns = max( 1, min( 5, $columns ) );
		$this->generateGridClasses();
	}

	private function generateGridClasses(): void {
		switch ( $this->columns ) {
			case 1:
				$this->gridClasses = array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
				break;
			case 2:
				$this->gridClasses = array( 'col-xs-12', 'col-sm-6', 'col-md-6' );
				break;
			case 3:
				$this->gridClasses = array( 'col-xs-12', 'col-sm-4', 'col-md-4' );
				break;
			case 4:
				$this->gridClasses = array( 'col-xs-12', 'col-sm-3', 'col-md-3' );
				break;
			case 5:
				$this->gridClasses = array( 'col-xs-12', 'col-sm-2.4', 'col-md-2.4' );
				break;
			default:
				$this->gridClasses = array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
		}
	}

	public function getGridClasses(): array {
		return $this->gridClasses;
	}

	public function setColumns( int $columns ): self {
		$this->columns = max( 1, min( 5, $columns ) );
		$this->generateGridClasses();

		return $this;
	}

	public function getColumns(): int {
		return $this->columns;
	}

	public function __invoke(): array {
		return $this->getGridClasses();
	}

	public static function createForColumns( int $columns ): array {
		$generator = new self( $columns );

		return $generator->getGridClasses();
	}

	public static function oneColumn(): array {
		return self::createForColumns( 1 );
	}

	public static function twoColumns(): array {
		return self::createForColumns( 2 );
	}

	public static function threeColumns(): array {
		return self::createForColumns( 3 );
	}

	public static function fourColumns(): array {
		return self::createForColumns( 4 );
	}

	public static function fiveColumns(): array {
		return self::createForColumns( 5 );
	}
}
