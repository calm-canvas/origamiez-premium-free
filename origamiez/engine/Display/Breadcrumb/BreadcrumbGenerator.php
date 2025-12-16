<?php

namespace Origamiez\Engine\Display\Breadcrumb;

class BreadcrumbGenerator {

	private BreadcrumbBuilder $builder;

	public function __construct() {
		$this->builder = new BreadcrumbBuilder();
	}

	public function generateBreadcrumb(): string {
		return $this->builder->build();
	}

	public function displayBreadcrumb(): void {
		echo wp_kses_post( $this->generateBreadcrumb() );
	}

	public function register(): void {
		add_action( 'origamiez_print_breadcrumb', array( $this, 'displayBreadcrumb' ) );
	}
}
