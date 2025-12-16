<?php
namespace Origamiez\Engine\Security\Sanitizers;

class TextAreaSanitizer implements SanitizerInterface {
	public function sanitize( $value ) {
		if ( ! $value ) {
			return '';
		}

		$allowed_tags = $this->getAllowedTags();
		return wp_kses( $value, $allowed_tags );
	}

	private function getAllowedTags() {
		if ( function_exists( 'origamiez_get_allowed_tags' ) ) {
			return origamiez_get_allowed_tags();
		}

		$allowed_tag                              = wp_kses_allowed_html( 'post' );
		$allowed_tag['div']['data-place']         = array();
		$allowed_tag['div']['data-latitude']      = array();
		$allowed_tag['div']['data-longitude']     = array();
		$allowed_tag['iframe']['src']             = array();
		$allowed_tag['iframe']['height']          = array();
		$allowed_tag['iframe']['width']           = array();
		$allowed_tag['iframe']['frameborder']     = array();
		$allowed_tag['iframe']['allowfullscreen'] = array();
		$allowed_tag['input']['class']            = array();
		$allowed_tag['input']['id']               = array();
		$allowed_tag['input']['name']             = array();
		$allowed_tag['input']['value']            = array();
		$allowed_tag['input']['type']             = array();
		$allowed_tag['input']['checked']          = array();
		$allowed_tag['select']['class']           = array();
		$allowed_tag['select']['id']              = array();
		$allowed_tag['select']['name']            = array();
		$allowed_tag['select']['value']           = array();
		$allowed_tag['select']['type']            = array();
		$allowed_tag['option']['selected']        = array();
		$allowed_tag['style']['types']            = array();

		$microdata_tags = array(
			'div',
			'section',
			'article',
			'a',
			'span',
			'img',
			'time',
			'figure',
		);

		foreach ( $microdata_tags as $tag ) {
			$allowed_tag[ $tag ]['itemscope'] = array();
			$allowed_tag[ $tag ]['itemtype']  = array();
			$allowed_tag[ $tag ]['itemprop']  = array();
		}

		return apply_filters( 'origamiez_get_allowed_tags', $allowed_tag );
	}
}
