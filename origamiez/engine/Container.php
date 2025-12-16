<?php

namespace Origamiez\Engine;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface {

	private array $services = [];
	private array $singletons = [];
	private static ?self $instance = null;

	private function __construct() {
	}

	public static function getInstance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function set( string $id, mixed $definition ): void {
		$this->services[ $id ] = $definition;
		unset( $this->singletons[ $id ] );
	}

	public function get( string $id ): mixed {
		if ( ! $this->has( $id ) ) {
			throw new class( "Service '{$id}' not found in container" ) extends Exception implements NotFoundExceptionInterface {
			};
		}

		if ( isset( $this->singletons[ $id ] ) && $this->singletons[ $id ] !== true ) {
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

	public function has( string $id ): bool {
		return isset( $this->services[ $id ] );
	}

	public function singleton( string $id, mixed $definition ): void {
		$this->set( $id, $definition );
		$this->singletons[ $id ] = true;
	}

	private function isSingleton( string $id ): bool {
		return isset( $this->singletons[ $id ] ) && $this->singletons[ $id ] === true;
	}

	public function bind( string $id, $implementation ): void {
		if ( is_string( $implementation ) && class_exists( $implementation ) ) {
			$this->set( $id, function ( $container ) use ( $implementation ) {
				return new $implementation();
			} );
		} else {
			$this->set( $id, $implementation );
		}
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws ReflectionException
	 * @throws NotFoundExceptionInterface
	 */
	public function make( string $id, array $parameters = [] ): mixed {
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
