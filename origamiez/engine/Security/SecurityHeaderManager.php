<?php
/**
 * Manages security headers for the theme.
 *
 * @package Origamiez
 * @subpackage Engine\Security
 */

namespace Origamiez\Engine\Security;

/**
 * Class SecurityHeaderManager
 *
 * @package Origamiez\Engine\Security
 */
class SecurityHeaderManager {

	/**
	 * Holds the security headers.
	 *
	 * @var array
	 */
	private $headers = array();

	/**
	 * Holds the Content-Security-Policy configuration.
	 *
	 * @var array
	 */
	private $csp_config = array();

	/**
	 * SecurityHeaderManager constructor.
	 */
	public function __construct() {
		$this->initialize_default_headers();
		$this->initialize_default_csp();
	}

	/**
	 * Initializes the default security headers.
	 */
	private function initialize_default_headers() {
		$this->headers = array(
			'X-Content-Type-Options' => 'nosniff',
			'X-Frame-Options'        => 'SAMEORIGIN',
			'X-XSS-Protection'       => '1; mode=block',
			'Referrer-Policy'        => 'strict-origin-when-cross-origin',
		);
	}

	/**
	 * Initializes the default Content-Security-Policy.
	 */
	private function initialize_default_csp() {
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

	/**
	 * Sets a security header.
	 *
	 * @param string $header The header name.
	 * @param string $value  The header value.
	 * @return $this
	 */
	public function set_header( $header, $value ) {
		$this->headers[ $header ] = $value;
		return $this;
	}

	/**
	 * Removes a security header.
	 *
	 * @param string $header The header name.
	 * @return $this
	 */
	public function remove_header( $header ) {
		unset( $this->headers[ $header ] );
		return $this;
	}

	/**
	 * Gets a security header.
	 *
	 * @param string $header The header name.
	 * @return string|null
	 */
	public function get_header( $header ) {
		return isset( $this->headers[ $header ] ) ? $this->headers[ $header ] : null;
	}

	/**
	 * Sets a CSP directive.
	 *
	 * @param string $directive The CSP directive.
	 * @param string $value     The directive value.
	 * @return $this
	 */
	public function set_csp_directive( $directive, $value ) {
		$this->csp_config[ $directive ] = $value;
		return $this;
	}

	/**
	 * Removes a CSP directive.
	 *
	 * @param string $directive The CSP directive.
	 * @return $this
	 */
	public function remove_csp_directive( $directive ) {
		unset( $this->csp_config[ $directive ] );
		return $this.
	}

	/**
	 * Gets a CSP directive.
	 *
	 * @param string $directive The CSP directive.
	 * @return string|null
	 */
	public function get_csp_directive( $directive ) {
		return isset( $this->csp_config[ $directive ] ) ? $this->csp_config[ $directive ] : null;
	}

	/**
	 * Disables CSP.
	 *
	 * @return $this
	 */
	public function disable_csp() {
		$this->csp_config = array();
		return $this;
	}

	/**
	 * Sends the security headers.
	 */
	public function send_headers() {
		if ( is_admin() ) {
			return;
		}

		foreach ( $this->headers as $header => $value ) {
			header( $header . ': ' . $value );
		}

		if ( ! empty( $this->csp_config ) ) {
			$csp = $this->build_csp();
			if ( ! empty( $csp ) ) {
				header( 'Content-Security-Policy: ' . $csp );
			}
		}
	}

	/**
	 * Builds the CSP header value.
	 *
	 * @return string
	 */
	private function build_csp() {
		$csp_parts = array();

		foreach ( $this->csp_config as $directive => $value ) {
			$csp_parts[] = $directive . ' ' . $value;
		}

		return implode( '; ', $csp_parts ) . ';';
	}

	/**
	 * Gets the CSP header value.
	 *
	 * @return string
	 */
	public function get_csp() {
		return $this->build_csp();
	}

	/**
	 * Gets all security headers.
	 *
	 * @return array
	 */
	public function get_all_headers() {
		return $this->headers;
	}

	/**
	 * Gets the CSP configuration.
	 *
	 * @return array
	 */
	public function get_csp_config() {
		return $this->csp_config;
	}

	/**
	 * Registers the send_headers action.
	 *
	 * @return $this
	 */
	public function register() {
		add_action( 'send_headers', array( $this, 'send_headers' ) );
		return $this;
	}
}
