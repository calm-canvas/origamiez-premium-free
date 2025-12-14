<?php

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

class FrontendHooks implements HookProviderInterface {

	public function register( HookRegistry $registry ): void {
		$registry
			->addAction( 'init', [ $this, 'widgetOrderClass' ] )
			->addFilter( 'body_class', [ $this, 'bodyClass' ] )
			->addFilter( 'post_class', [ $this, 'archivePostClass' ] )
			->addFilter( 'excerpt_more', '__return_false' )
			->addFilter( 'wp_nav_menu_objects', [ $this, 'addFirstAndLastClassForMenuItem' ] )
			->addFilter( 'post_thumbnail_html', [ $this, 'removeHardcodedImageSize' ] )
			->addFilter( 'dynamic_sidebar_params', [ $this, 'dynamicSidebarParams' ] )
			->addAction( 'origamiez_after_body_open', [ $this, 'globalWrapperOpen' ] )
			->addAction( 'origamiez_before_body_close', [ $this, 'globalWrapperClose' ] )
			->addAction( 'origamiez_print_breadcrumb', [ $this, 'getBreadcrumb' ] )
			->addAction( 'origamiez_print_button_readmore', [ $this, 'getButtonReadmore' ] );
	}

	public function widgetOrderClass(): void {
	}

	public function bodyClass( array $classes ): array {
		return $classes;
	}

	public function archivePostClass( array $classes ): array {
		return $classes;
	}

	public function addFirstAndLastClassForMenuItem( array $items ): array {
		return $items;
	}

	public function removeHardcodedImageSize( string $html ): string {
		return $html;
	}

	public function dynamicSidebarParams( array $params ): array {
		return $params;
	}

	public function globalWrapperOpen(): void {
	}

	public function globalWrapperClose(): void {
	}

	public function getBreadcrumb(): void {
	}

	public function getButtonReadmore(): void {
	}
}
