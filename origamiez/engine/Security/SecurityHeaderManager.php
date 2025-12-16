<?php
namespace Origamiez\Engine\Security;

class SecurityHeaderManager {
	private $headers    = array();
	private $csp_config = array();

	public function __construct() {
		$this->initializeDefaultHeaders();
		$this->initializeDefaultCSP();
	}

	private function initializeDefaultHeaders() {
		$this->headers = array(
			'X-Content-Type-Options' => 'nosniff',
			'X-Frame-Options'        => 'SAMEORIGIN',
			'X-XSS-Protection'       => '1; mode=block',
			'Referrer-Policy'        => 'strict-origin-when-cross-origin',
		);
	}

	private function initializeDefaultCSP() {
		$this->csp_config = array(
			'default-src' => "'self'",
			'script-src'  => "'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com",
			'style-src'   => "'self' 'unsafe-inline' *.googleapis.com *.gstatic.com",
			'img-src'     => "'self' data: *.gravatar.com *.wp.com",
			'font-src'    => "'self' *.googleapis.com *.gstatic.com",
			'connect-src' => "'self'",
			'frame-src'   => "'self' *.youtube.com *.vimeo.com",
			'object-src'  => "'none'",
			'base-uri'    => "'self'",
		);
	}

	public function setHeader( $header, $value ) {
		$this->headers[ $header ] = $value;
		return $this;
	}

	public function removeHeader( $header ) {
		unset( $this->headers[ $header ] );
		return $this;
	}

	public function getHeader( $header ) {
		return isset( $this->headers[ $header ] ) ? $this->headers[ $header ] : null;
	}

	public function setCSPDirective( $directive, $value ) {
		$this->csp_config[ $directive ] = $value;
		return $this;
	}

	public function removeCSPDirective( $directive ) {
		unset( $this->csp_config[ $directive ] );
		return $this;
	}

	public function getCSPDirective( $directive ) {
		return isset( $this->csp_config[ $directive ] ) ? $this->csp_config[ $directive ] : null;
	}

	public function disableCSP() {
		$this->csp_config = array();
		return $this;
	}

	public function sendHeaders() {
		if ( is_admin() ) {
			return;
		}

		foreach ( $this->headers as $header => $value ) {
			header( $header . ': ' . $value );
		}

		if ( ! empty( $this->csp_config ) ) {
			$csp = $this->buildCSP();
			if ( ! empty( $csp ) ) {
				header( 'Content-Security-Policy: ' . $csp );
			}
		}
	}

	private function buildCSP() {
		$csp_parts = array();

		foreach ( $this->csp_config as $directive => $value ) {
			$csp_parts[] = $directive . ' ' . $value;
		}

		return implode( '; ', $csp_parts ) . ';';
	}

	public function getCSP() {
		return $this->buildCSP();
	}

	public function getAllHeaders() {
		return $this->headers;
	}

	public function getCSPConfig() {
		return $this->csp_config;
	}

	public function register() {
		add_action( 'send_headers', array( $this, 'sendHeaders' ) );
		return $this;
	}
}
