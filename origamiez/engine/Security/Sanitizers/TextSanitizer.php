<?php
/**
 * Text Sanitizer
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Security/Sanitizers
 */

namespace Origamiez\Engine\Security\Sanitizers;

/**
 * Class TextSanitizer
 *
 * @package Origamiez\Engine\Security\Sanitizers
 */
class TextSanitizer implements SanitizerInterface {
	/**
	 * Sanitize a text field.
	 *
	 * @param string $value The text to sanitize.
	 *
	 * @return string
	 */
	public function sanitize( $value ) {
		return sanitize_text_field( $value );
	}
}
