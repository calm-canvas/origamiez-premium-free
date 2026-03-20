<?php
/**
 * Theme mod keys formerly registered for Color / Typography / Google Fonts in the Customizer.
 *
 * The theme no longer registers these controls (Site Editor is canonical). Values may still
 * exist in the database for sites that have not purged them. Safe removal is optional and
 * should run only after confirming front-end parity with global styles (back up first).
 *
 * @package Origamiez
 */

namespace Origamiez\Migration;

/**
 * Class LegacyAppearanceThemeModKeys
 */
final class LegacyAppearanceThemeModKeys {

	/**
	 * All legacy appearance-related theme_mod keys (Customizer Phases 0–3).
	 *
	 * Excludes unrelated mods (layout, header_style, etc.).
	 */
	public const KEYS = array(
		'skin',
		'primary_color',
		'secondary_color',
		'body_color',
		'heading_color',
		'link_color',
		'link_hover_color',
		'main_menu_color',
		'main_menu_bg_color',
		'main_menu_hover_color',
		'main_menu_active_color',
		'line_1_bg_color',
		'line_2_bg_color',
		'line_3_bg_color',
		'footer_sidebars_bg_color',
		'footer_sidebars_text_color',
		'footer_sidebars_widget_heading_color',
		'footer_end_bg_color',
		'footer_end_text_color',
		'black_light_color',
		'metadata_color',
		'color_success',
		'origamiez_notice_site_editor_colors',
		'origamiez_notice_site_editor_typography',
		'origamiez_notice_site_editor_google_fonts',
	);

	/**
	 * Typography object prefixes (font_body, font_menu, …).
	 */
	private const FONT_OBJECT_PREFIXES = array(
		'font_body',
		'font_menu',
		'font_site_title',
		'font_site_subtitle',
		'font_widget_title',
		'font_h1',
		'font_h2',
		'font_h3',
		'font_h4',
		'font_h5',
		'font_h6',
	);

	/**
	 * Suffixes per font object theme_mod.
	 */
	private const FONT_RULE_SUFFIXES = array(
		'is_enable',
		'family',
		'size',
		'style',
		'weight',
		'line_height',
	);

	/**
	 * All keys including generated font_* and google_font_* slots.
	 *
	 * @return array<int, string>
	 */
	public static function all_keys(): array {
		$keys = self::KEYS;

		foreach ( self::FONT_OBJECT_PREFIXES as $prefix ) {
			foreach ( self::FONT_RULE_SUFFIXES as $suffix ) {
				$keys[] = "{$prefix}_{$suffix}";
			}
		}

		$filter = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );
		for ( $i = 0; $i < $filter; $i++ ) {
			$keys[] = "google_font_{$i}_name";
			$keys[] = "google_font_{$i}_src";
		}

		return array_values( array_unique( $keys ) );
	}
}
