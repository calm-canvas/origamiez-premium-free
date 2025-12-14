<?php

namespace Origamiez\Engine\Hooks;

class HookRegistry {

	private array $hooks = [];
	private static ?self $instance = null;

	private function __construct() {
	}

	public static function getInstance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function addAction( string $hook, callable|string $callback, int $priority = 10, int $acceptedArgs = 1 ): self {
		add_action( $hook, $callback, $priority, $acceptedArgs );
		$this->hooks[] = [
			'type'          => 'action',
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $acceptedArgs,
		];
		return $this;
	}

	public function addFilter( string $hook, callable|string $callback, int $priority = 10, int $acceptedArgs = 1 ): self {
		add_filter( $hook, $callback, $priority, $acceptedArgs );
		$this->hooks[] = [
			'type'          => 'filter',
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $acceptedArgs,
		];
		return $this;
	}

	public function registerHooks( HookProviderInterface $provider ): self {
		$provider->register( $this );
		return $this;
	}

	public function getHooks(): array {
		return $this->hooks;
	}

	public function getHooksByType( string $type ): array {
		return array_filter( $this->hooks, fn( $hook ) => $hook['type'] === $type );
	}

	public function getHooksByName( string $name ): array {
		return array_filter( $this->hooks, fn( $hook ) => $hook['hook'] === $name );
	}

	public function removeAction( string $hook, callable|string $callback, int $priority = 10 ): bool {
		return remove_action( $hook, $callback, $priority );
	}

	public function removeFilter( string $hook, callable|string $callback, int $priority = 10 ): bool {
		return remove_filter( $hook, $callback, $priority );
	}
}
