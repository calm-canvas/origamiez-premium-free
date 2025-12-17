<?php
/**
 * URL Sanitizer
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Security/Sanitizers
 */

namespace Origamiez\Engine\Security\Sanitizers;

/**
 * Class UrlSanitizer
 *
 * @package Origamiez\Engine\Security\Sanitizers
 */
class UrlSanitizer implements SanitizerInterface {
	/**
	 * Sanitize a URL.
	 *
	 * @param string $value The URL to sanitize.
	 *
	 * @return string
	 */
	public function sanitize( $value ) {
		return esc_url_raw( $value );
	}
}
