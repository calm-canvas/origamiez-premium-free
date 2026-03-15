<?php
/**
 * Footer
 *
 * @package Origamiez
 */

$footer_number_of_cols = (int) get_theme_mod( 'footer_number_of_cols', 5 );
get_template_part( 'parts/footer', $footer_number_of_cols );
