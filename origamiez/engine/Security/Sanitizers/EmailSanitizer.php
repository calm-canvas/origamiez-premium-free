<?php
namespace Origamiez\Engine\Security\Sanitizers;

class EmailSanitizer implements SanitizerInterface {
	public function sanitize( $value ) {
		return sanitize_email( $value );
	}
}
