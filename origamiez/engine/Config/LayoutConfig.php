<?php
/**
 * Layout Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class LayoutConfig
 */
class LayoutConfig {

	/**
	 * Layouts.
	 *
	 * @var array
	 */
	private array $layouts = array();

	/**
	 * Default layout.
	 *
	 * @var string
	 */
	private string $default_layout = 'default';

	/**
	 * LayoutConfig constructor.
	 */
	public function __construct() {
		$this->initialize_layouts();
	}

	/**
	 * Initialize layouts.
	 */
	private function initialize_layouts(): void {
		$this->layouts = array(
			'default'            => array(
				'name'    => 'Default Layout',
				'sidebar' => 'right',
				'columns' => 2,
			),
			'fullwidth'          => array(
				'name'    => 'Full Width',
				'sidebar' => 'none',
				'columns' => 1,
			),
			'fullwidth-centered' => array(
				'name'     => 'Full Width Centered',
				'sidebar'  => 'none',
				'columns'  => 1,
				'centered' => true,
			),
			'magazine'           => array(
				'name'    => 'Magazine',
				'sidebar' => 'right',
				'columns' => 2,
				'feature' => 'magazine',
			),
			'three-cols'         => array(
				'name'    => 'Three Columns',
				'sidebar' => 'both',
				'columns' => 3,
			),
			'three-cols-slm'     => array(
				'name'    => 'Three Columns - Small Left/Middle',
				'sidebar' => 'both',
				'columns' => 3,
				'slim'    => true,
			),
		);
	}

	/**
	 * Register layout.
	 *
	 * @param string $id Layout ID.
	 * @param array  $config Layout config.
	 */
	public function register_layout( string $id, array $config ): void {
		$this->layouts[ $id ] = array_merge(
			array(
				'name'    => $id,
				'sidebar' => 'right',
				'columns' => 2,
			),
			$config
		);
	}

	/**
	 * Get layout.
	 *
	 * @param string $id Layout ID.
	 * @return array|null
	 */
	public function get_layout( string $id ): ?array {
		return $this->layouts[ $id ] ?? null;
	}

	/**
	 * Get all layouts.
	 *
	 * @return array
	 */
	public function get_all_layouts(): array {
		return $this->layouts;
	}

	/**
	 * Get default layout.
	 *
	 * @return string
	 */
	public function get_default_layout(): string {
		return $this->default_layout;
	}

	/**
	 * Set default layout.
	 *
	 * @param string $id Layout ID.
	 * @return bool
	 */
	public function set_default_layout( string $id ): bool {
		if ( ! isset( $this->layouts[ $id ] ) ) {
			return false;
		}
		$this->default_layout = $id;
		return true;
	}

	/**
	 * Get layout sidebar.
	 *
	 * @param string $layout_id Layout ID.
	 * @return string
	 */
	public function get_layout_sidebar( string $layout_id ): string {
		$layout = $this->get_layout( $layout_id );
		return $layout['sidebar'] ?? 'right';
	}

	/**
	 * Get layout columns.
	 *
	 * @param string $layout_id Layout ID.
	 * @return int
	 */
	public function get_layout_columns( string $layout_id ): int {
		$layout = $this->get_layout( $layout_id );
		return $layout['columns'] ?? 2;
	}

	/**
	 * Is fullwidth.
	 *
	 * @param string $layout_id Layout ID.
	 * @return bool
	 */
	public function is_fullwidth( string $layout_id ): bool {
		$layout = $this->get_layout( $layout_id );
		return isset( $layout['sidebar'] ) && 'none' === $layout['sidebar'];
	}
}
