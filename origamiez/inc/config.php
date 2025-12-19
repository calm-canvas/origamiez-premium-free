<?php
/**
 * Central Configuration
 *
 * @package Origamiez
 */

if ( ! defined( 'ORIGAMIEZ_CONFIG' ) ) {
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
					'default-src' => "'self'",
					'script-src'  => "'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com",
					'style-src'   => "'self' 'unsafe-inline' *.googleapis.com *.gstatic.com",
					'img-src'     => "'self' data: *.gravatar.com *.wp.com",
					'font-src'    => "'self' *.googleapis.com *.gstatic.com",
					'connect-src' => "'self'",
					'frame-src'   => "'self' *.youtube.com *.vimeo.com",
					'object-src'  => "'none'",
					'base-uri'    => "'self'",
				),
			),
			'socials'       => array(
				'behance'        => array(
					'icon'  => 'fa-brands fa-behance',
					'label' => 'Behance',
					'color' => '#1769ff',
				),
				'bitbucket'      => array(
					'icon'  => 'fa-brands fa-bitbucket',
					'label' => 'Bitbucket',
					'color' => '#0052cc',
				),
				'codepen'        => array(
					'icon'  => 'fa-brands fa-codepen',
					'label' => 'CodePen',
					'color' => '#000000',
				),
				'deviantart'     => array(
					'icon'  => 'fa-brands fa-deviantart',
					'label' => 'DeviantArt',
					'color' => '#05cc47',
				),
				'digg'           => array(
					'icon'  => 'fa-brands fa-digg',
					'label' => 'Digg',
					'color' => '#0d5b7a',
				),
				'dribbble'       => array(
					'icon'  => 'fa-brands fa-dribbble',
					'label' => 'Dribbble',
					'color' => '#ea4c89',
				),
				'email'          => array(
					'icon'  => 'fa-solid fa-envelope',
					'label' => 'Email',
					'color' => '#0078d4',
				),
				'flickr'         => array(
					'icon'  => 'fa-brands fa-flickr',
					'label' => 'Flickr',
					'color' => '#0063dc',
				),
				'foursquare'     => array(
					'icon'  => 'fa-brands fa-foursquare',
					'label' => 'Foursquare',
					'color' => '#fa7343',
				),
				'git'            => array(
					'icon'  => 'fa-brands fa-git',
					'label' => 'Git',
					'color' => '#f1502f',
				),
				'github'         => array(
					'icon'  => 'fa-brands fa-github',
					'label' => 'Github',
					'color' => '#333333',
				),
				'google-plus'    => array(
					'icon'  => 'fa-brands fa-google-plus',
					'label' => 'Google Plus',
					'color' => '#ea4335',
				),
				'instagram'      => array(
					'icon'  => 'fa-brands fa-instagram',
					'label' => 'Instagram',
					'color' => '#e4405f',
				),
				'jsfiddle'       => array(
					'icon'  => 'fa-brands fa-jsfiddle',
					'label' => 'JsFiddle',
					'color' => '#007bb6',
				),
				'linkedin'       => array(
					'icon'  => 'fa-brands fa-linkedin',
					'label' => 'LinkedIn',
					'color' => '#0a66c2',
				),
				'pinterest'      => array(
					'icon'  => 'fa-brands fa-pinterest',
					'label' => 'Pinterest',
					'color' => '#e60023',
				),
				'reddit'         => array(
					'icon'  => 'fa-brands fa-reddit',
					'label' => 'Reddit',
					'color' => '#ff4500',
				),
				'soundcloud'     => array(
					'icon'  => 'fa-brands fa-soundcloud',
					'label' => 'Soundcloud',
					'color' => '#ff5500',
				),
				'spotify'        => array(
					'icon'  => 'fa-brands fa-spotify',
					'label' => 'Spotify',
					'color' => '#1db954',
				),
				'stack-exchange' => array(
					'icon'  => 'fa-brands fa-stack-exchange',
					'label' => 'Stack Exchange',
					'color' => '#f48024',
				),
				'stack-overflow' => array(
					'icon'  => 'fa-brands fa-stack-overflow',
					'label' => 'Stack Overflow',
					'color' => '#f48024',
				),
				'stumbleupon'    => array(
					'icon'  => 'fa-brands fa-stumbleupon',
					'label' => 'Stumbleupon',
					'color' => '#eb4823',
				),
				'tumblr'         => array(
					'icon'  => 'fa-brands fa-tumblr',
					'label' => 'Tumblr',
					'color' => '#36465d',
				),
				'twitter'        => array(
					'icon'  => 'fa-brands fa-twitter',
					'label' => 'Twitter',
					'color' => '#1da1f2',
				),
				'vimeo'          => array(
					'icon'  => 'fa-brands fa-vimeo-square',
					'label' => 'Vimeo',
					'color' => '#1ab7ea',
				),
				'youtube'        => array(
					'icon'  => 'fa-brands fa-youtube',
					'label' => 'Youtube',
					'color' => '#ff0000',
				),
				'rss'            => array(
					'icon'  => 'fa-brands fa-rss',
					'label' => 'Rss',
					'color' => '#FA9B39',
				),
			),
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
