<?php
/**
 * Skin Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class SkinConfig
 *
 * Manages theme skins with support for colors and fonts.
 * Extends AbstractConfigRegistry to eliminate boilerplate code.
 */
class SkinConfig extends AbstractConfigRegistry {

	/**
	 * Get the initializer method.
	 *
	 * @return string
	 */
	protected function get_initializer_method(): string {
		return 'initialize_skins';
	}

	/**
	 * Initialize default skins.
	 */
	private function initialize_skins(): void {
		$this->items = array(
			'default' => array(
				'name'   => 'Default',
				'colors' => array(
					'primary'   => '#333333',
					'secondary' => '#666666',
					'accent'    => '#0066cc',
				),
				'fonts'  => array(),
			),
		);
	}

	/**
	 * Register a skin.
	 *
	 * @param string $id Skin ID.
	 * @param array  $config Skin config.
	 */
	public function register_skin( string $id, array $config ): void {
		$this->register_item(
			$id,
			$config,
			array(
				'name'   => $id,
				'colors' => array(),
				'fonts'  => array(),
			)
		);
	}

	/**
	 * Get a skin by ID.
	 *
	 * @param string $id Skin ID.
	 * @return array|null
	 */
	public function get_skin( string $id ): ?array {
		return $this->get_item( $id );
	}

	/**
	 * Get all skins.
	 *
	 * @return array
	 */
	public function get_all_skins(): array {
		return $this->get_all_items();
	}

	/**
	 * Get the active skin ID.
	 *
	 * @return string
	 */
	public function get_active_skin(): string {
		return $this->get_default_id();
	}

	/**
	 * Set the active skin.
	 *
	 * @param string $id Skin ID.
	 * @return bool
	 */
	public function set_active_skin( string $id ): bool {
		return $this->set_default_id( $id );
	}

	/**
	 * Get a color from a skin.
	 *
	 * @param string      $color_key Color key.
	 * @param string|null $skin_id Skin ID (defaults to active skin).
	 * @return string|null
	 */
	public function get_skin_color( string $color_key, string $skin_id = null ): ?string {
		$skin_id = $skin_id ?? $this->default_id;
		return $this->get_item_property( $skin_id, "colors.{$color_key}" ) ??
			$this->get_item_property( $skin_id, 'colors' )[ $color_key ] ?? null;
	}

	/**
	 * Get a font from a skin.
	 *
	 * @param string      $font_key Font key.
	 * @param string|null $skin_id Skin ID (defaults to active skin).
	 * @return array|null
	 */
	public function get_skin_font( string $font_key, string $skin_id = null ): ?array {
		$skin_id = $skin_id ?? $this->default_id;
		$fonts   = $this->get_item_property( $skin_id, 'fonts' ) ?? array();
		return $fonts[ $font_key ] ?? null;
	}
}
