<?php

if(class_exists('WooCommerce')){
	
	add_action('after_setup_theme', 'origamiez_woocommerce_setup', 20);

	function origamiez_woocommerce_setup() {
		add_theme_support('woocommerce');		
			 
		if (!is_admin()) {
			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
			add_filter('loop_shop_columns', 'origamiez_woocommerce_loop_shop_columns');
			add_filter('loop_shop_per_page',  'origamiez_woocommerce_loop_shop_per_page');
			add_filter('woocommerce_cart_item_quantity', 'origamiez_woocommerce_cart_item_quantity');
			add_action('wp_enqueue_scripts', 'origamiez_woocommerce_enqueue_scripts', 20);
		}	
	}

	function origamiez_woocommerce_cart_item_quantity($product_quantity){		
		$product_quantity = str_replace('number', 'text', $product_quantity);
		return $product_quantity;
	}

	function origamiez_woocommerce_enqueue_scripts(){
		global $wp_styles, $is_IE;
		$dir   = get_template_directory_uri();		

		wp_enqueue_script(ORIGAMIEZ_PREFIX . 'touchspin', "{$dir}/plugins/woocommerce/js/touchspin.js", array('jquery'), NULL, TRUE);		
	}

	function origamiez_woocommerce_loop_shop_columns(){
		return 3;
	}

	function origamiez_woocommerce_loop_shop_per_page(){
		return 12;
	}
}