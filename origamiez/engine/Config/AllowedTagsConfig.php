<?php
/**
 * Allowed Tags Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class AllowedTagsConfig
 */
class AllowedTagsConfig {

	/**
	 * Allowed tags.
	 *
	 * @var ?array
	 */
	private static ?array $allowed_tags = null;

	/**
	 * Get allowed tags.
	 *
	 * @return array
	 */
	public static function get_allowed_tags(): array {
		if ( null === self::$allowed_tags ) {
			self::$allowed_tags = self::build_allowed_tags();
		}
		return apply_filters( 'origamiez_get_allowed_tags', self::$allowed_tags );
	}

	/**
	 * Build allowed tags.
	 *
	 * @return array
	 */
	private static function build_allowed_tags(): array {
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

	/**
	 * Sanitize content.
	 *
	 * @param string $content Content to sanitize.
	 * @return string
	 */
	public static function sanitize_content( string $content ): string {
		return wp_kses( $content, self::get_allowed_tags() );
	}
}
