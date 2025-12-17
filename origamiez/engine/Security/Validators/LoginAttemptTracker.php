<?php
/**
 * Login attempt tracker.
 *
 * @package    Origamiez
 * @subpackage Origamiez/Engine/Security/Validators
 */

namespace Origamiez\Engine\Security\Validators;

/**
 * Class LoginAttemptTracker
 *
 * @package Origamiez\Engine\Security\Validators
 */
class LoginAttemptTracker {
	/**
	 * Max login attempts.
	 *
	 * @var int
	 */
	private $max_attempts = 5;
	/**
	 * Lockout duration in minutes.
	 *
	 * @var int
	 */
	private $lockout_duration = 15;
	/**
	 * Transient prefix.
	 *
	 * @var string
	 */
	private $transient_prefix = 'origamiez_login_attempts_';

	/**
	 * LoginAttemptTracker constructor.
	 *
	 * @param int $max_attempts     Max login attempts.
	 * @param int $lockout_duration Lockout duration in minutes.
	 */
	public function __construct( $max_attempts = 5, $lockout_duration = 15 ) {
		$this->max_attempts     = $max_attempts;
		$this->lockout_duration = $lockout_duration;
	}

	/**
	 * Set max attempts.
	 *
	 * @param int $max_attempts Max attempts.
	 *
	 * @return $this
	 */
	public function set_max_attempts( $max_attempts ) {
		$this->max_attempts = $max_attempts;
		return $this;
	}

	/**
	 * Set lockout duration.
	 *
	 * @param int $lockout_duration Lockout duration in minutes.
	 *
	 * @return $this
	 */
	public function set_lockout_duration( $lockout_duration ) {
		$this->lockout_duration = $lockout_duration;
		return $this;
	}

	/**
	 * Track failed login attempt.
	 *
	 * @param string $username The username.
	 *
	 * @return int
	 */
	public function track_failed_attempt( $username ) {
		$username = sanitize_user( $username );
		$attempts = $this->get_attempts( $username );
		++$attempts;

		set_transient(
			$this->transient_prefix . $username,
			$attempts,
			$this->lockout_duration * MINUTE_IN_SECONDS
		);

		return $attempts;
	}

	/**
	 * Get login attempts.
	 *
	 * @param string $username The username.
	 *
	 * @return int
	 */
	public function get_attempts( $username ) {
		$username = sanitize_user( $username );
		$attempts = get_transient( $this->transient_prefix . $username );
		return $attempts ? (int) $attempts : 0;
	}

	/**
	 * Check if the user is locked out.
	 *
	 * @param string $username The username.
	 *
	 * @return bool
	 */
	public function is_locked( $username ) {
		$attempts = $this->get_attempts( $username );
		return $attempts >= $this->max_attempts;
	}

	/**
	 * Clear login attempts.
	 *
	 * @param string $username The username.
	 *
	 * @return $this
	 */
	public function clear_attempts( $username ) {
		$username = sanitize_user( $username );
		delete_transient( $this->transient_prefix . $username );
		return $this;
	}

	/**
	 * Get remaining login attempts.
	 *
	 * @param string $username The username.
	 *
	 * @return int
	 */
	public function get_remaining_attempts( $username ) {
		$attempts  = $this->get_attempts( $username );
		$remaining = $this->max_attempts - $attempts;
		return max( 0, $remaining );
	}

	/**
	 * Get remaining lockout time.
	 *
	 * @param string $username The username.
	 *
	 * @return int
	 */
	public function get_remaining_lockout_time( $username ) {
		$username       = sanitize_user( $username );
		$transient_name = $this->transient_prefix . $username;

		$expiration = get_option( '_transient_timeout_' . $transient_name );
		if ( false === $expiration ) {
			return 0;
		}

		$remaining = $expiration - time();
		return max( 0, $remaining );
	}
}
