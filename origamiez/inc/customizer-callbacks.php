<?php
/**
 * Customizer Callbacks
 *
 * @package Origamiez
 */

/**
 * Top bar enable callback
 *
 * @return mixed
 */
function origamiez_top_bar_enable_callback() {
	return get_theme_mod( 'is_display_top_bar', 1 );
}
