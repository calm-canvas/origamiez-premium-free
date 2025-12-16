<?php

namespace Origamiez\Engine\Assets;

class FontManager {

	private const PREFIX = 'origamiez_';
	private string $templateUri;

	public function __construct( string $templateUri ) {
		$this->templateUri = $templateUri;
	}

	public function enqueue(): void {
		$this->enqueueGoogleFonts();
		$this->enqueueDynamicFonts();
	}

	private function enqueueGoogleFonts(): void {
		if ( 'off' === _x( 'on', 'Google font: on or off', 'origamiez' ) ) {
			return;
		}

		$googleFontsUrl = add_query_arg(
			'family',
			urlencode( 'Inter:wght@600;700&display=swap' ),
			'//fonts.googleapis.com/css2'
		);

		wp_enqueue_style(
			self::PREFIX . 'google-fonts',
			$googleFontsUrl
		);
	}

	private function enqueueDynamicFonts(): void {
		$fontGroups          = array();
		$numberOfGoogleFonts = (int) apply_filters( 'origamiez_get_number_of_google_fonts', 3 );

		if ( $numberOfGoogleFonts ) {
			for ( $i = 0; $i < $numberOfGoogleFonts; $i++ ) {
				$fontFamily = get_theme_mod( sprintf( 'google_font_%s_name', $i ), '' );
				$fontSrc    = get_theme_mod( sprintf( 'google_font_%s_src', $i ), '' );

				if ( $fontFamily && $fontSrc ) {
					$fontFamilySlug                           = $this->slugifyString( $fontFamily );
					$fontGroups['dynamic'][ $fontFamilySlug ] = $fontSrc;
				}
			}
		}

		foreach ( $fontGroups as $fontGroup ) {
			if ( $fontGroup ) {
				foreach ( $fontGroup as $fontSlug => $font ) {
					wp_enqueue_style(
						self::PREFIX . $fontSlug,
						$font,
						array(),
						null
					);
				}
			}
		}
	}

	private function slugifyString( string $str ): string {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-]/', '-', $str ) );
	}
}
