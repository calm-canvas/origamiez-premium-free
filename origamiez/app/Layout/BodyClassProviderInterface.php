<?php
/**
 * Body Class Provider Interface
 *
 * @package Origamiez
 */

namespace Origamiez\Layout;

/**
 * Interface BodyClassProviderInterface
 *
 * @package Origamiez\Layout
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
