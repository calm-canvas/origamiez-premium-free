<?php
/**
 * Generates inline styles.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Engine\Assets;

/**
 * Class InlineStyleGenerator
 */
class InlineStyleGenerator {

	private const PREFIX = 'origamiez_';

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
			'body_color'                           => '#333333',
			'heading_color'                        => '#111111',
			'link_color'                           => '#111111',
			'link_hover_color'                     => '#00589f',
			'primary_color'                        => '#111111',
			'secondary_color'                      => '#f5f7fa',
			'main_menu_color'                      => '#111111',
			'main_menu_bg_color'                   => '#ffffff',
			'main_menu_hover_color'                => '#00589f',
			'main_menu_active_color'               => '#111111',
			'line_1_bg_color'                      => '#e8ecf1',
			'line_2_bg_color'                      => '#f0f2f5',
			'line_3_bg_color'                      => '#f8fafc',
			'footer_sidebars_bg_color'             => '#222222',
			'footer_sidebars_text_color'           => '#a0a0a0',
			'footer_sidebars_widget_heading_color' => '#ffffff',
			'footer_end_bg_color'                  => '#111111',
			'footer_end_text_color'                => '#a0a0a0',
			'metadata_color'                       => '#666666',
			'color_success'                        => '#27ae60',
		);

		$css  = '';
		$css .= '--white: #ffffff;';
		$css .= '--black: #000000;';
		$css .= '--black_light: ' . get_theme_mod( 'black_light_color', '#f8fafc' ) . ';';
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
		$rules = array(
			'family'      => '-family',
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
}
