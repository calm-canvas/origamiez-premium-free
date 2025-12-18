<?php
/**
 * Font Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class FontConfig
 *
 * Manages typography fonts and sizes for the theme.
 * Extends AbstractConfigRegistry to eliminate boilerplate code.
 */
class FontConfig extends AbstractConfigRegistry {

	/**
	 * Font sizes.
	 *
	 * @var array
	 */
	private array $font_sizes = array();

	/**
	 * Get the initializer method.
	 *
	 * @return string
	 */
	protected function get_initializer_method(): string {
		return 'initialize_fonts';
	}

	/**
	 * Initialize default fonts.
	 */
	private function initialize_fonts(): void {
		$this->items = array(
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
		$this->initialize_sizes();
	}

	/**
	 * Initialize font sizes.
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
	 * Register a font.
	 *
	 * @param string $id Font ID.
	 * @param array  $config Font config.
	 */
	public function register_font( string $id, array $config ): void {
		$this->register_item(
			$id,
			$config,
			array(
				'name'     => $id,
				'family'   => '',
				'fallback' => 'sans-serif',
				'weights'  => array(),
			)
		);
	}

	/**
	 * Get a font by ID.
	 *
	 * @param string $id Font ID.
	 * @return array|null
	 */
	public function get_font( string $id ): ?array {
		return $this->get_item( $id );
	}

	/**
	 * Get all fonts.
	 *
	 * @return array
	 */
	public function get_all_fonts(): array {
		return $this->get_all_items();
	}

	/**
	 * Get the default font ID.
	 *
	 * @return string
	 */
	public function get_default_font(): string {
		return $this->get_default_id();
	}

	/**
	 * Set the default font.
	 *
	 * @param string $id Font ID.
	 * @return bool
	 */
	public function set_default_font( string $id ): bool {
		return $this->set_default_id( $id );
	}

	/**
	 * Get the font family for a font.
	 *
	 * @param string $id Font ID.
	 * @return string
	 */
	public function get_font_family( string $id ): string {
		return $this->get_item_property( $id, 'family', '' );
	}

	/**
	 * Get the fallback font for a font.
	 *
	 * @param string $id Font ID.
	 * @return string
	 */
	public function get_font_fallback( string $id ): string {
		return $this->get_item_property( $id, 'fallback', 'sans-serif' );
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
