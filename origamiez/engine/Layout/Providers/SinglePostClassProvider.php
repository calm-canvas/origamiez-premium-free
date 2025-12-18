<?php
/**
 * Single Post Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

/**
 * Class SinglePostClassProvider
 *
 * Provides body classes for single post pages.
 * Extends AbstractBodyClassProvider to eliminate duplicate constructor code.
 *
 * @package Origamiez\Engine\Layout\Providers
 */
class SinglePostClassProvider extends AbstractBodyClassProvider {

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array {
		if ( ! is_single() ) {
			return $classes;
		}

		$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->body_class_config::LAYOUT_SINGLE;

		if ( 1 === (int) get_theme_mod( 'is_show_border_for_images', 1 ) ) {
			$classes[] = $this->body_class_config::SHOW_BORDER_FOR_IMAGES;
		}

		$single_post_layout = get_theme_mod( 'single-post-layout', 'two-cols' );
		$classes[]          = $this->body_class_config::SINGLE_POST_LAYOUT_PREFIX . $single_post_layout;

		return $classes;
	}
}
