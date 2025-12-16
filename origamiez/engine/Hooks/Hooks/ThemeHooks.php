<?php

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

class ThemeHooks implements HookProviderInterface {

	public function register( HookRegistry $registry ): void {
		$registry
			->addAction( 'init', array( $this, 'configTextDomain' ), 5 )
			->addAction( 'init', array( $this, 'registerTranslatedMenus' ), 20 )
			->addAction( 'updated_option', array( $this, 'saveUnysonOptions' ), 10, 3 );
	}

	public function configTextDomain(): void {
		load_theme_textdomain( 'origamiez', get_template_directory() . '/languages' );
	}

	public function registerTranslatedMenus(): void {
		register_nav_menus(
			array(
				'main-nav'   => esc_attr__( 'Main Menu', 'origamiez' ),
				'top-nav'    => esc_attr__( 'Top Menu (do not support sub-menu)', 'origamiez' ),
				'footer-nav' => esc_attr__( 'Footer Menu (do not support sub-menu)', 'origamiez' ),
				'mobile-nav' => esc_attr__( 'Mobile Menu (will be replace by Main Menu - if null).', 'origamiez' ),
			)
		);
	}

	public function saveUnysonOptions( string $optionName, mixed $oldValue, mixed $newValue ): void {
		if ( 'fw_theme_settings_options:origamiez' === $optionName ) {
			if ( is_array( $oldValue ) && is_array( $newValue ) ) {
				foreach ( $newValue as $key => $value ) {
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
