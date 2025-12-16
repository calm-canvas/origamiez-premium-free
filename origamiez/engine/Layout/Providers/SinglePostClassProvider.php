<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class SinglePostClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;
	private BodyClassConfig $bodyClassConfig;

	public function __construct( ConfigManager $configManager, BodyClassConfig $bodyClassConfig ) {
		$this->configManager   = $configManager;
		$this->bodyClassConfig = $bodyClassConfig;
	}

	public function provide( array $classes ): array {
		if ( ! is_single() ) {
			return $classes;
		}

		$classes[] = $this->bodyClassConfig::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->bodyClassConfig::LAYOUT_SINGLE;

		if ( 1 === (int) get_theme_mod( 'is_show_border_for_images', 1 ) ) {
			$classes[] = $this->bodyClassConfig::SHOW_BORDER_FOR_IMAGES;
		}

		$singlePostLayout = get_theme_mod( 'single-post-layout', 'two-cols' );
		$classes[]        = $this->bodyClassConfig::SINGLE_POST_LAYOUT_PREFIX . $singlePostLayout;

		return $classes;
	}
}
