<?php
namespace Origamiez\Engine\Security\Sanitizers;

class TextSanitizer implements SanitizerInterface {
	public function sanitize( $value ) {
		return sanitize_text_field( $value );
	}
}
