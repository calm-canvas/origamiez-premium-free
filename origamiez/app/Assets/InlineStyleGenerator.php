<?php
/**
 * Generates inline styles.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Assets;

/**
 * Class InlineStyleGenerator
 */
class InlineStyleGenerator {

	/**
	 * Theme JSON bridge (migration + merged data).
	 *
	 * @var ThemeJsonAppearanceBridge
	 */
	private ThemeJsonAppearanceBridge $bridge;

	/**
	 * InlineStyleGenerator constructor.
	 *
	 * @param ThemeJsonAppearanceBridge|null $bridge Optional bridge (for tests).
	 */
	public function __construct( ?ThemeJsonAppearanceBridge $bridge = null ) {
		$this->bridge = $bridge ?? new ThemeJsonAppearanceBridge();
	}

	/**
	 * Adds inline styles.
	 *
	 * @param StylesheetManager $stylesheet_manager The stylesheet manager.
	 */
	public function add_inline_styles( StylesheetManager $stylesheet_manager ): void {
		$this->add_color_variables( $stylesheet_manager );
		$this->add_font_variables( $stylesheet_manager );
	}

	/**
	 * Adds color variables as inline styles.
	 *
	 * @param StylesheetManager $stylesheet_manager The stylesheet manager.
	 */
	private function add_color_variables( StylesheetManager $stylesheet_manager ): void {
		if ( $this->bridge->is_active() ) {
			return;
		}

		$skin = get_theme_mod( 'skin', 'default' );

		if ( 'custom' !== $skin ) {
			return;
		}

		$color_variables = $this->build_color_variables();
		$css             = ':root {' . $color_variables . '}';

		$stylesheet_manager->add_inline_style( $css );
	}

	/**
	 * Builds the CSS for color variables.
	 *
	 * @return string The CSS for color variables.
	 */
	private function build_color_variables(): string {
		$colors = array(
			'--body-color'                           => 'body_color',
			'--heading-color'                        => 'heading_color',
			'--link-color'                           => 'link_color',
			'--link-hover-color'                     => 'link_hover_color',
			'--primary-color'                        => 'primary_color',
			'--secondary-color'                      => 'secondary_color',
			'--main-menu-color'                      => 'main_menu_color',
			'--main-menu-bg-color'                   => 'main_menu_bg_color',
			'--main-menu-hover-color'                => 'main_menu_hover_color',
			'--main-menu-active-color'               => 'main_menu_active_color',
			'--line-1-bg-color'                      => 'line_1_bg_color',
			'--line-2-bg-color'                      => 'line_2_bg_color',
			'--line-3-bg-color'                      => 'line_3_bg_color',
			'--footer-sidebars-bg-color'             => 'footer_sidebars_bg_color',
			'--footer-sidebars-text-color'           => 'footer_sidebars_text_color',
			'--footer-sidebars-widget-heading-color' => 'footer_sidebars_widget_heading_color',
			'--footer-end-bg-color'                  => 'footer_end_bg_color',
			'--footer-end-text-color'                => 'footer_end_text_color',
			'--metadata-color'                       => 'metadata_color',
			'--color-success'                        => 'color_success',
		);

		$default_colors = array(
			'body_color'                           => 'var(--wp--preset--color--body, #333333)',
			'heading_color'                        => 'var(--wp--preset--color--heading, #111111)',
			'link_color'                           => 'var(--wp--preset--color--primary, #111111)',
			'link_hover_color'                     => 'var(--wp--preset--color--link-hover, #00589f)',
			'primary_color'                        => 'var(--wp--preset--color--primary, #111111)',
			'secondary_color'                      => 'var(--wp--preset--color--secondary, #f5f7fa)',
			'main_menu_color'                      => 'var(--wp--preset--color--main-menu-text, #111111)',
			'main_menu_bg_color'                   => 'var(--wp--preset--color--main-menu-bg, #ffffff)',
			'main_menu_hover_color'                => 'var(--wp--preset--color--main-menu-hover, #00589f)',
			'main_menu_active_color'               => 'var(--wp--preset--color--main-menu-active, #111111)',
			'line_1_bg_color'                      => 'var(--wp--preset--color--line-1-bg, #e8ecf1)',
			'line_2_bg_color'                      => 'var(--wp--preset--color--line-2-bg, #f0f2f5)',
			'line_3_bg_color'                      => 'var(--wp--preset--color--line-3-bg, #f8fafc)',
			'footer_sidebars_bg_color'             => 'var(--wp--preset--color--footer-sidebars-bg, #222222)',
			'footer_sidebars_text_color'           => 'var(--wp--preset--color--footer-sidebars-text, #a0a0a0)',
			'footer_sidebars_widget_heading_color' => 'var(--wp--preset--color--footer-sidebars-widget-heading, #ffffff)',
			'footer_end_bg_color'                  => 'var(--wp--preset--color--footer-end-bg, #111111)',
			'footer_end_text_color'                => 'var(--wp--preset--color--footer-end-text, #a0a0a0)',
			'metadata_color'                       => 'var(--wp--preset--color--metadata, #666666)',
			'color_success'                        => 'var(--wp--preset--color--success, #27ae60)',
		);

		$css  = '';
		$css .= '--white: #ffffff;';
		$css .= '--black: #000000;';
		$css .= '--black_light: ' . get_theme_mod( 'black_light_color', 'var(--wp--preset--color--black-light, #f8fafc)' ) . ';';
		$css .= '--overlay_white: rgba(255, 255, 255, 0.85);';
		$css .= '--overlay_black: rgba(0, 0, 0, 0.75);';

		foreach ( $colors as $css_var => $option ) {
			$default = $default_colors[ $option ] ?? '';
			$value   = get_theme_mod( $option, $default );
			$css    .= $css_var . ': ' . $value . ';';
		}

		return $css;
	}

