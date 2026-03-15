<?php
/**
 * Frontend Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Hooks\Hooks;

use Origamiez\Hooks\HookProviderInterface;
use Origamiez\Hooks\HookRegistry;
use Psr\Container\ContainerInterface;

/**
 * Class FrontendHooks
 *
 * @package Origamiez\Hooks\Hooks
 */
class FrontendHooks implements HookProviderInterface {

	/**
	 * Container
	 *
	 * @var ContainerInterface
	 */
	private ContainerInterface $container;

	/**
	 * FrontendHooks constructor.
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
			->add_action( 'init', array( $this, 'widget_order_class' ) )
			->add_filter( 'post_class', array( $this, 'archive_post_class' ) )
			->add_filter( 'excerpt_more', '__return_false' )
			->add_filter( 'wp_nav_menu_objects', array( $this, 'add_first_and_last_class_for_menu_item' ) )
			->add_filter( 'wp_get_attachment_image_attributes', array( $this, 'strip_image_dimensions' ) )
			->add_action( 'origamiez_after_body_open', array( $this, 'global_wrapper_open' ) )
			->add_action( 'origamiez_before_body_close', array( $this, 'global_wrapper_close' ) )
			->add_action( 'origamiez_print_button_readmore', array( $this, 'get_button_readmore' ) );
	}

	/**
	 * Widget order class.
	 *
	 * @return void
	 */
	public function widget_order_class(): void {
		$widget_class_manager = $this->container->get( 'widget_class_manager' );
		$widget_class_manager->add_widget_order_classes();
	}

	/**
	 * Archive post class.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function archive_post_class( array $classes ): array {
		global $wp_query;
		if ( 0 === $wp_query->current_post ) {
			$classes[] = 'origamiez-first-post';
		}
		$manager = $this->container->get( 'post_class_manager' );
		return $manager->get_post_classes( $classes );
	}

	/**
	 * Add first and last class for menu item.
	 *
	 * @param array $items The items.
	 *
	 * @return array
	 */
	public function add_first_and_last_class_for_menu_item( array $items ): array {
		if ( empty( $items ) ) {
			return $items;
		}

		$first_key = array_key_first( $items );
		$last_key  = array_key_last( $items );

		$items[ $first_key ]->classes[] = 'origamiez-menuitem-first';
		$items[ $last_key ]->classes[]  = 'origamiez-menuitem-last';

		return $items;
	}

	/**
	 * Strip image dimensions.
	 *
	 * @param array $attr The attributes.
	 *
	 * @return array
	 */
	public function strip_image_dimensions( array $attr ): array {
		unset( $attr['width'], $attr['height'] );
		return $attr;
	}

	/**
	 * Global wrapper open.
	 *
	 * @return void
	 */
	public function global_wrapper_open(): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			echo '<div class="container">';
		}
	}

	/**
	 * Global wrapper close.
	 *
	 * @return void
	 */
	public function global_wrapper_close(): void {
		if ( 1 !== (int) get_theme_mod( 'use_layout_fullwidth', 0 ) ) {
			echo '</div>';
		}
	}

	/**
	 * Get button readmore.
	 *
	 * @return void
	 */
	public function get_button_readmore(): void {
		$button = $this->container->get( 'read_more_button' );
		$button->display();
	}
}
