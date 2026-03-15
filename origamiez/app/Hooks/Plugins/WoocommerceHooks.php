<?php
/**
 * WooCommerce Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Hooks\Plugins;

use Origamiez\Hooks\HookProviderInterface;
use Origamiez\Hooks\HookRegistry;

/**
 * Class WoocommerceHooks
 *
 * @package Origamiez\Hooks\Plugins
 */
class WoocommerceHooks implements HookProviderInterface {

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$registry->add_action( 'after_setup_theme', array( $this, 'setup_theme' ), 20 );
	}

	/**
	 * Sets up WooCommerce theme support.
	 *
	 * @return void
	 */
	public function setup_theme(): void {
		add_theme_support( 'woocommerce' );

		if ( ! is_admin() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ) );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ) );
			add_filter( 'woocommerce_cart_item_quantity', array( $this, 'cart_item_quantity' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
		}
	}

	/**
	 * Filters WooCommerce cart item quantity.
	 *
	 * @param string $product_quantity The product quantity.
	 *
	 * @return string
	 */
	public function cart_item_quantity( string $product_quantity ): string {
		return str_replace( 'number', 'text', $product_quantity );
	}

	/**
	 * Enqueues WooCommerce scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$dir = get_template_directory_uri();
		wp_enqueue_script( ORIGAMIEZ_PREFIX . 'touchspin', "{$dir}/plugins/woocommerce/js/touchspin.js", array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * Filters WooCommerce shop loop columns.
	 *
	 * @return int The number of columns.
	 */
	public function loop_shop_columns(): int {
		return 3;
	}

	/**
	 * Filters WooCommerce shop loop per page.
	 *
	 * @return int The number of items per page.
	 */
	public function loop_shop_per_page(): int {
		return 12;
	}
}
