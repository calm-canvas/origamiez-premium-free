<?php
/**
 * Skin Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class SkinConfig
 */
class SkinConfig {

	/**
	 * Skins.
	 *
	 * @var array
	 */
	private array $skins = array();

	/**
	 * Active skin.
	 *
	 * @var string
	 */
	private string $active_skin = 'default';

	/**
	 * SkinConfig constructor.
	 */
	public function __construct() {
		$this->initialize_skins();
	}

	/**
	 * Initialize skins.
	 */
	private function initialize_skins(): void {
		$this->skins = array(
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
	 * Register skin.
	 *
	 * @param string $id Skin ID.
	 * @param array  $config Skin config.
	 */
	public function register_skin( string $id, array $config ): void {
		$this->skins[ $id ] = array_merge(
			array(
				'name'   => $id,
				'colors' => array(),
				'fonts'  => array(),
			),
			$config
		);
	}

	/**
	 * Get skin.
	 *
	 * @param string $id Skin ID.
	 * @return array|null
	 */
	public function get_skin( string $id ): ?array {
		return $this->skins[ $id ] ?? null;
	}

	/**
	 * Get all skins.
	 *
	 * @return array
	 */
	public function get_all_skins(): array {
		return $this->skins;
	}

	/**
	 * Get active skin.
	 *
	 * @return string
	 */
	public function get_active_skin(): string {
		return $this->active_skin;
	}

	/**
	 * Set active skin.
	 *
	 * @param string $id Skin ID.
	 * @return bool
	 */
	public function set_active_skin( string $id ): bool {
		if ( ! isset( $this->skins[ $id ] ) ) {
			return false;
		}
		$this->active_skin = $id;
		return true;
	}

	/**
	 * Get skin color.
	 *
	 * @param string      $color_key Color key.
	 * @param string|null $skin_id Skin ID.
	 * @return string|null
	 */
	public function get_skin_color( string $color_key, string $skin_id = null ): ?string {
		$skin = $this->get_skin( $skin_id ?? $this->active_skin );
		if ( null === $skin ) {
			return null;
		}
		return $skin['colors'][ $color_key ] ?? null;
	}

	/**
	 * Get skin font.
	 *
	 * @param string      $font_key Font key.
	 * @param string|null $skin_id Skin ID.
	 * @return array|null
	 */
	public function get_skin_font( string $font_key, string $skin_id = null ): ?array {
		$skin = $this->get_skin( $skin_id ?? $this->active_skin );
		if ( null === $skin ) {
			return null;
		}
		return $skin['fonts'][ $font_key ] ?? null;
	}
}
