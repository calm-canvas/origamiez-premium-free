<?php

namespace Origamiez\Engine\Layout;

class WidgetWrapperManager {

	private array $customWrappers = array();

	public function __construct() {
		$this->initializeDefaultWrappers();
	}

	private function initializeDefaultWrappers(): void {
		$this->customWrappers = array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		);
	}

	public function getDynamicSidebarParams( array $params ): array {
		global $wp_registered_widgets;

		$widgetId  = $params[0]['widget_id'] ?? null;
		$widgetObj = $wp_registered_widgets[ $widgetId ] ?? null;

		if ( null === $widgetObj || ! isset( $widgetObj['callback'][0] ) ) {
			return $params;
		}

		$widgetOpt = get_option( $widgetObj['callback'][0]->option_name );
		$widgetNum = $widgetObj['params'][0]['number'] ?? null;

		if ( null === $widgetNum ) {
			return $params;
		}

		if ( ! isset( $widgetOpt[ $widgetNum ]['title'] ) ||
			( isset( $widgetOpt[ $widgetNum ]['title'] ) && empty( $widgetOpt[ $widgetNum ]['title'] ) ) ) {

			$params[0]['before_widget'] .= '<div class="origamiez-widget-content clearfix">';
			$params[0]['before_title']   = '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">';
			$params[0]['after_title']    = '</span></h2>';
		}

		return apply_filters( 'origamiez_dynamic_sidebar_params', $params );
	}

	public function setCustomWrapper( string $key, string $html ): self {
		$validKeys = array( 'before_widget', 'after_widget', 'before_title', 'after_title' );

		if ( in_array( $key, $validKeys, true ) ) {
			$this->customWrappers[ $key ] = $html;
		}

		return $this;
	}

	public function getCustomWrapper( string $key ): ?string {
		return $this->customWrappers[ $key ] ?? null;
	}

	public function getAllCustomWrappers(): array {
		return $this->customWrappers;
	}

	public function resetWrappers(): self {
		$this->initializeDefaultWrappers();

		return $this;
	}

	public function register(): void {
		add_filter( 'dynamic_sidebar_params', array( $this, 'getDynamicSidebarParams' ) );
	}
}
