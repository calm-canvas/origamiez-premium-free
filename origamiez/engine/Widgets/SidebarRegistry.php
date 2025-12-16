<?php

namespace Origamiez\Engine\Widgets;

use Origamiez\Engine\Widgets\Sidebars\SidebarConfiguration;

class SidebarRegistry {

	private array $sidebars = [];

	public function registerSidebar( SidebarConfiguration $sidebarConfig ): self {
		$this->sidebars[ $sidebarConfig->getId() ] = $sidebarConfig;
		return $this;
	}

	public function registerDefaultSidebars(): self {
		add_action( 'init', [ $this, 'setupDefaultSidebars' ], 5 );
		return $this;
	}

	public function setupDefaultSidebars(): void {
		$defaults = [
			'main-top'           => SidebarConfiguration::create( 'main-top', esc_attr__( 'Main Top', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'main-center-top'    => SidebarConfiguration::create( 'main-center-top', esc_attr__( 'Main Center Top', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'main-center-left'   => SidebarConfiguration::create( 'main-center-left', esc_attr__( 'Main Center Left', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'main-center-right'  => SidebarConfiguration::create( 'main-center-right', esc_attr__( 'Main Center Right', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'main-center-bottom' => SidebarConfiguration::create( 'main-center-bottom', esc_attr__( 'Main Center Bottom', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'main-bottom'        => SidebarConfiguration::create( 'main-bottom', esc_attr__( 'Main Bottom', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'left'               => SidebarConfiguration::create( 'left', esc_attr__( 'Left', 'origamiez' ), esc_attr__( 'For only page with template: "Page Magazine".', 'origamiez' ) ),
			'right'              => SidebarConfiguration::create( 'right', esc_attr__( 'Right', 'origamiez' ), '' ),
			'bottom'             => SidebarConfiguration::create( 'bottom', esc_attr__( 'Bottom', 'origamiez' ), '' ),
			'footer-1'           => SidebarConfiguration::create( 'footer-1', esc_attr__( 'Footer 1', 'origamiez' ), '' ),
			'footer-2'           => SidebarConfiguration::create( 'footer-2', esc_attr__( 'Footer 2', 'origamiez' ), '' ),
			'footer-3'           => SidebarConfiguration::create( 'footer-3', esc_attr__( 'Footer 3', 'origamiez' ), '' ),
			'footer-4'           => SidebarConfiguration::create( 'footer-4', esc_attr__( 'Footer 4', 'origamiez' ), '' ),
			'footer-5'           => SidebarConfiguration::create( 'footer-5', esc_attr__( 'Footer 5', 'origamiez' ), '' ),
		];

		foreach ( $defaults as $sidebar ) {
			$this->registerSidebar( $sidebar );
		}
	}

	public function register(): void {
		add_action( 'init', [ $this, 'doRegisterSidebars' ], 30 );
		add_filter( 'dynamic_sidebar_params', [ $this, 'handleDynamicSidebarParams' ] );
	}

	public function doRegisterSidebars(): void {
		foreach ( $this->sidebars as $sidebar ) {
			register_sidebar( $sidebar->toArray() );
		}
	}

	public function handleDynamicSidebarParams( array $params ): array {
		global $wp_registered_widgets;
		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[ $widget_id ];
		$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
		$widget_num = $widget_obj['params'][0]['number'];
		if ( ! isset( $widget_opt[ $widget_num ]['title'] ) || ( isset( $widget_opt[ $widget_num ]['title'] ) && empty( $widget_opt[ $widget_num ]['title'] ) ) ) {
			$params[0]['before_widget'] .= '<div class="origamiez-widget-content clearfix">';
			$params[0]['before_title']  = '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">';
			$params[0]['after_title']   = '</span></h2>';
		}

		return $params;
	}

	public function getSidebarById( string $id ): ?SidebarConfiguration {
		return $this->sidebars[ $id ] ?? null;
	}

	public function getSidebars(): array {
		return $this->sidebars;
	}

	public static function getInstance(): self {
		static $instance = null;
		if ( $instance === null ) {
			$instance = new self();
		}
		return $instance;
	}
}
