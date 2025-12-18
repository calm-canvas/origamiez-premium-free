<?php
/**
 * Manages the sanitization of data.
 *
 * @package Origamiez
 * @subpackage Engine\Security
 */

namespace Origamiez\Engine\Security;

use Origamiez\Engine\Security\Sanitizers\SanitizerInterface;
use Origamiez\Engine\Security\Sanitizers\CheckboxSanitizer;
use Origamiez\Engine\Security\Sanitizers\SelectSanitizer;
use Origamiez\Engine\Security\Sanitizers\TextAreaSanitizer;
use Origamiez\Engine\Security\Sanitizers\UrlSanitizer;
use Origamiez\Engine\Security\Sanitizers\EmailSanitizer;
use Origamiez\Engine\Security\Sanitizers\TextSanitizer;

/**
 * Class SanitizationManager
 *
 * @package Origamiez\Engine\Security
 */
class SanitizationManager {

	/**
	 * The single instance of the class.
	 *
	 * @var SanitizationManager|null
	 */
	private static $instance = null;

	/**
	 * The registered sanitizers.
	 *
	 * @var array
	 */
	private $sanitizers = array();

	/**
	 * SanitizationManager constructor.
	 */
	private function __construct() {
		$this->register_default_sanitizers();
	}

	/**
	 * Gets the single instance of the class.
	 *
	 * @return SanitizationManager
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Registers the default sanitizers.
	 */
	private function register_default_sanitizers() {
		$this->register( 'checkbox', new CheckboxSanitizer() );
		$this->register( 'text', new TextSanitizer() );
		$this->register( 'email', new EmailSanitizer() );
		$this->register( 'url', new UrlSanitizer() );
		$this->register( 'textarea', new TextAreaSanitizer() );
		$this->register( 'select', new SelectSanitizer() );
	}

	/**
	 * Registers a sanitizer.
	 *
	 * @param string             $type      The type of sanitizer.
	 * @param SanitizerInterface $sanitizer The sanitizer instance.
	 * @return $this
	 */
	public function register( $type, SanitizerInterface $sanitizer ) {
		$this->sanitizers[ $type ] = $sanitizer;
		return $this;
	}

	/**
	 * Sanitizes a value.
	 *
	 * @param mixed  $value The value to sanitize.
	 * @param string $type  The type of sanitization to use.
	 * @return mixed
	 */
	public function sanitize( $value, $type = 'text' ) {
		if ( ! isset( $this->sanitizers[ $type ] ) ) {
			$type = 'text';
		}

		return $this->sanitizers[ $type ]->sanitize( $value );
	}

	/**
	 * Gets a sanitizer.
	 *
	 * @param string $type The type of sanitizer.
	 * @return SanitizerInterface|null
	 */
	public function get_sanitizer( $type ) {
		return isset( $this->sanitizers[ $type ] ) ? $this->sanitizers[ $type ] : null;
	}

	/**
	 * Checks if a sanitizer exists.
	 *
	 * @param string $type The type of sanitizer.
	 * @return bool
	 */
	public function has( $type ) {
		return isset( $this->sanitizers[ $type ] );
	}

	/**
	 * Sanitizes a select input with choices validation.
	 *
	 * @param mixed $value        The value to sanitize.
	 * @param array $choices      The allowed choices.
	 * @param mixed $default_value The default value if invalid.
	 * @return mixed The sanitized value.
	 */
	public function sanitize_select( $value, $choices = array(), $default_value = '' ) {
		$sanitizer = $this->sanitizers['select'];
		if ( $sanitizer instanceof SelectSanitizer ) {
			$sanitizer->setChoices( $choices )->setDefault( $default_value );
		}
		return $sanitizer->sanitize( $value );
	}

	/**
	 * Create a sanitization method dynamically via magic method.
	 *
	 * Allows calling sanitize_TYPE() methods that delegate to sanitize( $value, 'TYPE' ).
	 * For example: $manager->sanitize_email( $email ) calls $manager->sanitize( $email, 'email' ).
	 *
	 * @param string $method The method name.
	 * @param array  $args The method arguments.
	 * @return mixed The sanitized value.
	 */
	public function __call( $method, $args ) {
		if ( strpos( $method, 'sanitize_' ) === 0 ) {
			$type = substr( $method, 9 );
			$value = $args[0] ?? '';
			return $this->sanitize( $value, $type );
		}

		throw new \BadMethodCallException( "Call to undefined method: $method" );
	}
}
