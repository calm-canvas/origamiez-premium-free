<?php

namespace Origamiez\Engine\Layout;

class SidebarManager {

	private array $sidebars = [];

	public function __construct() {
		$this->initializeDefaultSidebars();
	}

	private function initializeDefaultSidebars(): void {
		$this->sidebars = [
			'sidebar-main-top'              => __( 'Main Top', 'origamiez' ),
			'sidebar-main-bottom'           => __( 'Main Bottom', 'origamiez' ),
			'sidebar-main-center-top'       => __( 'Main Center Top', 'origamiez' ),
			'sidebar-main-center-left'      => __( 'Main Center Left', 'origamiez' ),
			'sidebar-main-center-right'     => __( 'Main Center Right', 'origamiez' ),
			'sidebar-main-center-bottom'    => __( 'Main Center Bottom', 'origamiez' ),
			'sidebar-left'                  => __( 'Primary Sidebar (Left)', 'origamiez' ),
			'sidebar-right'                 => __( 'Primary Sidebar (Right)', 'origamiez' ),
			'sidebar-middle'                => __( 'Middle Sidebar', 'origamiez' ),
			'sidebar-middle-clone'          => __( 'Middle Sidebar Clone', 'origamiez' ),
			'sidebar-bottom'                => __( 'Bottom Sidebar', 'origamiez' ),
			'footer-1'                      => __( 'Footer 1', 'origamiez' ),
			'footer-2'                      => __( 'Footer 2', 'origamiez' ),
			'footer-3'                      => __( 'Footer 3', 'origamiez' ),
			'footer-4'                      => __( 'Footer 4', 'origamiez' ),
			'footer-5'                      => __( 'Footer 5', 'origamiez' ),
		];
	}

	public function registerSidebar( string $id, string $name, array $args = [] ): self {
		$defaultArgs = [
			'name'          => $name,
			'id'            => $id,
			'description'   => '',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		];

		$args = array_merge( $defaultArgs, $args );
		register_sidebar( $args );
		$this->sidebars[ $id ] = $name;

		return $this;
	}

	public function getSidebar( string $id ): ?string {
		return $this->sidebars[ $id ] ?? null;
	}

	public function getAllSidebars(): array {
		return $this->sidebars;
	}

	public function isSidebarActive( string $id ): bool {
		return is_active_sidebar( $id );
	}

	public function displaySidebar( string $id ): void {
		if ( $this->isSidebarActive( $id ) ) {
			dynamic_sidebar( $id );
		}
	}

	public function register(): void {
		add_action( 'widgets_init', [ $this, 'registerAllSidebars' ] );
	}

	public function registerAllSidebars(): void {
		foreach ( $this->sidebars as $id => $name ) {
			$this->registerSidebar( $id, $name );
		}
	}
}
