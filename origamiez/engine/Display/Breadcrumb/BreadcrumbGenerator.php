<?php
/**
 * Breadcrumb Generator
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb;

/**
 * Class BreadcrumbGenerator
 *
 * @package Origamiez\Engine\Display\Breadcrumb
 */
class BreadcrumbGenerator {

	/**
	 * Builder.
	 *
	 * @var BreadcrumbBuilder
	 */
	private BreadcrumbBuilder $builder;

	/**
	 * BreadcrumbGenerator constructor.
	 */
	public function __construct() {
		$this->builder = new BreadcrumbBuilder();
	}

	/**
	 * Generate breadcrumb.
	 *
	 * @return string
	 */
	public function generate_breadcrumb(): string {
		return $this->builder->build();
	}

	/**
	 * Display breadcrumb.
	 *
	 * @return void
	 */
	public function display_breadcrumb(): void {
		echo wp_kses_post( $this->generate_breadcrumb() );
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'origamiez_print_breadcrumb', array( $this, 'display_breadcrumb' ) );
	}
}
