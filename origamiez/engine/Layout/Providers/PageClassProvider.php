<?php
/**
 * Page Class Provider
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

/**
 * Class PageClassProvider
 *
 * @package Origamiez\Engine\Layout\Providers
 */
class PageClassProvider implements BodyClassProviderInterface {

	/**
	 * Config manager.
	 *
	 * @var ConfigManager
	 */
	private ConfigManager $config_manager;
	/**
	 * Body class config.
	 *
	 * @var BodyClassConfig
	 */
	private BodyClassConfig $body_class_config;

	/**
	 * PageClassProvider constructor.
	 *
	 * @param ConfigManager   $config_manager The config manager.
	 * @param BodyClassConfig $body_class_config The body class config.
	 */
	public function __construct( ConfigManager $config_manager, BodyClassConfig $body_class_config ) {
		$this->config_manager    = $config_manager;
		$this->body_class_config = $body_class_config;
	}

	/**
	 * Provide.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function provide( array $classes ): array {
		if ( ! is_page() ) {
			return $classes;
		}

		$template = basename( get_page_template() );

		if ( in_array( $template, array( 'template-page-fullwidth-centered.php', 'template-page-fullwidth.php' ), true ) ) {
			$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
			$classes[] = $this->body_class_config::LAYOUT_SINGLE;
			$classes[] = $this->body_class_config::LAYOUT_FULL_WIDTH;
		} elseif ( 'template-page-magazine.php' === $template ) {
			$classes[] = $this->body_class_config::PAGE_MAGAZINE;
			$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
			$classes[] = $this->body_class_config::LAYOUT_SINGLE;
			$classes[] = $this->body_class_config::LAYOUT_FULL_WIDTH;

			$sidebar_right = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
			if ( ! is_active_sidebar( $sidebar_right ) ) {
				$classes[] = $this->body_class_config::MISSING_SIDEBAR_RIGHT;
			}
		} else {
			$classes[] = $this->body_class_config::LAYOUT_RIGHT_SIDEBAR;
			$classes[] = $this->body_class_config::LAYOUT_SINGLE;
			$classes[] = $this->body_class_config::LAYOUT_STATIC_PAGE;
		}

		return $classes;
	}
}
