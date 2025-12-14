<?php

namespace Origamiez\Engine\Assets;

class InlineStyleGenerator {

	private const PREFIX = 'origamiez_';

	public function addInlineStyles( StylesheetManager $stylesheetManager ): void {
		$this->addColorVariables( $stylesheetManager );
		$this->addFontVariables( $stylesheetManager );
	}

	private function addColorVariables( StylesheetManager $stylesheetManager ): void {
		$skin = get_theme_mod( 'skin', 'default' );

		if ( 'custom' !== $skin ) {
			return;
		}

		$colorVariables = $this->buildColorVariables();
		$css = ':root {' . $colorVariables . '}';

		$stylesheetManager->addInlineStyle( $css );
	}

	private function buildColorVariables(): string {
		$colors = [
			'--body-color'                            => 'body_color',
			'--heading-color'                         => 'heading_color',
			'--link-color'                            => 'link_color',
			'--link-hover-color'                      => 'link_hover_color',
			'--primary-color'                         => 'primary_color',
			'--secondary-color'                       => 'secondary_color',
			'--main-menu-color'                       => 'main_menu_color',
			'--main-menu-bg-color'                    => 'main_menu_bg_color',
			'--main-menu-hover-color'                 => 'main_menu_hover_color',
			'--main-menu-active-color'                => 'main_menu_active_color',
			'--line-1-bg-color'                       => 'line_1_bg_color',
			'--line-2-bg-color'                       => 'line_2_bg_color',
			'--line-3-bg-color'                       => 'line_3_bg_color',
			'--footer-sidebars-bg-color'              => 'footer_sidebars_bg_color',
			'--footer-sidebars-text-color'            => 'footer_sidebars_text_color',
			'--footer-sidebars-widget-heading-color'  => 'footer_sidebars_widget_heading_color',
			'--footer-end-bg-color'                   => 'footer_end_bg_color',
			'--footer-end-text-color'                 => 'footer_end_text_color',
			'--metadata-color'                        => 'metadata_color',
			'--color-success'                         => 'color_success',
		];

		$defaultColors = [
			'body_color'                            => '#333333',
			'heading_color'                         => '#111111',
			'link_color'                            => '#111111',
			'link_hover_color'                      => '#00589f',
			'primary_color'                         => '#111111',
			'secondary_color'                       => '#f5f7fa',
			'main_menu_color'                       => '#111111',
			'main_menu_bg_color'                    => '#ffffff',
			'main_menu_hover_color'                 => '#00589f',
			'main_menu_active_color'                => '#111111',
			'line_1_bg_color'                       => '#e8ecf1',
			'line_2_bg_color'                       => '#f0f2f5',
			'line_3_bg_color'                       => '#f8fafc',
			'footer_sidebars_bg_color'              => '#222222',
			'footer_sidebars_text_color'            => '#a0a0a0',
			'footer_sidebars_widget_heading_color'  => '#ffffff',
			'footer_end_bg_color'                   => '#111111',
			'footer_end_text_color'                 => '#a0a0a0',
			'metadata_color'                        => '#666666',
			'color_success'                         => '#27ae60',
		];

		$css = '';
		$css .= '--white: #ffffff;';
		$css .= '--black: #000000;';
		$css .= '--black_light: ' . get_theme_mod( 'black_light_color', '#f8fafc' ) . ';';
		$css .= '--overlay_white: rgba(255, 255, 255, 0.85);';
		$css .= '--overlay_black: rgba(0, 0, 0, 0.75);';

		foreach ( $colors as $cssVar => $option ) {
			$default = $defaultColors[ $option ] ?? '';
			$value = get_theme_mod( $option, $default );
			$css .= $cssVar . ': ' . $value . ';';
		}

		return $css;
	}

	private function addFontVariables( StylesheetManager $stylesheetManager ): void {
		$cssVariables = $this->buildFontVariables();

		if ( ! empty( $cssVariables ) ) {
			$css = ':root {' . $cssVariables . '}';
			$stylesheetManager->addInlineStyle( $css );
		}
	}

	private function buildFontVariables(): string {
		$rules = [
			'family'     => '-family',
			'size'       => '-size',
			'style'      => '-style',
			'weight'     => '-weight',
			'line_height' => '-line-height',
		];

		$fontObjects = [
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
		];

		$css = '';

		foreach ( $fontObjects as $fontObjectSlug => $fontVariableName ) {
			$isEnable = (int) get_theme_mod( "{$fontObjectSlug}_is_enable", 0 );

			if ( $isEnable ) {
				foreach ( $rules as $ruleSlug => $ruleSuffix ) {
					$fontData = get_theme_mod( "{$fontObjectSlug}_{$ruleSlug}" );

					if ( ! empty( $fontData ) ) {
						$variableName = $fontVariableName . $ruleSuffix;
						$css .= "--{$variableName}: {$fontData};";
					}
				}
			}
		}

		return $css;
	}
}
