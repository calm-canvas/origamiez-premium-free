<?php
/**
 * Fill-missing merge helpers for Theme JSON user global styles migration.
 *
 * @package Origamiez
 */

namespace Origamiez\Migration;

/**
 * Class GlobalStylesThemeJsonMerger
 */
class GlobalStylesThemeJsonMerger {

	/**
	 * Merge patch into existing data without overwriting existing leaf values.
	 *
	 * @param array $existing Existing Theme JSON (decoded).
	 * @param array $patch    Fragment from build_patch().
	 *
	 * @return array
	 */
	public function merge_fill_missing( array $existing, array $patch ): array {
		$existing = $this->merge_fill_missing_palette( $existing, $patch );
		$existing = $this->merge_fill_missing_font_families( $existing, $patch );
		$existing = $this->merge_fill_missing_google_font_meta( $existing, $patch );

		if ( ! empty( $patch['settings'] ) ) {
			$existing['settings'] = $this->deep_merge_settings_fill_missing(
				$existing['settings'] ?? array(),
				$patch['settings']
			);
		}

		if ( ! empty( $patch['styles'] ) ) {
			$existing['styles'] = $this->deep_merge_styles_fill_missing(
				$existing['styles'] ?? array(),
				$patch['styles']
			);
		}

		return $existing;
	}

	/**
	 * Remove empty nested arrays from a tree.
	 *
	 * @param array $tree Data.
	 *
	 * @return array
	 */
	public function remove_empty_branch( array $tree ): array {
		foreach ( $tree as $k => $v ) {
			if ( is_array( $v ) ) {
				$tree[ $k ] = $this->remove_empty_branch( $v );
				if ( array() === $tree[ $k ] ) {
					unset( $tree[ $k ] );
				}
			}
		}
		return $tree;
	}

	/**
	 * Merge color palette from patch when present.
	 *
	 * @param array $existing Theme JSON.
	 * @param array $patch    Fragment (modified by reference via unset).
	 */
	private function merge_fill_missing_palette( array $existing, array &$patch ): array {
		if ( ! isset( $patch['settings']['color']['palette'] ) || ! is_array( $patch['settings']['color']['palette'] ) ) {
			return $existing;
		}
		if ( ! isset( $existing['settings'] ) ) {
			$existing['settings'] = array();
		}
		$existing['settings'] = $this->merge_palette_fill_missing(
			$existing['settings'],
			$patch['settings']['color']['palette']
		);
		unset( $patch['settings']['color'] );

		return $existing;
	}

	/**
	 * Merge font families from patch when present.
	 *
	 * @param array $existing Theme JSON.
	 * @param array $patch    Fragment (modified by reference via unset).
	 */
	private function merge_fill_missing_font_families( array $existing, array &$patch ): array {
		if ( ! isset( $patch['settings']['typography']['fontFamilies'] ) || ! is_array( $patch['settings']['typography']['fontFamilies'] ) ) {
			return $existing;
		}
		if ( ! isset( $existing['settings'] ) ) {
			$existing['settings'] = array();
		}
		$existing['settings'] = $this->merge_font_families_fill_missing(
			$existing['settings'],
			$patch['settings']['typography']['fontFamilies']
		);
		unset( $patch['settings']['typography']['fontFamilies'] );
		if ( empty( $patch['settings']['typography'] ) ) {
			unset( $patch['settings']['typography'] );
		}

		return $existing;
	}

	/**
	 * Merge Google Fonts metadata from patch when present.
	 *
	 * @param array $existing Theme JSON.
	 * @param array $patch    Fragment (modified by reference via unset).
	 */
	private function merge_fill_missing_google_font_meta( array $existing, array &$patch ): array {
		if ( ! isset( $patch['settings']['custom']['origamiez']['googleFonts'] ) ) {
			return $existing;
		}
		if ( ! isset( $existing['settings']['custom']['origamiez'] ) ) {
			$existing['settings']['custom']['origamiez'] = array();
		}
		$incoming = $patch['settings']['custom']['origamiez']['googleFonts'];
		if ( ! isset( $existing['settings']['custom']['origamiez']['googleFonts'] ) || ! is_array( $existing['settings']['custom']['origamiez']['googleFonts'] ) ) {
			$existing['settings']['custom']['origamiez']['googleFonts'] = $incoming;
		} else {
			$existing['settings']['custom']['origamiez']['googleFonts'] = $this->merge_google_font_meta_fill_missing(
				$existing['settings']['custom']['origamiez']['googleFonts'],
				$incoming
			);
		}
		unset( $patch['settings']['custom']['origamiez']['googleFonts'] );
		$patch['settings'] = $this->remove_empty_branch( $patch['settings'] );

		return $existing;
	}

