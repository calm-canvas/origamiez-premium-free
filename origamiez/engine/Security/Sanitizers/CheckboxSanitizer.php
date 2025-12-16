<?php
namespace Origamiez\Engine\Security\Sanitizers;

class CheckboxSanitizer implements SanitizerInterface {
	public function sanitize( $value ) {
		return isset( $value ) && true === (bool) $value;
	}
}
