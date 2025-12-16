<?php

namespace Origamiez\Engine\Config;

class AllowedTagsConfig {

	private static ?array $allowedTags = null;

	public static function getAllowedTags(): array {
		if ( null === self::$allowedTags ) {
			self::$allowedTags = self::buildAllowedTags();
		}
		return apply_filters( 'origamiez_get_allowed_tags', self::$allowedTags );
	}

	private static function buildAllowedTags(): array {
		$allowed_tags = wp_kses_allowed_html( 'post' );

		$allowed_tags['div']['data-place']     = array();
		$allowed_tags['div']['data-latitude']  = array();
		$allowed_tags['div']['data-longitude'] = array();

		$allowed_tags['iframe']['src']             = array();
		$allowed_tags['iframe']['height']          = array();
		$allowed_tags['iframe']['width']           = array();
		$allowed_tags['iframe']['frameborder']     = array();
		$allowed_tags['iframe']['allowfullscreen'] = array();

		$allowed_tags['input']['class']   = array();
		$allowed_tags['input']['id']      = array();
		$allowed_tags['input']['name']    = array();
		$allowed_tags['input']['value']   = array();
		$allowed_tags['input']['type']    = array();
		$allowed_tags['input']['checked'] = array();

		$allowed_tags['select']['class'] = array();
		$allowed_tags['select']['id']    = array();
		$allowed_tags['select']['name']  = array();
		$allowed_tags['select']['value'] = array();
		$allowed_tags['select']['type']  = array();

		$allowed_tags['option']['selected'] = array();

		$allowed_tags['style']['types'] = array();

		$microdata_tags = array( 'div', 'section', 'article', 'a', 'span', 'img', 'time', 'figure' );
		foreach ( $microdata_tags as $tag ) {
			$allowed_tags[ $tag ]['itemscope'] = array();
			$allowed_tags[ $tag ]['itemtype']  = array();
			$allowed_tags[ $tag ]['itemprop']  = array();
		}

		return $allowed_tags;
	}

	public static function sanitizeContent( string $content ): string {
		return wp_kses( $content, self::getAllowedTags() );
	}
}
