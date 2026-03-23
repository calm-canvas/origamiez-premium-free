<?php
/**
 * Header Left Right
 *
 * @package Origamiez
 */

get_template_part(
	'parts/header/header',
	'branding',
	array(
		'header_top_class'     => 'origamiez-header-left-right',
		'logo_wrapper_class'   => 'pull-left',
		'banner_wrapper_class' => 'pull-right',
	)
);
