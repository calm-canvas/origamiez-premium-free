<?php
/**
 * Author social functions
 *
 * @package Origamiez
 */

use Origamiez\Config\SocialConfig;
use Origamiez\Display\AuthorDisplay;

/**
 * Get author information
 */
function origamiez_get_author_infor() {
	$author = new AuthorDisplay();
	$author->display();
}

/**
 * Get social networks configuration
 *
 * @return array
 */
function origamiez_get_socials() {
	return SocialConfig::get_socials();
}
