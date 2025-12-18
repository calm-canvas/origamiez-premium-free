<?php
/**
 * Abstract Config Registry
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Abstract class AbstractConfigRegistry
 *
 * Provides a reusable template for managing collections of configurations
 * (skins, layouts, fonts, etc.) with a default item.
 *
 * This consolidates duplicate code from SkinConfig, LayoutConfig, FontConfig.
 *
 * @package Origamiez\Engine\Config
 */
abstract class AbstractConfigRegistry {

	/**
	 * Items registered in this registry.
	 *
	 * @var array
	 */
	protected array $items = array();

	/**
	 * Currently active/default item ID.
	 *
	 * @var string
	 */
	protected string $default_id = 'default';

	/**
	 * Get the initialization hook name.
	 *
	 * Subclasses should implement this to specify which method initializes items.
	 *
	 * @return string The method name to call during construction.
	 */
	abstract protected function get_initializer_method(): string;

	/**
	 * AbstractConfigRegistry constructor.
	 *
	 * Calls the initializer method specified by subclass.
	 */
	public function __construct() {
		$method = $this->get_initializer_method();
		if ( method_exists( $this, $method ) ) {
			$this->$method();
		}
	}

	/**
	 * Register or update an item with default merging.
	 *
	 * @param string $id Item ID.
	 * @param array  $config Item configuration.
	 * @param array  $defaults Default values for this item type.
	 */
	protected function register_item( string $id, array $config, array $defaults ): void {
		$this->items[ $id ] = array_merge( $defaults, $config );
	}

	/**
	 * Get a single item by ID.
	 *
	 * @param string $id Item ID.
	 * @return array|null The item or null if not found.
	 */
	public function get_item( string $id ): ?array {
		return $this->items[ $id ] ?? null;
	}

	/**
	 * Get all registered items.
	 *
	 * @return array All items in registry.
	 */
	public function get_all_items(): array {
		return $this->items;
	}

	/**
	 * Get the currently active/default item ID.
	 *
	 * @return string The default item ID.
	 */
	public function get_default_id(): string {
		return $this->default_id;
	}

	/**
	 * Set the active/default item by ID.
	 *
	 * @param string $id Item ID.
	 * @return bool True if item exists and was set, false otherwise.
	 */
	public function set_default_id( string $id ): bool {
		if ( ! isset( $this->items[ $id ] ) ) {
			return false;
		}
		$this->default_id = $id;
		return true;
	}

	/**
	 * Get a nested property from the default item.
	 *
	 * @param string $key Property key.
	 * @param mixed  $default Default value if key not found.
	 * @return mixed The property value or default.
	 */
	protected function get_default_item_property( string $key, $default = null ) {
		$item = $this->get_item( $this->default_id );
		return $item[ $key ] ?? $default;
	}

	/**
	 * Get a nested property from a specific item.
	 *
	 * @param string $item_id Item ID.
	 * @param string $key Property key.
	 * @param mixed  $default Default value if key not found.
	 * @return mixed The property value or default.
	 */
	protected function get_item_property( string $item_id, string $key, $default = null ) {
		$item = $this->get_item( $item_id );
		return $item[ $key ] ?? $default;
	}
}
