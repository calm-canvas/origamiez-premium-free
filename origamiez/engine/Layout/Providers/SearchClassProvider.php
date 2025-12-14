<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class SearchClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager = $configManager;
	}

	public function provide( array $classes ): array {
		if ( ! is_search() ) {
			return $classes;
		}

		$classes[] = 'origamiez-layout-right-sidebar';
		$classes[] = 'origamiez-layout-blog';

		return $classes;
	}
}
