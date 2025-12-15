<?php
namespace Origamiez\Engine\Security\Sanitizers;

class SelectSanitizer implements SanitizerInterface {
	private $choices = array();
	private $default = '';

	public function __construct( $choices = array(), $default = '' ) {
		$this->choices = $choices;
		$this->default = $default;
	}

	public function setChoices( $choices ) {
		$this->choices = $choices;
		return $this;
	}

	public function setDefault( $default ) {
		$this->default = $default;
		return $this;
	}

	public function sanitize( $value ) {
		$value = sanitize_text_field( $value );

		if ( array_key_exists( $value, $this->choices ) ) {
			return $value;
		}

		return $this->default;
	}
}
