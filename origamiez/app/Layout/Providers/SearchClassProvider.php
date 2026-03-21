<?php
/**
 * Search Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Layout\Providers;

/**
 * Class SearchClassProvider
 *
 * Provides body classes for search result pages.
 * Extends AbstractBodyClassProvider to eliminate duplicate constructor code.
 *
 * @package Origamiez\Layout\Providers
 */
class SearchClassProvider extends AbstractBodyClassProvider {

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array {
		if ( ! is_search() ) {
			return $classes;
		}

		$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->body_class_config::LAYOUT_BLOG;

		return $classes;
	}
}
