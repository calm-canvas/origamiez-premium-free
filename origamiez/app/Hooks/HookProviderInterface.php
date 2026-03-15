<?php
/**
 * Hook Provider Interface
 *
 * @package Origamiez
 */

namespace Origamiez\Hooks;

/**
 * Interface HookProviderInterface
 *
 * @package Origamiez\Hooks
 */
interface HookProviderInterface {

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void;
}
