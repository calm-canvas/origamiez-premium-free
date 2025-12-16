<?php

namespace Origamiez\Engine\Helpers;

class OptionsSyncHelper {

	public static function syncUnysonOptions( array $newValues ): void {
		foreach ( $newValues as $key => $value ) {
			if ( 'logo' === $key ) {
				if ( isset( $value['url'] ) && isset( $value['attachment_id'] ) ) {
					$value = esc_url( $value['url'] );
				}
			}
			set_theme_mod( $key, $value );
		}
	}

	public static function getOption( string $key, mixed $default = false ): mixed {
		return get_option( $key, $default );
	}

	public static function setOption( string $key, mixed $value ): bool {
		return update_option( $key, $value );
	}

	public static function getThemeMod( string $key, mixed $default = false ): mixed {
		return get_theme_mod( $key, $default );
	}

	public static function setThemeMod( string $key, mixed $value ): void {
		set_theme_mod( $key, $value );
	}

	public static function deleteThemeMod( string $key ): void {
		remove_theme_mod( $key );
	}
}
