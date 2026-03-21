<?php
/**
 * Home
 *
 * @package Origamiez
 */

get_header(); ?>
<?php
$taxonomy_layout = get_theme_mod( 'taxonomy_layout', 'two-cols' );
get_template_part( 'parts/archive/archive', $taxonomy_layout );
?>
	<div class="clearfix"></div>
<?php get_template_part( 'parts/sidebar', 'bottom' ); ?>
	<div class="clearfix"></div>
<?php

get_footer();
