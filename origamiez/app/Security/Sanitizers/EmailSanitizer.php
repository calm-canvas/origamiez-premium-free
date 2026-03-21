<?php
/**
 * Email Sanitizer
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Security/Sanitizers
 */

namespace Origamiez\Security\Sanitizers;

/**
 * Class EmailSanitizer
 *
 * @package Origamiez\Security\Sanitizers
 */
class EmailSanitizer implements SanitizerInterface {
	/**
	 * Sanitize an email address.
	 *
	 * @param string $value The email address to sanitize.
	 *
	 * @return string
	 */
	public function sanitize( $value ) {
		return sanitize_email( $value );
	}
}
