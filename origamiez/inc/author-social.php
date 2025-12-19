<?php

use Origamiez\Engine\Config\SocialConfig;
use Origamiez\Engine\Display\AuthorDisplay;

function origamiez_get_author_infor() {
	$author = new AuthorDisplay();
	$author->display();
}

function origamiez_get_socials() {
	return SocialConfig::get_socials();
}
