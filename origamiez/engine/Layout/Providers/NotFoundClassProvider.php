<?php
/**
 * Not Found Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

/**
 * Class NotFoundClassProvider
 *
 * Provides body classes for 404 Not Found pages.
 * Extends AbstractBodyClassProvider to eliminate duplicate constructor code.
 *
 * @package Origamiez\Engine\Layout\Providers
 */
class NotFoundClassProvider extends AbstractBodyClassProvider {

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array {
		if ( ! is_404() ) {
			return $classes;
		}

		$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->body_class_config::LAYOUT_SINGLE;
		$classes[] = $this->body_class_config::LAYOUT_FULL_WIDTH;

		return $classes;
	}
}
