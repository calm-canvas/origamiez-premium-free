<?php

use Origamiez\Engine\Config\FontCustomizerConfig;

function origamiez_get_font_families() {
	return FontCustomizerConfig::get_font_families();
}

function origamiez_get_font_sizes() {
	return FontCustomizerConfig::get_font_sizes();
}

function origamiez_get_font_styles() {
	return FontCustomizerConfig::get_font_styles();
}

function origamiez_get_font_weights() {
	return FontCustomizerConfig::get_font_weights();
}

function origamiez_get_font_line_heighs() {
	return FontCustomizerConfig::get_font_line_heights();
}
