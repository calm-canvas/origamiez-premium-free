<?php
/**
 * Sanitizer Interface
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Security/Sanitizers
 */

namespace Origamiez\Security\Sanitizers;

/**
 * Interface SanitizerInterface
 *
 * @package Origamiez\Security\Sanitizers
 */
interface SanitizerInterface {
	/**
	 * Sanitize a value.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return mixed
	 */
	public function sanitize( $value );
}
