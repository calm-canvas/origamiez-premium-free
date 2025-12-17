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
	 * Sanitizes a select input.
	 *
	 * @param mixed $value   The value to sanitize.
	 * @param array $choices The allowed choices.
	 * @param mixed $default_value The default value.
	 * @return mixed
	 */
	public function sanitize_select( $value, $choices = array(), $default_value = '' ) {
		$sanitizer = $this->sanitizers['select'];
		if ( $sanitizer instanceof SelectSanitizer ) {
			$sanitizer->setChoices( $choices )->setDefault( $default_value );
		}
		return $sanitizer->sanitize( $value );
	}

	/**
	 * Sanitizes a checkbox input.
	 *
	 * @param mixed $value The value to sanitize.
	 * @return mixed
	 */
	public function sanitize_checkbox( $value ) {
		return $this->sanitize( $value, 'checkbox' );
	}

	/**
	 * Sanitizes a text input.
	 *
	 * @param mixed $value The value to sanitize.
	 * @return mixed
	 */
	public function sanitize_text( $value ) {
		return $this->sanitize( $value, 'text' );
	}

	/**
	 * Sanitizes an email input.
	 *
	 * @param mixed $value The value to sanitize.
	 * @return mixed
	 */
	public function sanitize_email( $value ) {
		return $this->sanitize( $value, 'email' );
	}

	/**
	 * Sanitizes a URL input.
	 *
	 * @param mixed $value The value to sanitize.
	 * @return mixed
	 */
	public function sanitize_url( $value ) {
		return $this->sanitize( $value, 'url' );
	}

	/**
	 * Sanitizes a textarea input.
	 *
	 * @param mixed $value The value to sanitize.
	 * @return mixed
	 */
	public function sanitize_textarea( $value ) {
		return $this->sanitize( $value, 'textarea' );
	}
}
