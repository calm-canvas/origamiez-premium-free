<?php
/**
 * Checkbox Sanitizer
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Security/Sanitizers
 */

namespace Origamiez\Engine\Security\Sanitizers;

/**
 * Class CheckboxSanitizer
 *
 * @package Origamiez\Engine\Security\Sanitizers
 */
class CheckboxSanitizer implements SanitizerInterface {
	/**
	 * Sanitize a checkbox value.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return bool
	 */
	public function sanitize( $value ) {
		return isset( $value ) && true === (bool) $value;
	}
}
