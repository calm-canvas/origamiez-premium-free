<?php
namespace Origamiez\Engine\Security\Validators;

class SearchQueryValidator implements ValidatorInterface {
	private $max_length = 100;
	private $min_length = 1;

	public function __construct( $max_length = 100, $min_length = 1 ) {
		$this->max_length = $max_length;
		$this->min_length = $min_length;
	}

	public function setMaxLength( $max_length ) {
		$this->max_length = $max_length;
		return $this;
	}

	public function setMinLength( $min_length ) {
		$this->min_length = $min_length;
		return $this;
	}

	public function validate( $query ) {
		if ( empty( $query ) ) {
			return false;
		}

		$query = sanitize_text_field( $query );

		if ( strlen( $query ) < $this->min_length || strlen( $query ) > $this->max_length ) {
			return false;
		}

		return true;
	}

	public function isValid( $query ) {
		return $this->validate( $query );
	}

	public function sanitizeQuery( $query ) {
		if ( ! $this->validate( $query ) ) {
			return '';
		}

		$query = sanitize_text_field( $query );
		$query = substr( $query, 0, $this->max_length );

		return $query;
	}
}
