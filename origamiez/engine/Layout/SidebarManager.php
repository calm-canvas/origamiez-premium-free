<?php
/**
 * Sidebar Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout;

/**
 * Class SidebarManager
 *
 * @package Origamiez\Engine\Layout
 */
class SidebarManager {

	/**
	 * Sidebars.
	 *
	 * @var array
	 */
	private array $sidebars = array();

	/**
	 * SidebarManager constructor.
	 */
	public function __construct() {
		$this->initialize_default_sidebars();
	}

	/**
	 * Initialize default sidebars.
	 *
	 * @return void
	 */
	private function initialize_default_sidebars(): void {
		$this->sidebars = array(
			'sidebar-main-top'           => __( 'Main Top', 'origamiez' ),
			'sidebar-main-bottom'        => __( 'Main Bottom', 'origamiez' ),
			'sidebar-main-center-top'    => __( 'Main Center Top', 'origamiez' ),
			'sidebar-main-center-left'   => __( 'Main Center Left', 'origamiez' ),
			'sidebar-main-center-right'  => __( 'Main Center Right', 'origamiez' ),
			'sidebar-main-center-bottom' => __( 'Main Center Bottom', 'origamiez' ),
			'sidebar-left'               => __( 'Primary Sidebar (Left)', 'origamiez' ),
			'sidebar-right'              => __( 'Primary Sidebar (Right)', 'origamiez' ),
			'sidebar-middle'             => __( 'Middle Sidebar', 'origamiez' ),
			'sidebar-middle-clone'       => __( 'Middle Sidebar Clone', 'origamiez' ),
			'sidebar-bottom'             => __( 'Bottom Sidebar', 'origamiez' ),
			'footer-1'                   => __( 'Footer 1', 'origamiez' ),
			'footer-2'                   => __( 'Footer 2', 'origamiez' ),
			'footer-3'                   => __( 'Footer 3', 'origamiez' ),
			'footer-4'                   => __( 'Footer 4', 'origamiez' ),
			'footer-5'                   => __( 'Footer 5', 'origamiez' ),
		);
	}

	/**
	 * Register sidebar.
	 *
	 * @param string $id The id.
	 * @param string $name The name.
	 * @param array  $args The args.
	 *
	 * @return self
	 */
	public function register_sidebar( string $id, string $name, array $args = array() ): self {
		$default_args = array(
			'name'          => $name,
			'id'            => $id,
			'description'   => '',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		);

		$args = array_merge( $default_args, $args );
		register_sidebar( $args );
		$this->sidebars[ $id ] = $name;

		return $this;
	}

	/**
	 * Get sidebar.
	 *
	 * @param string $id The id.
	 *
	 * @return string|null
	 */
	public function get_sidebar( string $id ): ?string {
		return $this->sidebars[ $id ] ?? null;
	}

	/**
	 * Get all sidebars.
	 *
	 * @return array
	 */
	public function get_all_sidebars(): array {
		return $this->sidebars;
	}

	/**
	 * Is sidebar active.
	 *
	 * @param string $id The id.
	 *
	 * @return boolean
	 */
	public function is_sidebar_active( string $id ): bool {
		return is_active_sidebar( $id );
	}

	/**
	 * Display sidebar.
	 *
	 * @param string $id The id.
	 *
	 * @return void
	 */
	public function display_sidebar( string $id ): void {
		if ( $this->is_sidebar_active( $id ) ) {
			dynamic_sidebar( $id );
		}
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'widgets_init', array( $this, 'register_all_sidebars' ) );
	}

	/**
	 * Register all sidebars.
	 *
	 * @return void
	 */
	public function register_all_sidebars(): void {
		foreach ( $this->sidebars as $id => $name ) {
			$this->register_sidebar( $id, $name );
		}
	}
}
