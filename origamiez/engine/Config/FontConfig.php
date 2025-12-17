<?php
/**
 * Font Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class FontConfig
 */
class FontConfig {

	/**
	 * Fonts.
	 *
	 * @var array
	 */
	private array $fonts = array();

	/**
	 * Font sizes.
	 *
	 * @var array
	 */
	private array $font_sizes = array();

	/**
	 * Default font.
	 *
	 * @var string
	 */
	private string $default_font = 'default';

	/**
	 * FontConfig constructor.
	 */
	public function __construct() {
		$this->initialize_fonts();
		$this->initialize_sizes();
	}

	/**
	 * Initialize fonts.
	 */
	private function initialize_fonts(): void {
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

	/**
	 * Initialize sizes.
	 */
	private function initialize_sizes(): void {
		$this->font_sizes = array(
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

	/**
	 * Register font.
	 *
	 * @param string $id Font ID.
	 * @param array  $config Font config.
	 */
	public function register_font( string $id, array $config ): void {
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

	/**
	 * Get font.
	 *
	 * @param string $id Font ID.
	 * @return array|null
	 */
	public function get_font( string $id ): ?array {
		return $this->fonts[ $id ] ?? null;
	}

	/**
	 * Get all fonts.
	 *
	 * @return array
	 */
	public function get_all_fonts(): array {
		return $this->fonts;
	}

	/**
	 * Get default font.
	 *
	 * @return string
	 */
	public function get_default_font(): string {
		return $this->default_font;
	}

	/**
	 * Set default font.
	 *
	 * @param string $id Font ID.
	 * @return bool
	 */
	public function set_default_font( string $id ): bool {
		if ( ! isset( $this->fonts[ $id ] ) ) {
			return false;
		}
		$this->default_font = $id;
		return true;
	}

	/**
	 * Get font family.
	 *
	 * @param string $id Font ID.
	 * @return string
	 */
	public function get_font_family( string $id ): string {
		$font = $this->get_font( $id );
		return $font['family'] ?? '';
	}

	/**
	 * Get font fallback.
	 *
	 * @param string $id Font ID.
	 * @return string
	 */
	public function get_font_fallback( string $id ): string {
		$font = $this->get_font( $id );
		return $font['fallback'] ?? 'sans-serif';
	}

	/**
	 * Register font size.
	 *
	 * @param string $key Size key.
	 * @param string $size Size value.
	 */
	public function register_font_size( string $key, string $size ): void {
		$this->font_sizes[ $key ] = $size;
	}

	/**
	 * Get font size.
	 *
	 * @param string $key Size key.
	 * @return string|null
	 */
	public function get_font_size( string $key ): ?string {
		return $this->font_sizes[ $key ] ?? null;
	}

	/**
	 * Get all font sizes.
	 *
	 * @return array
	 */
	public function get_all_font_sizes(): array {
		return $this->font_sizes;
	}

	/**
	 * Set font sizes.
	 *
	 * @param array $sizes Font sizes.
	 */
	public function set_font_sizes( array $sizes ): void {
		$this->font_sizes = $sizes;
	}
}