	/**
	 * Merge color palette entries that do not already exist (by slug).
	 *
	 * @param array $settings Existing settings branch.
	 * @param array $entries  New palette entries.
	 *
	 * @return array
	 */
	private function merge_palette_fill_missing( array $settings, array $entries ): array {
		$palette = $settings['color']['palette'] ?? array();
		if ( ! is_array( $palette ) ) {
			$palette = array();
		}
		$slugs = array();
		foreach ( $palette as $row ) {
			if ( ! empty( $row['slug'] ) ) {
				$slugs[ $row['slug'] ] = true;
			}
		}
		foreach ( $entries as $row ) {
			if ( empty( $row['slug'] ) ) {
				continue;
			}
			if ( ! isset( $slugs[ $row['slug'] ] ) ) {
				$palette[]             = $row;
				$slugs[ $row['slug'] ] = true;
			}
		}
		if ( ! isset( $settings['color'] ) ) {
			$settings['color'] = array();
		}
		$settings['color']['palette'] = $palette;
		return $settings;
	}

	/**
	 * Merge font family definitions that do not already exist (by slug).
	 *
	 * @param array $settings Existing settings branch.
	 * @param array $families New font family definitions.
	 *
	 * @return array
	 */
	private function merge_font_families_fill_missing( array $settings, array $families ): array {
		$list = $settings['typography']['fontFamilies'] ?? array();
		if ( ! is_array( $list ) ) {
			$list = array();
		}
		$slugs = array();
		foreach ( $list as $row ) {
			if ( ! empty( $row['slug'] ) ) {
				$slugs[ $row['slug'] ] = true;
			}
		}
		foreach ( $families as $row ) {
			if ( empty( $row['slug'] ) ) {
				continue;
			}
			if ( ! isset( $slugs[ $row['slug'] ] ) ) {
				$list[]                = $row;
				$slugs[ $row['slug'] ] = true;
			}
		}
		if ( ! isset( $settings['typography'] ) ) {
			$settings['typography'] = array();
		}
		$settings['typography']['fontFamilies'] = $list;
		return $settings;
	}

	/**
	 * Merge Google Font slot metadata (slug + stylesheet URL) without clobbering src.
	 *
	 * @param array $existing Existing googleFonts meta list.
	 * @param array $incoming Incoming meta.
	 *
	 * @return array
	 */
	private function merge_google_font_meta_fill_missing( array $existing, array $incoming ): array {
		$by_slug = array();
		foreach ( $existing as $row ) {
			if ( ! empty( $row['slug'] ) ) {
				$by_slug[ $row['slug'] ] = $row;
			}
		}
		foreach ( $incoming as $row ) {
			if ( empty( $row['slug'] ) ) {
				continue;
			}
			if ( ! isset( $by_slug[ $row['slug'] ] ) ) {
				$by_slug[ $row['slug'] ] = $row;
			} elseif ( empty( $by_slug[ $row['slug'] ]['src'] ) && ! empty( $row['src'] ) ) {
				$by_slug[ $row['slug'] ]['src'] = $row['src'];
			}
		}
		return array_values( $by_slug );
	}

	/**
	 * Deep merge settings (custom.origamiez.widgetTitleTypography, etc.).
	 *
	 * @param array $base  Existing.
	 * @param array $extra Patch.
	 *
	 * @return array
	 */
	private function deep_merge_settings_fill_missing( array $base, array $extra ): array {
		foreach ( $extra as $key => $value ) {
			if ( is_array( $value ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
				$base[ $key ] = $this->deep_merge_settings_fill_missing( $base[ $key ], $value );
			} elseif ( ! isset( $base[ $key ] ) ) {
				$base[ $key ] = $value;
			}
		}
		return $base;
	}

	/**
	 * Merge styles tree; typography nodes use fill-missing per property.
	 *
	 * @param array $base  Existing styles.
	 * @param array $extra Patch.
	 *
	 * @return array
	 */
	private function deep_merge_styles_fill_missing( array $base, array $extra ): array {
		foreach ( $extra as $key => $value ) {
			if ( 'typography' === $key && is_array( $value ) && isset( $base['typography'] ) && is_array( $base['typography'] ) ) {
				foreach ( $value as $tk => $tv ) {
					if ( ! isset( $base['typography'][ $tk ] ) ) {
						$base['typography'][ $tk ] = $tv;
					}
				}
				continue;
			}
			if ( is_array( $value ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
				$base[ $key ] = $this->deep_merge_styles_fill_missing( $base[ $key ], $value );
			} elseif ( ! isset( $base[ $key ] ) ) {
				$base[ $key ] = $value;
			}
		}
		return $base;
	}
}
