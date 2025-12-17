<?php
/**
 * Hook Provider Interface
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Hooks;

/**
 * Interface HookProviderInterface
 *
 * @package Origamiez\Engine\Hooks
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
