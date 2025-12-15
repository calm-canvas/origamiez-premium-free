<?php
namespace Origamiez\Engine\Security\Validators;

class NonceSecurity implements ValidatorInterface {
	private $nonce_field = '';
	private $nonce_action = '';
	private $request_method = 'GET';

	public function __construct( $nonce_field = '', $nonce_action = '', $request_method = 'GET' ) {
		$this->nonce_field     = $nonce_field;
		$this->nonce_action    = $nonce_action;
		$this->request_method  = $request_method;
	}

	public function setNonceField( $nonce_field ) {
		$this->nonce_field = $nonce_field;
		return $this;
	}

	public function setNonceAction( $nonce_action ) {
		$this->nonce_action = $nonce_action;
		return $this;
	}

	public function setRequestMethod( $request_method ) {
		$this->request_method = $request_method;
		return $this;
	}

	public function validate( $nonce_value = null ) {
		if ( null === $nonce_value ) {
			$nonce_value = $this->getNonceValueFromRequest();
		}

		if ( empty( $nonce_value ) || empty( $this->nonce_action ) ) {
			return false;
		}

		return wp_verify_nonce( $nonce_value, $this->nonce_action );
	}

	public function isValid( $nonce_value = null ) {
		return 1 === $this->validate( $nonce_value );
	}

	public function getNonceField() {
		return wp_nonce_field( $this->nonce_action, $this->nonce_field, true, false );
	}

	public function getNonceUrl( $url ) {
		return wp_nonce_url( $url, $this->nonce_action, $this->nonce_field );
	}

	private function getNonceValueFromRequest() {
		if ( 'POST' === strtoupper( $this->request_method ) ) {
			return isset( $_POST[ $this->nonce_field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $this->nonce_field ] ) ) : null;
		} else {
			return isset( $_GET[ $this->nonce_field ] ) ? sanitize_text_field( wp_unslash( $_GET[ $this->nonce_field ] ) ) : null;
		}
	}
}
