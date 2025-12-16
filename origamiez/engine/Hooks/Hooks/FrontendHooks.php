<?php

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Container;
use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

class FrontendHooks implements HookProviderInterface {

	private Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

	public function register( HookRegistry $registry ): void {
		$registry
			->addAction( 'init', [ $this, 'widgetOrderClass' ] )
			->addFilter( 'post_class', [ $this, 'archivePostClass' ] )
			->addFilter( 'excerpt_more', '__return_false' )
			->addFilter( 'wp_nav_menu_objects', [ $this, 'addFirstAndLastClassForMenuItem' ] )
			->addFilter( 'post_thumbnail_html', [ $this, 'removeHardcodedImageSize' ] )
			->addAction( 'origamiez_after_body_open', [ $this, 'globalWrapperOpen' ] )
			->addAction( 'origamiez_before_body_close', [ $this, 'globalWrapperClose' ] )
			->addAction( 'origamiez_print_button_readmore', [ $this, 'getButtonReadmore' ] );
	}

	public function widgetOrderClass(): void {
		$widgetClassManager = $this->container->get( 'widget_class_manager' );
		$widgetClassManager->addWidgetOrderClasses();
	}

	public function archivePostClass( array $classes ): array {
		global $wp_query;
		if ( 0 === $wp_query->current_post ) {
			$classes[] = 'origamiez-first-post';
		}
		$manager = $this->container->get( 'post_class_manager' );
		return $manager->getPostClasses( $classes );
	}

	public function addFirstAndLastClassForMenuItem( array $items ): array {
		$items[1]->classes[] = 'origamiez-menuitem-first';
		$items[ count( $items ) ]->classes[] = 'origamiez-menuitem-last';
		return $items;
	}

	public function removeHardcodedImageSize( string $html ): string {
		return preg_replace( '/(width|height)="\d+"\s/', '', $html );
	}

	public function globalWrapperOpen(): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			echo '<div class="container">';
		}
	}

	public function globalWrapperClose(): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			echo '</div>';
		}
	}

	public function getButtonReadmore(): void {
		$button = $this->container->get( 'read_more_button' );
		$button->display();
	}
}
