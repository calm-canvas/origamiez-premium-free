<?php
/**
 * Nonce security validator.
 *
 * @package    Origamiez
 * @subpackage Origamiez/Engine/Security/Validators
 */

namespace Origamiez\Engine\Security\Validators;

/**
 * Class NonceSecurity
 *
 * @package Origamiez\Engine\Security\Validators
 */
class NonceSecurity implements ValidatorInterface {
	/**
	 * The nonce field name.
	 *
	 * @var string
	 */
	private $nonce_field = '';
	/**
	 * The nonce action name.
	 *
	 * @var string
	 */
	private $nonce_action = '';
	/**
	 * The request method.
	 *
	 * @var string
	 */
	private $request_method = 'GET';

	/**
	 * NonceSecurity constructor.
	 *
	 * @param string $nonce_field    The nonce field name.
	 * @param string $nonce_action   The nonce action name.
	 * @param string $request_method The request method.
	 */
	public function __construct( $nonce_field = '', $nonce_action = '', $request_method = 'GET' ) {
		$this->nonce_field    = $nonce_field;
		$this->nonce_action   = $nonce_action;
		$this->request_method = $request_method;
	}

	/**
	 * Set the nonce field name.
	 *
	 * @param string $nonce_field The nonce field name.
	 *
	 * @return $this
	 */
	public function setNonceField( $nonce_field ) {
		$this->nonce_field = $nonce_field;
		return $this;
	}

	/**
	 * Set the nonce action name.
	 *
	 * @param string $nonce_action The nonce action name.
	 *
	 * @return $this
	 */
	public function setNonceAction( $nonce_action ) {
		$this->nonce_action = $nonce_action;
		return $this;
	}

	/**
	 * Set the request method.
	 *
	 * @param string $request_method The request method.
	 *
	 * @return $this
	 */
	public function setRequestMethod( $request_method ) {
		$this->request_method = $request_method;
		return $this;
	}

	/**
	 * Validate the nonce.
	 *
	 * @param string|null $nonce_value The nonce value.
	 *
	 * @return bool|int
	 */
	public function validate( $nonce_value = null ) {
		if ( null === $nonce_value ) {
			$nonce_value = $this->getNonceValueFromRequest();
		}

		if ( empty( $nonce_value ) || empty( $this->nonce_action ) ) {
			return false;
		}

		return wp_verify_nonce( $nonce_value, $this->nonce_action );
	}

	/**
	 * Check if the nonce is valid.
	 *
	 * @param string|null $nonce_value The nonce value.
	 *
	 * @return bool
	 */
	public function isValid( $nonce_value = null ) {
		return 1 === $this->validate( $nonce_value );
	}

	/**
	 * Get the nonce field.
	 *
	 * @return string
	 */
	public function getNonceField() {
		return wp_nonce_field( $this->nonce_action, $this->nonce_field, true, false );
	}

	/**
	 * Get the nonce URL.
	 *
	 * @param string $url The URL.
	 *
	 * @return string
	 */
	public function getNonceUrl( $url ) {
		return wp_nonce_url( $url, $this->nonce_action, $this->nonce_field );
	}

	/**
	 * Get the nonce value from the request.
	 *
	 * @return string|null
	 */
	private function getNonceValueFromRequest() {
		// This method retrieves the nonce value from the request, it does not process any data.
		// The actual nonce verification is done in the validate() method.
		if ( 'POST' === strtoupper( $this->request_method ) ) {
			return isset( $_POST[ $this->nonce_field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $this->nonce_field ] ) ) : null;
		} else {
			return isset( $_GET[ $this->nonce_field ] ) ? sanitize_text_field( wp_unslash( $_GET[ $this->nonce_field ] ) ) : null;
		}
	}
}
