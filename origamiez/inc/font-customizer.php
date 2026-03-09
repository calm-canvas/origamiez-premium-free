<?php
/**
 * Font Customizer
 *
 * @package Origamiez
 */

use Origamiez\Engine\Config\FontCustomizerConfig;

/**
 * Get font families
 *
 * @return array
 */
function origamiez_get_font_families() {
	return FontCustomizerConfig::get_font_families();
}

/**
 * Get font sizes
 *
 * @return array
 */
function origamiez_get_font_sizes() {
	return FontCustomizerConfig::get_font_sizes();
}

/**
 * Get font styles
 *
 * @return array
 */
function origamiez_get_font_styles() {
	return FontCustomizerConfig::get_font_styles();
}

/**
 * Get font weights
 *
 * @return array
 */
function origamiez_get_font_weights() {
	return FontCustomizerConfig::get_font_weights();
}

/**
 * Get font line heights
 *
 * @return array
 */
function origamiez_get_font_line_heighs() {
	return FontCustomizerConfig::get_font_line_heights();
}
