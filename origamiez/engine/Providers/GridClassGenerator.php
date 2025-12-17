<?php
/**
 * Grid Class Generator
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Providers;

/**
 * Class GridClassGenerator
 */
class GridClassGenerator {

	/**
	 * The grid classes
	 *
	 * @var array
	 */
	private array $grid_classes = array();

	/**
	 * The columns
	 *
	 * @var int
	 */
	private int $columns = 1;

	/**
	 * GridClassGenerator constructor.
	 *
	 * @param int $columns The columns.
	 */
	public function __construct( int $columns = 1 ) {
		$this->columns = max( 1, min( 5, $columns ) );
		$this->generate_grid_classes();
	}

	/**
	 * Generate grid classes
	 */
	private function generate_grid_classes(): void {
		switch ( $this->columns ) {
			case 1:
				$this->grid_classes = array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
				break;
			case 2:
				$this->grid_classes = array( 'col-xs-12', 'col-sm-6', 'col-md-6' );
				break;
			case 3:
				$this->grid_classes = array( 'col-xs-12', 'col-sm-4', 'col-md-4' );
				break;
			case 4:
				$this->grid_classes = array( 'col-xs-12', 'col-sm-3', 'col-md-3' );
				break;
			case 5:
				$this->grid_classes = array( 'col-xs-12', 'col-sm-2.4', 'col-md-2.4' );
				break;
			default:
				$this->grid_classes = array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
		}
	}

	/**
	 * Get grid classes
	 *
	 * @return array
	 */
	public function get_grid_classes(): array {
		return $this->grid_classes;
	}

	/**
	 * Set columns
	 *
	 * @param int $columns The columns.
	 * @return $this
	 */
	public function set_columns( int $columns ): self {
		$this->columns = max( 1, min( 5, $columns ) );
		$this->generate_grid_classes();

		return $this;
	}

	/**
	 * Get columns
	 *
	 * @return int
	 */
	public function get_columns(): int {
		return $this->columns;
	}

	/**
	 * Invoke the grid classes
	 *
	 * @return array
	 */
	public function __invoke(): array {
		return $this->get_grid_classes();
	}

	/**
	 * Create for columns
	 *
	 * @param int $columns The columns.
	 * @return array
	 */
	public static function create_for_columns( int $columns ): array {
		$generator = new self( $columns );

		return $generator->get_grid_classes();
	}

	/**
	 * One column
	 *
	 * @return array
	 */
	public static function one_column(): array {
		return self::create_for_columns( 1 );
	}

	/**
	 * Two columns
	 *
	 * @return array
	 */
	public static function two_columns(): array {
		return self::create_for_columns( 2 );
	}

	/**
	 * Three columns
	 *
	 * @return array
	 */
	public static function three_columns(): array {
		return self::create_for_columns( 3 );
	}

	/**
	 * Four columns
	 *
	 * @return array
	 */
	public static function four_columns(): array {
		return self::create_for_columns( 4 );
	}

	/**
	 * Five columns
	 *
	 * @return array
	 */
	public static function five_columns(): array {
		return self::create_for_columns( 5 );
	}
}
