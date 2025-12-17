<?php
/**
 * Woocommerce compatibility.
 *
 * @package    Origamiez
 * @subpackage Origamiez/Plugins
 */

if ( class_exists( 'WooCommerce' ) ) {

	add_action( 'after_setup_theme', 'origamiez_woocommerce_setup', 20 );

	/**
	 * Woocommerce setup.
	 */
	function origamiez_woocommerce_setup() {
		add_theme_support( 'woocommerce' );

		if ( ! is_admin() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_filter( 'loop_shop_columns', 'origamiez_woocommerce_loop_shop_columns' );
			add_filter( 'loop_shop_per_page', 'origamiez_woocommerce_loop_shop_per_page' );
			add_filter( 'woocommerce_cart_item_quantity', 'origamiez_woocommerce_cart_item_quantity' );
			add_action( 'wp_enqueue_scripts', 'origamiez_woocommerce_enqueue_scripts', 20 );
		}
	}

	/**
	 * Change the cart item quantity input type to text.
	 *
	 * @param string $product_quantity The product quantity input.
	 *
	 * @return string
	 */
	function origamiez_woocommerce_cart_item_quantity( $product_quantity ) {
		$product_quantity = str_replace( 'number', 'text', $product_quantity );
		return $product_quantity;
	}

	/**
	 * Enqueue scripts for woocommerce.
	 */
	function origamiez_woocommerce_enqueue_scripts() {
		global $wp_styles, $is_IE;
		$dir = get_template_directory_uri();

		wp_enqueue_script( ORIGAMIEZ_PREFIX . 'touchspin', "{$dir}/plugins/woocommerce/js/touchspin.js", array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * Set the number of columns for the shop loop.
	 *
	 * @return int
	 */
	function origamiez_woocommerce_loop_shop_columns() {
		return 3;
	}

	/**
	 * Set the number of products per page for the shop loop.
	 *
	 * @return int
	 */
	function origamiez_woocommerce_loop_shop_per_page() {
		return 12;
	}
}
