<?php
namespace Origamiez\Engine\Security\Sanitizers;

class UrlSanitizer implements SanitizerInterface {
	public function sanitize( $value ) {
		return esc_url_raw( $value );
	}
}
