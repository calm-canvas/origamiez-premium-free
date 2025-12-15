<?php
namespace Origamiez\Engine\Security\Validators;

class LoginAttemptTracker {
	private $max_attempts = 5;
	private $lockout_duration = 15;
	private $transient_prefix = 'origamiez_login_attempts_';

	public function __construct( $max_attempts = 5, $lockout_duration = 15 ) {
		$this->max_attempts = $max_attempts;
		$this->lockout_duration = $lockout_duration;
	}

	public function setMaxAttempts( $max_attempts ) {
		$this->max_attempts = $max_attempts;
		return $this;
	}

	public function setLockoutDuration( $lockout_duration ) {
		$this->lockout_duration = $lockout_duration;
		return $this;
	}

	public function trackFailedAttempt( $username ) {
		$username = sanitize_user( $username );
		$attempts = $this->getAttempts( $username );
		$attempts++;

		set_transient(
			$this->transient_prefix . $username,
			$attempts,
			$this->lockout_duration * MINUTE_IN_SECONDS
		);

		return $attempts;
	}

	public function getAttempts( $username ) {
		$username = sanitize_user( $username );
		$attempts = get_transient( $this->transient_prefix . $username );
		return $attempts ? $attempts : 0;
	}

	public function isLocked( $username ) {
		$attempts = $this->getAttempts( $username );
		return $attempts >= $this->max_attempts;
	}

	public function clearAttempts( $username ) {
		$username = sanitize_user( $username );
		delete_transient( $this->transient_prefix . $username );
		return $this;
	}

	public function getRemainingAttempts( $username ) {
		$attempts = $this->getAttempts( $username );
		$remaining = $this->max_attempts - $attempts;
		return max( 0, $remaining );
	}

	public function getRemainingLockoutTime( $username ) {
		$username = sanitize_user( $username );
		$transient_name = $this->transient_prefix . $username;

		$expiration = get_transient( $transient_name );
		if ( ! $expiration ) {
			return 0;
		}

		return $this->lockout_duration;
	}
}
