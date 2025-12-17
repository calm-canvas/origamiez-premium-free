<?php
/**
 * Hook Registry
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Hooks;

/**
 * Class HookRegistry
 *
 * @package Origamiez\Engine\Hooks
 */
class HookRegistry {

	/**
	 * Hooks
	 *
	 * @var array
	 */
	private array $hooks = array();

	/**
	 * Instance
	 *
	 * @var self|null
	 */
	private static ?self $instance = null;

	/**
	 * Hook_Registry constructor.
	 */
	private function __construct() {
	}

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add action.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 * @param integer         $accepted_args The accepted args.
	 *
	 * @return self
	 */
	public function add_action( string $hook, callable|string $callback, int $priority = 10, int $accepted_args = 1 ): self {
		add_action( $hook, $callback, $priority, $accepted_args );
		$this->hooks[] = array(
			'type'          => 'action',
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);
		return $this;
	}

	/**
	 * Add filter.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 * @param integer         $accepted_args The accepted args.
	 *
	 * @return self
	 */
	public function add_filter( string $hook, callable|string $callback, int $priority = 10, int $accepted_args = 1 ): self {
		add_filter( $hook, $callback, $priority, $accepted_args );
		$this->hooks[] = array(
			'type'          => 'filter',
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);
		return $this;
	}

	/**
	 * Register hooks.
	 *
	 * @param HookProviderInterface $provider The provider.
	 *
	 * @return self
	 */
	public function register_hooks( HookProviderInterface $provider ): self {
		$provider->register( $this );
		return $this;
	}

	/**
	 * Get hooks.
	 *
	 * @return array
	 */
	public function get_hooks(): array {
		return $this->hooks;
	}

	/**
	 * Get hooks by type.
	 *
	 * @param string $type The type.
	 *
	 * @return array
	 */
	public function get_hooks_by_type( string $type ): array {
		return array_filter( $this->hooks, fn( $hook ) => $hook['type'] === $type );
	}

	/**
	 * Get hooks by name.
	 *
	 * @param string $name The name.
	 *
	 * @return array
	 */
	public function get_hooks_by_name( string $name ): array {
		return array_filter( $this->hooks, fn( $hook ) => $hook['hook'] === $name );
	}

	/**
	 * Remove action.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 *
	 * @return boolean
	 */
	public function remove_action( string $hook, callable|string $callback, int $priority = 10 ): bool {
		return remove_action( $hook, $callback, $priority );
	}

	/**
	 * Remove filter.
	 *
	 * @param string          $hook The hook.
	 * @param callable|string $callback The callback.
	 * @param integer         $priority The priority.
	 *
	 * @return boolean
	 */
	public function remove_filter( string $hook, callable|string $callback, int $priority = 10 ): bool {
		return remove_filter( $hook, $callback, $priority );
	}
}
