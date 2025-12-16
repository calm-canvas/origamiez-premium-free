<?php

namespace Origamiez\Engine\Config;

class FontConfig {

	private array $fonts        = array();
	private array $fontSizes    = array();
	private string $defaultFont = 'default';

	public function __construct() {
		$this->initializeFonts();
		$this->initializeSizes();
	}

	private function initializeFonts(): void {
		$this->fonts = array(
			'default' => array(
				'name'     => 'Default Font Stack',
				'family'   => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
				'fallback' => 'sans-serif',
				'weights'  => array( 400, 500, 600, 700 ),
			),
			'heading' => array(
				'name'     => 'Heading Font',
				'family'   => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
				'fallback' => 'sans-serif',
				'weights'  => array( 400, 700 ),
			),
		);
	}

	private function initializeSizes(): void {
		$this->fontSizes = array(
			'small'  => '12px',
			'base'   => '14px',
			'medium' => '16px',
			'large'  => '18px',
			'xlarge' => '20px',
			'h6'     => '14px',
			'h5'     => '16px',
			'h4'     => '18px',
			'h3'     => '24px',
			'h2'     => '28px',
			'h1'     => '32px',
		);
	}

	public function registerFont( string $id, array $config ): void {
		$this->fonts[ $id ] = array_merge(
			array(
				'name'     => $id,
				'family'   => '',
				'fallback' => 'sans-serif',
				'weights'  => array(),
			),
			$config
		);
	}

	public function getFont( string $id ): ?array {
		return $this->fonts[ $id ] ?? null;
	}

	public function getAllFonts(): array {
		return $this->fonts;
	}

	public function getDefaultFont(): string {
		return $this->defaultFont;
	}

	public function setDefaultFont( string $id ): bool {
		if ( ! isset( $this->fonts[ $id ] ) ) {
			return false;
		}
		$this->defaultFont = $id;
		return true;
	}

	public function getFontFamily( string $id ): string {
		$font = $this->getFont( $id );
		return $font['family'] ?? '';
	}

	public function getFontFallback( string $id ): string {
		$font = $this->getFont( $id );
		return $font['fallback'] ?? 'sans-serif';
	}

	public function registerFontSize( string $key, string $size ): void {
		$this->fontSizes[ $key ] = $size;
	}

	public function getFontSize( string $key ): ?string {
		return $this->fontSizes[ $key ] ?? null;
	}

	public function getAllFontSizes(): array {
		return $this->fontSizes;
	}

	public function setFontSizes( array $sizes ): void {
		$this->fontSizes = $sizes;
	}
}
