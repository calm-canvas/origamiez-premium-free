<?php
/**
 * Theme version from the style.css Theme API header.
 *
 * @package Origamiez
 */

namespace Origamiez\Helpers;

/**
 * Resolves the `Version` header from style.css (parent theme when a child theme is active).
 */
final class ThemeVersion {

	/**
	 * Used for wp_enqueue_* when the Version header is missing or WordPress is unavailable.
	 */
	private const FALLBACK = '4.4.2';

	/**
	 * `Version` from style.css: parent theme when a child is active, else the active theme.
	 *
	 * Matches the theme whose directory is used for `get_template_directory_uri()` assets.
	 *
	 * @return string Trimmed Version header, or empty string if absent / outside WordPress.
	 */
	public static function get_style_sheet_version(): string {
		if ( ! function_exists( 'wp_get_theme' ) ) {
			return '';
		}

		$theme  = wp_get_theme();
		$parent = $theme->parent();
		if ( $parent ) {
			$v = $parent->get( 'Version' );
		} else {
			$v = $theme->get( 'Version' );
		}

		return is_string( $v ) ? trim( $v ) : '';
	}

	/**
	 * Version string for wp_enqueue_* cache-busting.
	 *
	 * @return string
	 */
	public static function get(): string {
		$v = self::get_style_sheet_version();
		return '' !== $v ? $v : self::FALLBACK;
	}
}
