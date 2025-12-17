<?php
/**
 * Validator interface.
 *
 * @package    Origamiez
 * @subpackage Origamiez/Engine/Security/Validators
 */

namespace Origamiez\Engine\Security\Validators;

/**
 * Interface ValidatorInterface
 *
 * @package Origamiez\Engine\Security\Validators
 */
interface ValidatorInterface {
	/**
	 * Validate a value.
	 *
	 * @param mixed $value The value to validate.
	 *
	 * @return bool
	 */
	public function validate( $value );
}