	/**
	 * Adds font variables as inline styles.
	 *
	 * @param StylesheetManager $stylesheet_manager The stylesheet manager.
	 */
	private function add_font_variables( StylesheetManager $stylesheet_manager ): void {
		$css_variables = $this->build_font_variables();

		if ( ! empty( $css_variables ) ) {
			$css = ':root {' . $css_variables . '}';
			$stylesheet_manager->add_inline_style( $css );
		}
	}

	/**
	 * Builds the CSS for font variables.
	 *
	 * @return string The CSS for font variables.
	 */
	private function build_font_variables(): string {
		if ( $this->bridge->is_active() ) {
			$raw = $this->bridge->get_merged_raw_data();
			if ( is_array( $raw ) ) {
				$from_theme_json = $this->build_font_variables_from_merged( $raw );
				if ( '' !== $from_theme_json ) {
					return $from_theme_json;
				}
			}
		}

		return $this->build_font_variables_from_theme_mods();
	}

	/**
	 * Legacy Customizer theme_mod typography.
	 *
	 * @return string
	 */
	private function build_font_variables_from_theme_mods(): string {
		$rules = array(
			'family'      => '',
			'size'        => '-size',
			'style'       => '-style',
			'weight'      => '-weight',
			'line_height' => '-line-height',
		);

		$font_objects = array(
			'font_body'          => 'font-body',
			'font_menu'          => 'font-menu',
			'font_site_title'    => 'font-site-title',
			'font_site_subtitle' => 'font-site-subtitle',
			'font_widget_title'  => 'font-widget-title',
			'font_h1'            => 'font-heading-h1',
			'font_h2'            => 'font-heading-h2',
			'font_h3'            => 'font-heading-h3',
			'font_h4'            => 'font-heading-h4',
			'font_h5'            => 'font-heading-h5',
			'font_h6'            => 'font-heading-h6',
		);

		$css = '';

		foreach ( $font_objects as $font_object_slug => $font_variable_name ) {
			$is_enable = (int) get_theme_mod( "{$font_object_slug}_is_enable", 0 );

			if ( $is_enable ) {
				foreach ( $rules as $rule_slug => $rule_suffix ) {
					$font_data = get_theme_mod( "{$font_object_slug}_{$rule_slug}" );

					if ( ! empty( $font_data ) ) {
						$variable_name = $font_variable_name . $rule_suffix;
						$css          .= "--{$variable_name}: {$font_data};";
					}
				}
			}
		}

		return $css;
	}

