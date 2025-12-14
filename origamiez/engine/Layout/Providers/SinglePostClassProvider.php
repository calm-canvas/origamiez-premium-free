<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class SinglePostClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager = $configManager;
	}

	public function provide( array $classes ): array {
		if ( ! is_single() ) {
			return $classes;
		}

		$classes[] = 'origamiez-layout-right-sidebar';
		$classes[] = 'origamiez-layout-single';

		if ( 1 === (int) get_theme_mod( 'is_show_border_for_images', 1 ) ) {
			$classes[] = 'origamiez-show-border-for-images';
		}

		$singlePostLayout = get_theme_mod( 'single-post-layout', 'two-cols' );
		$classes[] = "origamiez-single-post-{$singlePostLayout}";

		return $classes;
	}
}
