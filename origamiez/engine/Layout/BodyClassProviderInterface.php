<?php
/**
 * Body Class Provider Interface
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout;

/**
 * Interface BodyClassProviderInterface
 *
 * @package Origamiez\Engine\Layout
 */
interface BodyClassProviderInterface {

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array;
}
