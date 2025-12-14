<?php

namespace Origamiez\Engine\Layout\Providers;

use Origamiez\Engine\Config\ConfigManager;
use Origamiez\Engine\Layout\BodyClassProviderInterface;

class PageClassProvider implements BodyClassProviderInterface {

	private ConfigManager $configManager;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager = $configManager;
	}

	public function provide( array $classes ): array {
		if ( ! is_page() ) {
			return $classes;
		}

		$template = basename( get_page_template() );

		if ( in_array( $template, [ 'template-page-fullwidth-centered.php', 'template-page-fullwidth.php' ], true ) ) {
			$classes[] = 'origamiez-layout-right-sidebar';
			$classes[] = 'origamiez-layout-single';
			$classes[] = 'origamiez-layout-full-width';
		} elseif ( 'template-page-magazine.php' === $template ) {
			$classes[] = 'origamiez-page-magazine';
			$classes[] = 'origamiez-layout-right-sidebar';
			$classes[] = 'origamiez-layout-single';
			$classes[] = 'origamiez-layout-full-width';

			$sidebarRight = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
			if ( ! is_active_sidebar( $sidebarRight ) ) {
				$classes[] = 'origamiez-missing-sidebar-right';
			}
		} else {
			$classes[] = 'origamiez-layout-right-sidebar';
			$classes[] = 'origamiez-layout-single';
			$classes[] = 'origamiez-layout-static-page';
		}

		return $classes;
	}
}
