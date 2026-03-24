<?php
/**
 * Social network row definitions for theme config (icons, labels, colors).
 *
 * @package Origamiez
 */

/**
 * Returns compact social network rows for ORIGAMIEZ_CONFIG (slug, icon class, label, color).
 *
 * @return array<int, array{0: string, 1: string, 2: string, 3: string}>
 */
function origamiez_get_social_network_row_definitions() {
	return array(
		array( 'behance', 'fa-brands fa-behance', 'Behance', '#1769ff' ),
		array( 'bitbucket', 'fa-brands fa-bitbucket', 'Bitbucket', '#0052cc' ),
		array( 'codepen', 'fa-brands fa-codepen', 'CodePen', '#000000' ),
		array( 'deviantart', 'fa-brands fa-deviantart', 'DeviantArt', '#05cc47' ),
		array( 'digg', 'fa-brands fa-digg', 'Digg', '#0d5b7a' ),
		array( 'dribbble', 'fa-brands fa-dribbble', 'Dribbble', '#ea4c89' ),
		array( 'email', 'fa-solid fa-envelope', 'Email', '#0078d4' ),
		array( 'flickr', 'fa-brands fa-flickr', 'Flickr', '#0063dc' ),
		array( 'foursquare', 'fa-brands fa-foursquare', 'Foursquare', '#fa7343' ),
		array( 'git', 'fa-brands fa-git', 'Git', '#f1502f' ),
		array( 'github', 'fa-brands fa-github', 'Github', '#333333' ),
		array( 'google-plus', 'fa-brands fa-google-plus', 'Google Plus', '#ea4335' ),
		array( 'instagram', 'fa-brands fa-instagram', 'Instagram', '#e4405f' ),
		array( 'jsfiddle', 'fa-brands fa-jsfiddle', 'JsFiddle', '#007bb6' ),
		array( 'linkedin', 'fa-brands fa-linkedin', 'LinkedIn', '#0a66c2' ),
		array( 'pinterest', 'fa-brands fa-pinterest', 'Pinterest', '#e60023' ),
		array( 'reddit', 'fa-brands fa-reddit', 'Reddit', '#ff4500' ),
		array( 'soundcloud', 'fa-brands fa-soundcloud', 'Soundcloud', '#ff5500' ),
		array( 'spotify', 'fa-brands fa-spotify', 'Spotify', '#1db954' ),
		array( 'stack-exchange', 'fa-brands fa-stack-exchange', 'Stack Exchange', '#f48024' ),
		array( 'stack-overflow', 'fa-brands fa-stack-overflow', 'Stack Overflow', '#f48024' ),
		array( 'stumbleupon', 'fa-brands fa-stumbleupon', 'Stumbleupon', '#eb4823' ),
		array( 'tumblr', 'fa-brands fa-tumblr', 'Tumblr', '#36465d' ),
		array( 'twitter', 'fa-brands fa-twitter', 'Twitter', '#1da1f2' ),
		array( 'vimeo', 'fa-brands fa-vimeo-square', 'Vimeo', '#1ab7ea' ),
		array( 'youtube', 'fa-brands fa-youtube', 'Youtube', '#ff0000' ),
		array( 'rss', 'fa-brands fa-rss', 'Rss', '#FA9B39' ),
	);
}
