<?php
/**
 * Font Customizer Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class FontCustomizerConfig
 *
 * Provides font configuration options for the customizer.
 */
class FontCustomizerConfig {

	/**
	 * Get available font families for customizer.
	 *
	 * @return array
	 */
	public static function get_font_families(): array {
		return array(
			'Arial, sans-serif'                     => 'Arial',
			'"Trebuchet MS", Helvetica, sans-serif' => 'Trebuchet MS',
			'"Times New Roman", Times, serif'       => 'Times New Roman',
			'Georgia, serif'                        => 'Georgia',
			'"Courier New", Courier, monospace'     => 'Courier New',
			'Verdana, Geneva, sans-serif'           => 'Verdana',
			'"Comic Sans MS", cursive, sans-serif'  => 'Comic Sans MS',
			'Garamond, serif'                       => 'Garamond',
			'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino',
			'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif' => 'System Default',
		);
	}

	/**
	 * Get available font sizes for customizer.
	 *
	 * @return array
	 */
	public static function get_font_sizes(): array {
		return array(
			'12px' => '12px',
			'14px' => '14px',
			'16px' => '16px',
			'18px' => '18px',
			'20px' => '20px',
			'24px' => '24px',
			'28px' => '28px',
			'32px' => '32px',
		);
	}

	/**
	 * Get available font styles for customizer.
	 *
	 * @return array
	 */
	public static function get_font_styles(): array {
		return array(
			'normal'  => esc_attr__( 'Normal', 'origamiez' ),
			'italic'  => esc_attr__( 'Italic', 'origamiez' ),
			'oblique' => esc_attr__( 'Oblique', 'origamiez' ),
		);
	}

	/**
	 * Get available font weights for customizer.
	 *
	 * @return array
	 */
	public static function get_font_weights(): array {
		return array(
			'100' => '100 (Thin)',
			'200' => '200 (Extra Light)',
			'300' => '300 (Light)',
			'400' => '400 (Normal)',
			'500' => '500 (Medium)',
			'600' => '600 (Semi Bold)',
			'700' => '700 (Bold)',
			'800' => '800 (Extra Bold)',
			'900' => '900 (Black)',
		);
	}

	/**
	 * Get available line heights for customizer.
	 *
	 * @return array
	 */
	public static function get_font_line_heights(): array {
		return array(
			'1'   => '1',
			'1.2' => '1.2',
			'1.5' => '1.5',
			'1.6' => '1.6',
			'1.8' => '1.8',
			'2'   => '2',
		);
	}
}
