<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\BodyClassConfig;
use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class NotFoundClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;
	private BodyClassConfig $bodyClassConfig;

	public function __construct( ConfigManager $configManager, BodyClassConfig $bodyClassConfig ) {
		$this->configManager = $configManager;
		$this->bodyClassConfig = $bodyClassConfig;
	}

	public function provide( array $classes ): array {
		if ( ! is_404() ) {
			return $classes;
		}

		$classes[] = $this->bodyClassConfig::LAYOUT_RIGHT_SIDEBAR;
		$classes[] = $this->bodyClassConfig::LAYOUT_SINGLE;
		$classes[] = $this->bodyClassConfig::LAYOUT_FULL_WIDTH;

		return $classes;
	}
}
