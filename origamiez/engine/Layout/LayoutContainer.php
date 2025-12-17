<?php
/**
 * Layout Container
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout;

/**
 * Class LayoutContainer
 *
 * @package Origamiez\Engine\Layout
 */
class LayoutContainer {

	/**
	 * Use fullwidth.
	 *
	 * @var boolean
	 */
	private bool $use_fullwidth = false;

	/**
	 * LayoutContainer constructor.
	 */
	public function __construct() {
		$this->use_fullwidth = 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 );
	}

	/**
	 * Open container.
	 *
	 * @return void
	 */
	public function open_container(): void {
		wp_kses_post( $this->get_open_container_html() );
	}

	/**
	 * Close container.
	 *
	 * @return void
	 */
	public function close_container(): void {
		wp_kses_post( $this->get_close_container_html() );
	}

	/**
	 * Get open container html.
	 *
	 * @return string
	 */
	public function get_open_container_html(): string {
		if ( $this->use_fullwidth ) {
			return '';
		}
		return '<div class="container">';
	}

	/**
	 * Get close container html.
	 *
	 * @return string
	 */
	public function get_close_container_html(): string {
		if ( $this->use_fullwidth ) {
			return '';
		}
		return '</div>';
	}

	/**
	 * Is fullwidth.
	 *
	 * @return boolean
	 */
	public function is_fullwidth(): bool {
		return $this->use_fullwidth;
	}

	/**
	 * Get layout class.
	 *
	 * @return string
	 */
	public function get_layout_class(): string {
		return $this->use_fullwidth ? 'origamiez-fluid' : 'origamiez-boxer';
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'origamiez_after_body_open', array( $this, 'open_container' ) );
		add_action( 'origamiez_before_body_close', array( $this, 'close_container' ) );
	}
}