	/**
	 * Map merged Theme JSON styles + custom widget typography to Origamiez CSS variables.
	 *
	 * @param array<string, mixed> $raw Merged Theme JSON.
	 *
	 * @return string
	 */
	private function build_font_variables_from_merged( array $raw ): string {
		$styles = $raw['styles'] ?? array();
		if ( ! is_array( $styles ) ) {
			$styles = array();
		}

		$css = '';

		$map = array(
			array(
				'css_base' => 'font-body',
				'path'     => array( 'elements', 'body' ),
			),
			array(
				'css_base' => 'font-menu',
				'path'     => array( 'blocks', 'core/navigation' ),
			),
			array(
				'css_base' => 'font-site-title',
				'path'     => array( 'blocks', 'core/site-title' ),
			),
			array(
				'css_base' => 'font-site-subtitle',
				'path'     => array( 'blocks', 'core/site-tagline' ),
			),
			array(
				'css_base' => 'font-heading-h1',
				'path'     => array( 'elements', 'h1' ),
			),
			array(
				'css_base' => 'font-heading-h2',
				'path'     => array( 'elements', 'h2' ),
			),
			array(
				'css_base' => 'font-heading-h3',
				'path'     => array( 'elements', 'h3' ),
			),
			array(
				'css_base' => 'font-heading-h4',
				'path'     => array( 'elements', 'h4' ),
			),
			array(
				'css_base' => 'font-heading-h5',
				'path'     => array( 'elements', 'h5' ),
			),
			array(
				'css_base' => 'font-heading-h6',
				'path'     => array( 'elements', 'h6' ),
			),
		);

		foreach ( $map as $item ) {
			$typo = $this->get_typography_at_style_path( $styles, $item['path'] );
			if ( null !== $typo ) {
				$css .= $this->typography_to_css_variables( $typo, $item['css_base'] );
			}
		}

		$settings = $raw['settings'] ?? array();
		if ( is_array( $settings ) ) {
			$widget_typo = $settings['custom']['origamiez']['widgetTitleTypography'] ?? null;
			if ( is_array( $widget_typo ) ) {
				$css .= $this->typography_to_css_variables( $widget_typo, 'font-widget-title' );
			}
		}

		return $css;
	}

	/**
	 * Read styles.*.typography at a nested path.
	 *
	 * @param array<string, mixed> $styles Root styles branch.
	 * @param array<int, string>   $path   Path segments (e.g. elements, body).
	 *
	 * @return array<string, mixed>|null
	 */
	private function get_typography_at_style_path( array $styles, array $path ): ?array {
		$node = $styles;
		foreach ( $path as $segment ) {
			if ( ! isset( $node[ $segment ] ) || ! is_array( $node[ $segment ] ) ) {
				return null;
			}
			$node = $node[ $segment ];
		}
		if ( empty( $node['typography'] ) || ! is_array( $node['typography'] ) ) {
			return null;
		}

		return $node['typography'];
	}

	/**
	 * Map Theme JSON typography keys to Origamiez --font-* custom properties.
	 *
	 * @param array<string, mixed> $typo     Theme JSON typography keys.
	 * @param string               $css_base CSS variable base (e.g. font-body).
	 *
	 * @return string
	 */
	private function typography_to_css_variables( array $typo, string $css_base ): string {
		$map = array(
			'fontFamily' => '',
			'fontSize'   => '-size',
			'fontStyle'  => '-style',
			'fontWeight' => '-weight',
			'lineHeight' => '-line-height',
		);

		$css = '';
		foreach ( $map as $json_key => $suffix ) {
			if ( empty( $typo[ $json_key ] ) || ! is_scalar( $typo[ $json_key ] ) ) {
				continue;
			}
			$val  = (string) $typo[ $json_key ];
			$safe = $this->sanitize_inline_css_value( $val );
			$var  = '--' . $css_base . $suffix;
			$css .= "{$var}: {$safe};";
		}

		return $css;
	}

	/**
	 * Strip characters that could break inline CSS declarations.
	 *
	 * @param string $value Raw value.
	 *
	 * @return string
	 */
	private function sanitize_inline_css_value( string $value ): string {
		$value = wp_strip_all_tags( $value );
		$value = str_replace( array( "\n", "\r", ';', '{', '}' ), '', $value );

		return trim( $value );
	}
}
