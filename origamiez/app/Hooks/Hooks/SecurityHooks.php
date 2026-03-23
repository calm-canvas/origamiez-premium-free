<?php
/**
 * Security Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Hooks\Hooks;

use Origamiez\Hooks\HookProviderInterface;
use Origamiez\Hooks\HookRegistry;
use Psr\Container\ContainerInterface;

/**
 * Class SecurityHooks
 *
 * @package Origamiez\Hooks\Hooks
 */
class SecurityHooks implements HookProviderInterface {

	/**
	 * Container
	 *
	 * @var ContainerInterface
	 */
	private ContainerInterface $container;

	/**
	 * SecurityHooks constructor.
	 *
	 * @param ContainerInterface $container The container.
	 */
	public function __construct( ContainerInterface $container ) {
		$this->container = $container;
	}

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		$registry
			->add_action( 'pre_get_posts', array( $this, 'sanitize_search_query' ) )
			->add_action( 'send_headers', array( $this, 'add_security_headers' ) )
			->add_action( 'wp_login_failed', array( $this, 'track_failed_login' ) )
			->add_action( 'wp_login', array( $this, 'clear_login_attempts' ) );
	}

	/**
	 * Sanitize search query.
	 *
	 * @param \WP_Query $query The query object.
	 *
	 * @return void
	 */
	public function sanitize_search_query( \WP_Query $query ): void {
		if ( $query->is_search() && ! is_admin() && $query->is_main_query() ) {
			$search_term = $query->get( 's' );
			if ( ! empty( $search_term ) ) {
				$sanitized_term = sanitize_text_field( $search_term );
				$sanitized_term = substr( $sanitized_term, 0, 100 );
				$query->set( 's', $sanitized_term );
			}
		}
	}

	/**
	 * Add security headers.
	 *
	 * @return void
	 */
	public function add_security_headers(): void {
		if ( ! is_admin() ) {
			header( 'X-Content-Type-Options: nosniff' );
			header( 'X-Frame-Options: SAMEORIGIN' );
			header( 'X-XSS-Protection: 1; mode=block' );
			header( 'Referrer-Policy: strict-origin-when-cross-origin' );

			$csp  = "default-src 'self'; ";
			$csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com; ";
			$csp .= "style-src 'self' 'unsafe-inline' *.googleapis.com *.gstatic.com; ";
			$csp .= 'img-src ' . $this->build_csp_img_src() . '; ';
			$csp .= "font-src 'self' data: *.googleapis.com *.gstatic.com; ";
			$csp .= "worker-src 'self' blob:; ";
			$csp .= "connect-src 'self'; ";
			$csp .= "frame-src 'self' *.youtube.com *.vimeo.com; ";
			$csp .= "object-src 'none'; ";
			$csp .= "base-uri 'self';";

			header( 'Content-Security-Policy: ' . $csp );
		}
	}

	/**
	 * Builds img-src for CSP. Includes HTTP and HTTPS origins for the site host so media URLs
	 * that use a different scheme than the current page (common WordPress mixed-content cases)
	 * still match. Adds the uploads base URL origin when it differs (e.g. CDN).
	 *
	 * @return string Space-separated CSP source list (no directive name).
	 */
	private function build_csp_img_src(): string {
		$sources = array( "'self'", 'data:', '*.gravatar.com', '*.wp.com' );

		$home      = home_url();
		$home_host = wp_parse_url( $home, PHP_URL_HOST );
		if ( ! empty( $home_host ) ) {
			$port      = wp_parse_url( $home, PHP_URL_PORT );
			$port_part = $port ? ':' . $port : '';
			$sources[] = 'http://' . $home_host . $port_part; // NOSONAR
			$sources[] = 'https://' . $home_host . $port_part;
		}

		$upload_dir = wp_upload_dir();
		if ( empty( $upload_dir['error'] ) && ! empty( $upload_dir['baseurl'] ) ) {
			$upload_origin = $this->csp_origin_from_url( $upload_dir['baseurl'] );
			if ( null !== $upload_origin ) {
				$sources[] = $upload_origin;
			}
		}

		return implode( ' ', array_unique( $sources ) );
	}

	/**
	 * Returns a CSP host source (scheme://host:port) for a full URL.
	 *
	 * @param string $url Full URL.
	 * @return string|null Origin string or null if the URL has no host.
	 */
	private function csp_origin_from_url( string $url ): ?string {
		$parts = wp_parse_url( $url );
		if ( empty( $parts['host'] ) ) {
			return null;
		}
		$scheme = isset( $parts['scheme'] ) ? $parts['scheme'] : 'http';
		$host   = $parts['host'];
		$port   = isset( $parts['port'] ) ? ':' . $parts['port'] : '';

		return $scheme . '://' . $host . $port;
	}

	/**
	 * Track failed login.
	 *
	 * @param string $username The username.
	 *
	 * @return void
	 */
	public function track_failed_login( string $username ): void {
		$username = sanitize_user( $username );
		$attempts = get_transient( 'origamiez_login_attempts_' . $username );
		$attempts = $attempts ? $attempts + 1 : 1;
		set_transient( 'origamiez_login_attempts_' . $username, $attempts, 15 * MINUTE_IN_SECONDS );
	}

	/**
	 * Clear login attempts.
	 *
	 * @param string $user_login The user login.
	 *
	 * @return void
	 */
	public function clear_login_attempts( string $user_login ): void {
		delete_transient( 'origamiez_login_attempts_' . sanitize_user( $user_login ) );
	}
}
