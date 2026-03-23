<?php
/**
 * Central Configuration
 *
 * @package Origamiez
 */

if ( ! defined( 'ORIGAMIEZ_PART_SIDEBAR_SLUG' ) ) {
	define( 'ORIGAMIEZ_PART_SIDEBAR_SLUG', 'parts/sidebar' );
}
if ( ! defined( 'ORIGAMIEZ_PART_METADATA_DIVIDER_SLUG' ) ) {
	define( 'ORIGAMIEZ_PART_METADATA_DIVIDER_SLUG', 'parts/metadata/divider' );
}
if ( ! defined( 'ORIGAMIEZ_CSP_SOURCE_SELF' ) ) {
	define( 'ORIGAMIEZ_CSP_SOURCE_SELF', "'self'" );
}

if ( ! defined( 'ORIGAMIEZ_CONFIG' ) ) {
	require_once __DIR__ . '/config-social-network-rows.php';

	$origamiez_socials = array();
	foreach ( origamiez_get_social_network_row_definitions() as $origamiez_social_row ) {
		$origamiez_socials[ $origamiez_social_row[0] ] = array(
			'icon'  => $origamiez_social_row[1],
			'label' => $origamiez_social_row[2],
			'color' => $origamiez_social_row[3],
		);
	}

	define(
		'ORIGAMIEZ_CONFIG',
		array(
			'theme_support' => array(
				'custom_background' => array(
					'default-color'      => '',
					'default-attachment' => 'fixed',
				),
				'custom_header'     => array(
					'header-text' => false,
					'width'       => 468,
					'height'      => 60,
					'flex-height' => true,
					'flex-width'  => true,
				),
				'content_width'     => 817,
				'post_formats'      => array( 'gallery', 'video', 'audio' ),
			),
			'sidebars'      => array(
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">',
				'after_title'   => '</span></h2><div class="origamiez-widget-content clearfix">',
			),
			'security'      => array(
				'headers' => array(
					'X-Content-Type-Options' => 'nosniff',
					'X-Frame-Options'        => 'SAMEORIGIN',
					'X-XSS-Protection'       => '1; mode=block',
					'Referrer-Policy'        => 'strict-origin-when-cross-origin',
				),
				'csp'     => array(
					'default-src' => ORIGAMIEZ_CSP_SOURCE_SELF,
					'script-src'  => ORIGAMIEZ_CSP_SOURCE_SELF . " 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com",
					'style-src'   => ORIGAMIEZ_CSP_SOURCE_SELF . " 'unsafe-inline' *.googleapis.com *.gstatic.com",
					'img-src'     => ORIGAMIEZ_CSP_SOURCE_SELF . ' data: *.gravatar.com *.wp.com',
					'font-src'    => ORIGAMIEZ_CSP_SOURCE_SELF . ' data: *.googleapis.com *.gstatic.com',
					'worker-src'  => ORIGAMIEZ_CSP_SOURCE_SELF . ' blob:',
					'connect-src' => ORIGAMIEZ_CSP_SOURCE_SELF,
					'frame-src'   => ORIGAMIEZ_CSP_SOURCE_SELF . ' *.youtube.com *.vimeo.com',
					'object-src'  => "'none'",
					'base-uri'    => ORIGAMIEZ_CSP_SOURCE_SELF,
				),
			),
			'socials'       => $origamiez_socials,
			'layouts'       => array(
				'default'            => array(
					'name'    => 'Default Layout',
					'sidebar' => 'right',
					'columns' => 2,
				),
				'fullwidth'          => array(
					'name'    => 'Full Width',
					'sidebar' => 'none',
					'columns' => 1,
				),
				'fullwidth-centered' => array(
					'name'     => 'Full Width Centered',
					'sidebar'  => 'none',
					'columns'  => 1,
					'centered' => true,
				),
				'magazine'           => array(
					'name'    => 'Magazine',
					'sidebar' => 'right',
					'columns' => 2,
					'feature' => 'magazine',
				),
				'three-cols'         => array(
					'name'    => 'Three Columns',
					'sidebar' => 'both',
					'columns' => 3,
				),
				'three-cols-slm'     => array(
					'name'    => 'Three Columns - Small Left/Middle',
					'sidebar' => 'both',
					'columns' => 3,
					'slim'    => true,
				),
			),
		)
	);
}
