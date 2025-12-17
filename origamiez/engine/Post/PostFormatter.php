<?php
/**
 * Post Formatter
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Post;

/**
 * Class PostFormatter
 *
 * @package Origamiez\Engine\Post
 */
class PostFormatter {

	/**
	 * Extract shortcodes from content.
	 *
	 * @param string $content The content.
	 * @param array  $shortcodes The shortcodes.
	 * @param bool   $enable_multi The enable multi.
	 *
	 * @return array
	 */
	public function extract_shortcodes( string $content, array $shortcodes = array(), bool $enable_multi = false ): array {
		$data = array();

		if ( empty( $shortcodes ) ) {
			return $data;
		}

		$regex_matches = '';
		$regex_pattern = get_shortcode_regex();

		preg_match_all( '/' . $regex_pattern . '/s', $content, $regex_matches );

		foreach ( $regex_matches[0] as $shortcode ) {
			$regex_matches_new = '';
			preg_match( '/' . $regex_pattern . '/s', $shortcode, $regex_matches_new );

			if ( in_array( $regex_matches_new[2], $shortcodes, true ) ) {
				$data[] = array(
					'shortcode' => $regex_matches_new[0],
					'type'      => $regex_matches_new[2],
					'content'   => $regex_matches_new[5],
					'atts'      => shortcode_parse_atts( $regex_matches_new[3] ),
				);

				if ( false === $enable_multi ) {
					break;
				}
			}
		}

		return apply_filters( 'origamiez_get_shortcode', $data, $content, $shortcodes );
	}

	/**
	 * Extract first shortcode from content.
	 *
	 * @param string $content The content.
	 * @param array  $shortcodes The shortcodes.
	 *
	 * @return array|null
	 */
	public function extract_first_shortcode( string $content, array $shortcodes = array() ): ?array {
		$results = $this->extract_shortcodes( $content, $shortcodes, false );

		return ! empty( $results ) ? $results[0] : null;
	}

	/**
	 * Has shortcode.
	 *
	 * @param string $content The content.
	 * @param string $shortcode The shortcode.
	 *
	 * @return boolean
	 */
	public function has_shortcode( string $content, string $shortcode ): bool {
		$results = $this->extract_shortcodes( $content, array( $shortcode ) );

		return ! empty( $results );
	}

	/**
	 * Has any shortcode.
	 *
	 * @param string $content The content.
	 * @param array  $shortcodes The shortcodes.
	 *
	 * @return boolean
	 */
	public function has_any_shortcode( string $content, array $shortcodes = array() ): bool {
		if ( empty( $shortcodes ) ) {
			return false;
		}

		$results = $this->extract_shortcodes( $content, $shortcodes );

		return ! empty( $results );
	}

	/**
	 * Get shortcode attribute.
	 *
	 * @param string $content The content.
	 * @param string $shortcode The shortcode.
	 * @param string $attribute The attribute.
	 * @param mixed  $default The default.
	 *
	 * @return mixed
	 */
	public function get_shortcode_attribute( string $content, string $shortcode, string $attribute, $default = null ) {
		$result = $this->extract_first_shortcode( $content, array( $shortcode ) );

		if ( null === $result ) {
			return $default;
		}

		return $result['atts'][ $attribute ] ?? $default;
	}

	/**
	 * Remove shortcode.
	 *
	 * @param string $content The content.
	 * @param string $shortcode The shortcode.
	 *
	 * @return string
	 */
	public function remove_shortcode( string $content, string $shortcode ): string {
		return do_shortcode(
			str_replace( '[' . $shortcode, '[removed_' . $shortcode, $content )
		);
	}

	/**
	 * Truncate content.
	 *
	 * @param string  $content The content.
	 * @param integer $length The length.
	 * @param string  $suffix The suffix.
	 *
	 * @return string
	 */
	public function truncate_content( string $content, int $length = 150, string $suffix = '...' ): string {
		if ( strlen( $content ) <= $length ) {
			return $content;
		}

		return substr( $content, 0, $length ) . $suffix;
	}

	/**
	 * Strip shortcodes.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function strip_shortcodes( string $content ): string {
		return strip_shortcodes( $content );
	}

	/**
	 * Get plain text.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function get_plain_text( string $content ): string {
		$content = wp_strip_all_tags( $content );

		return trim( $content );
	}

	/**
	 * Excerpt.
	 *
	 * @param string  $content The content.
	 * @param integer $length The length.
	 * @param string  $more_text The more text.
	 *
	 * @return string
	 */
	public function excerpt( string $content, int $length = 55, string $more_text = '[...]' ): string {
		$excerpt = wp_trim_words( wp_strip_all_tags( $content ), $length, $more_text );

		return apply_filters( 'origamiez_post_excerpt', $excerpt, $content, $length, $more_text );
	}
}
