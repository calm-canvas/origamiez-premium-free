<?php
/**
 * Theme Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

/**
 * Class ThemeHooks
 *
 * @package Origamiez\Engine\Hooks\Hooks
 */
class ThemeHooks implements HookProviderInterface {

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		$registry
			->add_action( 'init', array( $this, 'config_text_domain' ), 5 )
			->add_action( 'init', array( $this, 'register_translated_menus' ), 20 )
			->add_action( 'updated_option', array( $this, 'save_unyson_options' ), 10, 3 );
	}

	/**
	 * Config text domain.
	 *
	 * @return void
	 */
	public function config_text_domain(): void {
		load_theme_textdomain( 'origamiez', get_template_directory() . '/languages' );
	}

	/**
	 * Register translated menus.
	 *
	 * @return void
	 */
	public function register_translated_menus(): void {
		register_nav_menus(
			array(
				'main-nav'   => esc_attr__( 'Main Menu', 'origamiez' ),
				'top-nav'    => esc_attr__( 'Top Menu (do not support sub-menu)', 'origamiez' ),
				'footer-nav' => esc_attr__( 'Footer Menu (do not support sub-menu)', 'origamiez' ),
				'mobile-nav' => esc_attr__( 'Mobile Menu (will be replace by Main Menu - if null).', 'origamiez' ),
			)
		);
	}

	/**
	 * Save unyson options.
	 *
	 * @param string $option_name The option name.
	 * @param mixed  $old_value The old value.
	 * @param mixed  $new_value The new value.
	 *
	 * @return void
	 */
	public function save_unyson_options( string $option_name, mixed $old_value, mixed $new_value ): void {
		if ( 'fw_theme_settings_options:origamiez' === $option_name ) {
			if ( is_array( $old_value ) && is_array( $new_value ) ) {
				foreach ( $new_value as $key => $value ) {
					if ( $key === 'logo' ) {
						if ( isset( $value['url'] ) && isset( $value['attachment_id'] ) ) {
							$value = esc_url( $value['url'] );
						}
					}
					set_theme_mod( $key, $value );
				}
			}
		}
	}
}
