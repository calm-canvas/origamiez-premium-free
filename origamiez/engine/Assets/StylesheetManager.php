<?php

namespace Origamiez\Engine\Assets;

class StylesheetManager {

	private const PREFIX = 'origamiez_';
	private string $styleHandle = '';

	public function enqueue( string $templateUri ): void {
		$this->enqueueLibraryStyles( $templateUri );
		$this->enqueueThemeStyle();
		$this->enqueueGoogleFonts();
		$this->enqueueDynamicFonts();
	}

	private function enqueueLibraryStyles( string $templateUri ): void {
		$styles = [
			'bootstrap'         => 'css/bootstrap.css',
			'font-awesome'      => 'css/fontawesome.css',
			'jquery-owl-carousel' => 'css/owl.carousel.css',
			'jquery-owl-theme'  => 'css/owl.theme.default.css',
			'jquery-superfish'  => 'css/superfish.css',
			'jquery-navgoco'    => 'css/jquery.navgoco.css',
			'jquery-poptrox'    => 'css/jquery.poptrox.css',
		];

		foreach ( $styles as $handle => $path ) {
			wp_enqueue_style(
				self::PREFIX . $handle,
				trailingslashit( $templateUri ) . $path,
				[],
				null
			);
		}
	}

	private function enqueueThemeStyle(): void {
		$this->styleHandle = self::PREFIX . 'style';
		wp_enqueue_style(
			$this->styleHandle,
			get_stylesheet_uri(),
			[],
			null
		);
	}

	private function enqueueGoogleFonts(): void {
		if ( 'off' === _x( 'on', 'Google font: on or off', 'origamiez' ) ) {
			return;
		}

		$google_fonts_url = add_query_arg(
			'family',
			urlencode( 'Inter:wght@600;700&display=swap' ),
			'//fonts.googleapis.com/css2'
		);

		wp_enqueue_style(
			self::PREFIX . 'google-fonts',
			$google_fonts_url
		);
	}

	private function enqueueDynamicFonts(): void {
		$font_groups = [];
		$number_of_google_fonts = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );

		if ( $number_of_google_fonts ) {
			for ( $i = 0; $i < $number_of_google_fonts; $i++ ) {
				$font_family = get_theme_mod( sprintf( 'google_font_%s_name', $i ), '' );
				$font_src = get_theme_mod( sprintf( 'google_font_%s_src', $i ), '' );

				if ( $font_family && $font_src ) {
					$font_family_slug = $this->slugifyString( $font_family );
					$font_groups['dynamic'][ $font_family_slug ] = $font_src;
				}
			}
		}

		foreach ( $font_groups as $font_group ) {
			if ( $font_group ) {
				foreach ( $font_group as $font_slug => $font ) {
					wp_enqueue_style(
						self::PREFIX . $font_slug,
						$font,
						[],
						null
					);
				}
			}
		}
	}

	public function addInlineStyle( string $css ): void {
		if ( empty( $this->styleHandle ) ) {
			$this->styleHandle = self::PREFIX . 'style';
		}
		wp_add_inline_style( $this->styleHandle, $css );
	}

	private function slugifyString( string $str ): string {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', $str ) );
	}
}
