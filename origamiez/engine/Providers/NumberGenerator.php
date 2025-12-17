<?php
/**
 * Number Generator
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Providers;

/**
 * Class NumberGenerator
 */
class NumberGenerator {

	/**
	 * The number
	 *
	 * @var int
	 */
	private int $number;

	/**
	 * NumberGenerator constructor.
	 *
	 * @param int $number The number.
	 */
	public function __construct( int $number = 0 ) {
		$this->number = $number;
	}

	/**
	 * Set the number
	 *
	 * @param int $number The number.
	 * @return $this
	 */
	public function set_number( int $number ): self {
		$this->number = $number;

		return $this;
	}

	/**
	 * Get the number
	 *
	 * @return int
	 */
	public function get_number(): int {
		return $this->number;
	}

	/**
	 * Invoke the number
	 *
	 * @return int
	 */
	public function __invoke(): int {
		return $this->get_number();
	}

	/**
	 * Create a new instance
	 *
	 * @param int $number The number.
	 * @return static
	 */
	public static function create( int $number ): self {
		return new self( $number );
	}
}
