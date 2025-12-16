<?php
namespace Origamiez\Engine\Security;

use Origamiez\Engine\Security\Sanitizers\SanitizerInterface;
use Origamiez\Engine\Security\Sanitizers\CheckboxSanitizer;
use Origamiez\Engine\Security\Sanitizers\SelectSanitizer;
use Origamiez\Engine\Security\Sanitizers\TextAreaSanitizer;
use Origamiez\Engine\Security\Sanitizers\UrlSanitizer;
use Origamiez\Engine\Security\Sanitizers\EmailSanitizer;
use Origamiez\Engine\Security\Sanitizers\TextSanitizer;

class SanitizationManager {
	private static $instance = null;
	private $sanitizers      = array();

	private function __construct() {
		$this->registerDefaultSanitizers();
	}

	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function registerDefaultSanitizers() {
		$this->register( 'checkbox', new CheckboxSanitizer() );
		$this->register( 'text', new TextSanitizer() );
		$this->register( 'email', new EmailSanitizer() );
		$this->register( 'url', new UrlSanitizer() );
		$this->register( 'textarea', new TextAreaSanitizer() );
		$this->register( 'select', new SelectSanitizer() );
	}

	public function register( $type, SanitizerInterface $sanitizer ) {
		$this->sanitizers[ $type ] = $sanitizer;
		return $this;
	}

	public function sanitize( $value, $type = 'text' ) {
		if ( ! isset( $this->sanitizers[ $type ] ) ) {
			$type = 'text';
		}

		return $this->sanitizers[ $type ]->sanitize( $value );
	}

	public function getSanitizer( $type ) {
		return isset( $this->sanitizers[ $type ] ) ? $this->sanitizers[ $type ] : null;
	}

	public function has( $type ) {
		return isset( $this->sanitizers[ $type ] );
	}

	public function sanitizeSelect( $value, $choices = array(), $default = '' ) {
		$sanitizer = $this->sanitizers['select'];
		if ( $sanitizer instanceof SelectSanitizer ) {
			$sanitizer->setChoices( $choices )->setDefault( $default );
		}
		return $sanitizer->sanitize( $value );
	}

	public function sanitizeCheckbox( $value ) {
		return $this->sanitize( $value, 'checkbox' );
	}

	public function sanitizeText( $value ) {
		return $this->sanitize( $value, 'text' );
	}

	public function sanitizeEmail( $value ) {
		return $this->sanitize( $value, 'email' );
	}

	public function sanitizeUrl( $value ) {
		return $this->sanitize( $value, 'url' );
	}

	public function sanitizeTextarea( $value ) {
		return $this->sanitize( $value, 'textarea' );
	}
}
