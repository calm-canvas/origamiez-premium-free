<?php

namespace Origamiez\Engine\Config;

class SocialConfig {

	private static array $socials = array(
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
	);

	public static function getSocials(): array {
		$socials = array();
		foreach ( self::$socials as $key => $data ) {
			$socials[ $key ] = array(
				'icon'  => $data['icon'],
				'label' => esc_attr__( $data['label'], 'origamiez' ),
				'color' => $data['color'],
			);
		}
		return apply_filters( 'origamiez_social_networks', $socials );
	}

	public static function getSocial( string $key ): ?array {
		$socials = self::getSocials();
		return $socials[ $key ] ?? null;
	}

	public static function getSocialIcon( string $key ): string {
		$social = self::getSocial( $key );
		return $social['icon'] ?? '';
	}

	public static function getSocialLabel( string $key ): string {
		$social = self::getSocial( $key );
		return $social['label'] ?? '';
	}

	public static function getSocialColor( string $key ): string {
		$social = self::getSocial( $key );
		return $social['color'] ?? '';
	}
}
