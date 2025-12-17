<?php
/**
 * Customizer Functions - Typography and Color Settings
 *
 * @package Origamiez
 */

if ( ! function_exists( 'origamiez_get_font_families' ) ) {
	/**
	 * Get font families.
	 *
	 * @return array
	 */
	function origamiez_get_font_families(): array {
		return array(
			''                => esc_attr__( 'Default', 'origamiez' ),
			'Arial'           => 'Arial',
			'Verdana'         => 'Verdana',
			'Times New Roman' => 'Times New Roman',
			'Courier New'     => 'Courier New',
			'Georgia'         => 'Georgia',
			'Palatino'        => 'Palatino',
			'Garamond'        => 'Garamond',
			'Bookman'         => 'Bookman',
			'Comic Sans MS'   => 'Comic Sans MS',
			'Trebuchet MS'    => 'Trebuchet MS',
			'Impact'          => 'Impact',
			'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif' => esc_attr__( 'System Font Stack', 'origamiez' ),
		);
	}
}

if ( ! function_exists( 'origamiez_get_font_sizes' ) ) {
	/**
	 * Get font sizes.
	 *
	 * @return array
	 */
	function origamiez_get_font_sizes(): array {
		$sizes = array();
		for ( $i = 10; $i <= 72; $i++ ) {
			$sizes[ "{$i}px" ] = "{$i}px";
		}
		return $sizes;
	}
}

if ( ! function_exists( 'origamiez_get_font_styles' ) ) {
	/**
	 * Get font styles.
	 *
	 * @return array
	 */
	function origamiez_get_font_styles(): array {
		return array(
			''        => esc_attr__( 'Default', 'origamiez' ),
			'normal'  => esc_attr__( 'Normal', 'origamiez' ),
			'italic'  => esc_attr__( 'Italic', 'origamiez' ),
			'oblique' => esc_attr__( 'Oblique', 'origamiez' ),
		);
	}
}

if ( ! function_exists( 'origamiez_get_font_weights' ) ) {
	/**
	 * Get font weights.
	 *
	 * @return array
	 */
	function origamiez_get_font_weights(): array {
		return array(
			''    => esc_attr__( 'Default', 'origamiez' ),
			'100' => esc_attr__( 'Thin (100)', 'origamiez' ),
			'200' => esc_attr__( 'Extra Light (200)', 'origamiez' ),
			'300' => esc_attr__( 'Light (300)', 'origamiez' ),
			'400' => esc_attr__( 'Normal (400)', 'origamiez' ),
			'500' => esc_attr__( 'Medium (500)', 'origamiez' ),
			'600' => esc_attr__( 'Semi Bold (600)', 'origamiez' ),
			'700' => esc_attr__( 'Bold (700)', 'origamiez' ),
			'800' => esc_attr__( 'Extra Bold (800)', 'origamiez' ),
			'900' => esc_attr__( 'Black (900)', 'origamiez' ),
		);
	}
}

if ( ! function_exists( 'origamiez_get_font_line_heighs' ) ) {
	/**
	 * Get font line heights.
	 *
	 * @return array
	 */
	function origamiez_get_font_line_heighs(): array {
		return array(
			''    => esc_attr__( 'Default', 'origamiez' ),
			'1'   => '1',
			'1.2' => '1.2',
			'1.3' => '1.3',
			'1.4' => '1.4',
			'1.5' => '1.5',
			'1.6' => '1.6',
			'1.7' => '1.7',
			'1.8' => '1.8',
			'2'   => '2',
			'2.5' => '2.5',
			'3'   => '3',
		);
	}
}

if ( ! function_exists( 'origamiez_font_body_enable_callback' ) ) {
	/**
	 * Body font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_body_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_body_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_menu_enable_callback' ) ) {
	/**
	 * Menu font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_menu_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_menu_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_site_title_enable_callback' ) ) {
	/**
	 * Site title font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_site_title_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_site_title_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_site_subtitle_enable_callback' ) ) {
	/**
	 * Site subtitle font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_site_subtitle_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_site_subtitle_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_widget_title_enable_callback' ) ) {
	/**
	 * Widget title font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_widget_title_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_widget_title_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_h1_enable_callback' ) ) {
	/**
	 * H1 font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_h1_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_h1_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_h2_enable_callback' ) ) {
	/**
	 * H2 font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_h2_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_h2_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_h3_enable_callback' ) ) {
	/**
	 * H3 font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_h3_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_h3_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_h4_enable_callback' ) ) {
	/**
	 * H4 font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_h4_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_h4_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_h5_enable_callback' ) ) {
	/**
	 * H5 font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_h5_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_h5_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_font_h6_enable_callback' ) ) {
	/**
	 * H6 font enable callback.
	 *
	 * @return bool
	 */
	function origamiez_font_h6_enable_callback(): bool {
		return (bool) get_theme_mod( 'font_h6_is_enable', false );
	}
}

if ( ! function_exists( 'origamiez_skin_custom_callback' ) ) {
	/**
	 * Skin custom callback.
	 *
	 * @return bool
	 */
	function origamiez_skin_custom_callback(): bool {
		return 'custom' === get_theme_mod( 'skin', 'default' );
	}
}

if ( ! function_exists( 'origamiez_top_bar_enable_callback' ) ) {
	/**
	 * Top bar enable callback.
	 *
	 * @return bool
	 */
	function origamiez_top_bar_enable_callback(): bool {
		return (bool) get_theme_mod( 'is_display_top_bar', true );
	}
}
