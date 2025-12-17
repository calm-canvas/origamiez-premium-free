<?php
/**
 * PSR-11 Container
 *
 * @package Origamiez
 */

namespace Origamiez\Engine;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use ReflectionClass;
use ReflectionException;

/**
 * A simple PSR-11 container.
 */
class Container implements ContainerInterface {

	/**
	 * The container's services.
	 *
	 * @var array
	 */
	private array $services = array();

	/**
	 * The container's singletons.
	 *
	 * @var array
	 */
	private array $singletons = array();

	/**
	 * The container's instance.
	 *
	 * @var self|null
	 */
	private static ?self $instance = null;

	/**
	 * Container constructor.
	 */
	private function __construct() {
	}

	/**
	 * Get the container instance.
	 *
	 * @return self
	 */
	public static function getInstance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Set a service.
	 *
	 * @param string $id The service ID.
	 * @param mixed  $definition The service definition.
	 */
	public function set( string $id, mixed $definition ): void {
		$this->services[ $id ] = $definition;
		unset( $this->singletons[ $id ] );
	}

	/**
	 * Get a service.
	 *
	 * @param string $id The service ID.
	 * @return mixed
	 * @throws NotFoundExceptionInterface If the service is not found.
	 */
	public function get( string $id ): mixed {
		if ( ! $this->has( $id ) ) {
			throw new class( sprintf( esc_html__( 'Service %s not found in container', 'origamiez' ), $id ) ) extends Exception implements NotFoundExceptionInterface {
			};
		}

		if ( isset( $this->singletons[ $id ] ) && true !== $this->singletons[ $id ] ) {
			return $this->singletons[ $id ];
		}

		$definition = $this->services[ $id ];

		if ( is_callable( $definition ) ) {
			$instance = $definition( $this );
		} else {
			$instance = $definition;
		}

		if ( $this->isSingleton( $id ) ) {
			$this->singletons[ $id ] = $instance;
		}

		return $instance;
	}

	/**
	 * Check if a service exists.
	 *
	 * @param string $id The service ID.
	 * @return bool
	 */
	public function has( string $id ): bool {
		return isset( $this->services[ $id ] );
	}

	/**
	 * Set a singleton service.
	 *
	 * @param string $id The service ID.
	 * @param mixed  $definition The service definition.
	 */
	public function singleton( string $id, mixed $definition ): void {
		$this->set( $id, $definition );
		$this->singletons[ $id ] = true;
	}

	/**
	 * Check if a service is a singleton.
	 *
	 * @param string $id The service ID.
	 * @return bool
	 */
	private function isSingleton( string $id ): bool {
		return isset( $this->singletons[ $id ] ) && true === $this->singletons[ $id ];
	}

	/**
	 * Bind a service.
	 *
	 * @param string $id The service ID.
	 * @param mixed  $implementation The service implementation.
	 */
	public function bind( string $id, $implementation ): void {
		if ( is_string( $implementation ) && class_exists( $implementation ) ) {
			$this->set(
				$id,
				function () use ( $implementation ) {
					return new $implementation();
				}
			);
		} else {
			$this->set( $id, $implementation );
		}
	}

	/**
	 * Make a service.
	 *
	 * @param string $id The service ID.
	 * @param array  $parameters The service parameters.
	 * @return mixed
	 * @throws ContainerExceptionInterface If there is an error while making the service.
	 * @throws NotFoundExceptionInterface If the service is not found.
	 * @throws ReflectionException If the class does not exist.
	 */
	public function make( string $id, array $parameters = array() ): mixed {
		if ( ! class_exists( $id ) ) {
			return $this->get( $id );
		}

		if ( empty( $parameters ) ) {
			return new $id();
		}

		$reflection = new ReflectionClass( $id );
		return $reflection->newInstanceArgs( $parameters );
	}
}
