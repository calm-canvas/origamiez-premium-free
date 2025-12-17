<?php
/**
 * Search query validator.
 *
 * @package    Origamiez
 * @subpackage Origamiez/Engine/Security/Validators
 */

namespace Origamiez\Engine\Security\Validators;

/**
 * Class SearchQueryValidator
 *
 * @package Origamiez\Engine\Security\Validators
 */
class SearchQueryValidator implements ValidatorInterface {
	/**
	 * Max length of the search query.
	 *
	 * @var int
	 */
	private $max_length = 100;
	/**
	 * Min length of the search query.
	 *
	 * @var int
	 */
	private $min_length = 1;

	/**
	 * SearchQueryValidator constructor.
	 *
	 * @param int $max_length Max length of the search query.
	 * @param int $min_length Min length of the search query.
	 */
	public function __construct( $max_length = 100, $min_length = 1 ) {
		$this->max_length = $max_length;
		$this->min_length = $min_length;
	}

	/**
	 * Set max length.
	 *
	 * @param int $max_length Max length.
	 *
	 * @return $this
	 */
	public function setMaxLength( $max_length ) {
		$this->max_length = $max_length;
		return $this;
	}

	/**
	 * Set min length.
	 *
	 * @param int $min_length Min length.
	 *
	 * @return $this
	 */
	public function setMinLength( $min_length ) {
		$this->min_length = $min_length;
		return $this;
	}

	/**
	 * Validate the search query.
	 *
	 * @param string $query The search query.
	 *
	 * @return bool
	 */
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

	/**
	 * Check if the query is valid.
	 *
	 * @param string $query The search query.
	 *
	 * @return bool
	 */
	public function isValid( $query ) {
		return $this->validate( $query );
	}

	/**
	 * Sanitize the search query.
	 *
	 * @param string $query The search query.
	 *
	 * @return string
	 */
	public function sanitizeQuery( $query ) {
		if ( ! $this->validate( $query ) ) {
			return '';
		}

		$query = sanitize_text_field( $query );
		$query = substr( $query, 0, $this->max_length );

		return $query;
	}
}
