<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class PageClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;
	private BodyClassConfig $bodyClassConfig;

	public function __construct( ConfigManager $configManager, BodyClassConfig $bodyClassConfig ) {
		$this->configManager   = $configManager;
		$this->bodyClassConfig = $bodyClassConfig;
	}

	public function provide( array $classes ): array {
		if ( ! is_page() ) {
			return $classes;
		}

		$template = basename( get_page_template() );

		if ( in_array( $template, array( 'template-page-fullwidth-centered.php', 'template-page-fullwidth.php' ), true ) ) {
			$classes[] = $this->bodyClassConfig::LAYOUT_RIGHT_SIDEBAR;
			$classes[] = $this->bodyClassConfig::LAYOUT_SINGLE;
			$classes[] = $this->bodyClassConfig::LAYOUT_FULL_WIDTH;
		} elseif ( 'template-page-magazine.php' === $template ) {
			$classes[] = $this->bodyClassConfig::PAGE_MAGAZINE;
			$classes[] = $this->bodyClassConfig::LAYOUT_RIGHT_SIDEBAR;
			$classes[] = $this->bodyClassConfig::LAYOUT_SINGLE;
			$classes[] = $this->bodyClassConfig::LAYOUT_FULL_WIDTH;

			$sidebarRight = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
			if ( ! is_active_sidebar( $sidebarRight ) ) {
				$classes[] = $this->bodyClassConfig::MISSING_SIDEBAR_RIGHT;
			}
		} else {
			$classes[] = $this->bodyClassConfig::LAYOUT_RIGHT_SIDEBAR;
			$classes[] = $this->bodyClassConfig::LAYOUT_SINGLE;
			$classes[] = $this->bodyClassConfig::LAYOUT_STATIC_PAGE;
		}

		return $classes;
	}
}
