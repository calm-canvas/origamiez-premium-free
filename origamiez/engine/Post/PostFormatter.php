<?php

namespace Origamiez\Engine\Post;

class PostFormatter {

	public function extractShortcodes( string $content, array $shortcodes = [], bool $enableMulti = false ): array {
		$data = [];

		if ( empty( $shortcodes ) ) {
			return $data;
		}

		$regexMatches = '';
		$regexPattern  = get_shortcode_regex();

		preg_match_all( '/' . $regexPattern . '/s', $content, $regexMatches );

		foreach ( $regexMatches[0] as $shortcode ) {
			$regexMatchesNew = '';
			preg_match( '/' . $regexPattern . '/s', $shortcode, $regexMatchesNew );

			if ( in_array( $regexMatchesNew[2], $shortcodes, true ) ) {
				$data[] = [
					'shortcode' => $regexMatchesNew[0],
					'type'      => $regexMatchesNew[2],
					'content'   => $regexMatchesNew[5],
					'atts'      => shortcode_parse_atts( $regexMatchesNew[3] ),
				];

				if ( false === $enableMulti ) {
					break;
				}
			}
		}

		return apply_filters( 'origamiez_get_shortcode', $data, $content, $shortcodes );
	}

	public function extractFirstShortcode( string $content, array $shortcodes = [] ): ?array {
		$results = $this->extractShortcodes( $content, $shortcodes, false );

		return ! empty( $results ) ? $results[0] : null;
	}

	public function hasShortcode( string $content, string $shortcode ): bool {
		$results = $this->extractShortcodes( $content, [ $shortcode ] );

		return ! empty( $results );
	}

	public function hasAnyShortcode( string $content, array $shortcodes = [] ): bool {
		if ( empty( $shortcodes ) ) {
			return false;
		}

		$results = $this->extractShortcodes( $content, $shortcodes );

		return ! empty( $results );
	}

	public function getShortcodeAttribute( string $content, string $shortcode, string $attribute, $default = null ) {
		$result = $this->extractFirstShortcode( $content, [ $shortcode ] );

		if ( null === $result ) {
			return $default;
		}

		return $result['atts'][ $attribute ] ?? $default;
	}

	public function removeShortcode( string $content, string $shortcode ): string {
		return do_shortcode(
			str_replace( '[' . $shortcode, '[removed_' . $shortcode, $content )
		);
	}

	public function truncateContent( string $content, int $length = 150, string $suffix = '...' ): string {
		if ( strlen( $content ) <= $length ) {
			return $content;
		}

		return substr( $content, 0, $length ) . $suffix;
	}

	public function stripShortcodes( string $content ): string {
		return strip_shortcodes( $content );
	}

	public function getPlainText( string $content ): string {
		$content = wp_strip_all_tags( $content );

		return trim( $content );
	}

	public function excerpt( string $content, int $length = 55, string $moreText = '[...]' ): string {
		$excerpt = wp_trim_words( wp_strip_all_tags( $content ), $length, $moreText );

		return apply_filters( 'origamiez_post_excerpt', $excerpt, $content, $length, $moreText );
	}
}
