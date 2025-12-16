<?php

namespace Origamiez\Engine\Providers;

class NumberGenerator {

	private int $number;

	public function __construct( int $number = 0 ) {
		$this->number = $number;
	}

	public function setNumber( int $number ): self {
		$this->number = $number;

		return $this;
	}

	public function getNumber(): int {
		return $this->number;
	}

	public function __invoke(): int {
		return $this->getNumber();
	}

	public static function create( int $number ): self {
		return new self( $number );
	}
}
