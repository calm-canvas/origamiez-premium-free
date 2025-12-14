<?php

namespace Origamiez\Engine\Layout;

class LayoutContainer {

	private bool $useFullwidth = false;

	public function __construct() {
		$this->useFullwidth = 1 === (int) get_theme_mod( 'use_layout_fullwidth', 0 );
	}

	public function openContainer(): void {
		echo $this->getOpenContainerHtml();
	}

	public function closeContainer(): void {
		echo $this->getCloseContainerHtml();
	}

	public function getOpenContainerHtml(): string {
		if ( $this->useFullwidth ) {
			return ''; 
		}
		return '<div class="container">';
	}

	public function getCloseContainerHtml(): string {
		if ( $this->useFullwidth ) {
			return '';
		}
		return '</div>';
	}

	public function isFullwidth(): bool {
		return $this->useFullwidth;
	}

	public function getLayoutClass(): string {
		return $this->useFullwidth ? 'origamiez-fluid' : 'origamiez-boxer';
	}

	public function register(): void {
		add_action( 'origamiez_after_body_open', [ $this, 'openContainer' ] );
		add_action( 'origamiez_before_body_close', [ $this, 'closeContainer' ] );
	}
}
