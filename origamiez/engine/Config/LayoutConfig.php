<?php
/**
 * Layout Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class LayoutConfig
 *
 * Manages theme layouts with customizable sidebars and column configurations.
 * Extends AbstractConfigRegistry to eliminate boilerplate code.
 */
class LayoutConfig extends AbstractConfigRegistry {

	/**
	 * Get the initializer method.
	 *
	 * @return string
	 */
	protected function get_initializer_method(): string {
		return 'initialize_layouts';
	}

	/**
	 * Initialize default layouts.
	 */
	private function initialize_layouts(): void {
		$this->items = array(
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
	 * Register a layout.
	 *
	 * @param string $id Layout ID.
	 * @param array  $config Layout config.
	 */
	public function register_layout( string $id, array $config ): void {
		$this->register_item(
			$id,
			$config,
			array(
				'name'    => $id,
				'sidebar' => 'right',
				'columns' => 2,
			)
		);
	}

	/**
	 * Get a layout by ID.
	 *
	 * @param string $id Layout ID.
	 * @return array|null
	 */
	public function get_layout( string $id ): ?array {
		return $this->get_item( $id );
	}

	/**
	 * Get all layouts.
	 *
	 * @return array
	 */
	public function get_all_layouts(): array {
		return $this->get_all_items();
	}

	/**
	 * Get the default layout ID.
	 *
	 * @return string
	 */
	public function get_default_layout(): string {
		return $this->get_default_id();
	}

	/**
	 * Set the default layout.
	 *
	 * @param string $id Layout ID.
	 * @return bool
	 */
	public function set_default_layout( string $id ): bool {
		return $this->set_default_id( $id );
	}

	/**
	 * Get the sidebar configuration for a layout.
	 *
	 * @param string $layout_id Layout ID.
	 * @return string
	 */
	public function get_layout_sidebar( string $layout_id ): string {
		return $this->get_item_property( $layout_id, 'sidebar', 'right' );
	}

	/**
	 * Get the column count for a layout.
	 *
	 * @param string $layout_id Layout ID.
	 * @return int
	 */
	public function get_layout_columns( string $layout_id ): int {
		return (int) $this->get_item_property( $layout_id, 'columns', 2 );
	}

	/**
	 * Check if a layout uses full width (no sidebar).
	 *
	 * @param string $layout_id Layout ID.
	 * @return bool
	 */
	public function is_fullwidth( string $layout_id ): bool {
		return 'none' === $this->get_layout_sidebar( $layout_id );
	}
}
