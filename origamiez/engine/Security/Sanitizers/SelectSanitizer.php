<?php
/**
 * Select Sanitizer
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Security/Sanitizers
 */

namespace Origamiez\Engine\Security\Sanitizers;

/**
 * Class SelectSanitizer
 *
 * @package Origamiez\Engine\Security\Sanitizers
 */
class SelectSanitizer implements SanitizerInterface {
	/**
	 * The choices.
	 *
	 * @var array
	 */
	private $choices = array();
	/**
	 * The default value.
	 *
	 * @var string
	 */
	private $default_value = '';

	/**
	 * SelectSanitizer constructor.
	 *
	 * @param array  $choices       The choices.
	 * @param string $default_value The default value.
	 */
	public function __construct( $choices = array(), $default_value = '' ) {
		$this->choices       = $choices;
		$this->default_value = $default_value;
	}

	/**
	 * Set the choices.
	 *
	 * @param array $choices The choices.
	 *
	 * @return $this
	 */
	public function setChoices( $choices ) {
		$this->choices = $choices;
		return $this;
	}

	/**
	 * Set the default value.
	 *
	 * @param string $default_value The default value.
	 *
	 * @return $this
	 */
	public function setDefault( $default_value ) {
		$this->default_value = $default_value;
		return $this;
	}

	/**
	 * Sanitize a select value.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string
	 */
	public function sanitize( $value ) {
		$value = sanitize_text_field( $value );

		if ( array_key_exists( $value, $this->choices ) ) {
			return $value;
		}

		return $this->default_value;
	}
}
