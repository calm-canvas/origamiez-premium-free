<?php
/**
 * Sidebar Visibility Modifier
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout;

/**
 * Class SidebarVisibilityModifier
 *
 * @package Origamiez\Engine\Layout
 */
class SidebarVisibilityModifier {

	/**
	 * Sidebar manager.
	 *
	 * @var SidebarManager
	 */
	private SidebarManager $sidebar_manager;

	/**
	 * SidebarVisibilityModifier constructor.
	 *
	 * @param SidebarManager|null $sidebar_manager The sidebar manager.
	 */
	public function __construct( SidebarManager $sidebar_manager = null ) {
		$this->sidebar_manager = $sidebar_manager ?? new SidebarManager();
	}

	/**
	 * Is sidebar active.
	 *
	 * @param string $sidebar_id The sidebar id.
	 *
	 * @return boolean
	 */
	public function is_sidebar_active( string $sidebar_id ): bool {
		return is_active_sidebar( $sidebar_id );
	}

	/**
	 * Add missing sidebar class.
	 *
	 * @param string $sidebar_id The sidebar id.
	 * @param string $class_name The class name.
	 *
	 * @return boolean
	 */
	public function add_missing_sidebar_class( string $sidebar_id, string $class_name ): bool {
		return ! $this->is_sidebar_active( $sidebar_id );
	}

	/**
	 * Modify body classes for missing sidebars.
	 *
	 * @param array $classes The classes.
	 *
	 * @return array
	 */
	public function modify_body_classes_for_missing_sidebars( array $classes ): array {
		$sidebar_to_class = array(
			'sidebar-right' => 'origamiez-missing-sidebar-right',
			'sidebar-left'  => 'origamiez-missing-sidebar-left',
		);

		foreach ( $sidebar_to_class as $sidebar_id => $class_name ) {
			if ( ! $this->is_sidebar_active( $sidebar_id ) ) {
				if ( ! in_array( $class_name, $classes, true ) ) {
					$classes[] = $class_name;
				}
			}
		}

		return $classes;
	}

	/**
	 * Should display sidebar.
	 *
	 * @param string $sidebar_id The sidebar id.
	 *
	 * @return boolean
	 */
	public function should_display_sidebar( string $sidebar_id ): bool {
		return $this->is_sidebar_active( $sidebar_id );
	}

	/**
	 * Display sidebar if active.
	 *
	 * @param string $sidebar_id The sidebar id.
	 *
	 * @return boolean
	 */
	public function display_sidebar_if_active( string $sidebar_id ): bool {
		if ( $this->should_display_sidebar( $sidebar_id ) ) {
			dynamic_sidebar( $sidebar_id );
			return true;
		}

		return false;
	}

	/**
	 * Get active sidebars.
	 *
	 * @param array $sidebar_ids The sidebar ids.
	 *
	 * @return array
	 */
	public function get_active_sidebars( array $sidebar_ids ): array {
		$active_sidebars = array();

		foreach ( $sidebar_ids as $sidebar_id ) {
			if ( $this->is_sidebar_active( $sidebar_id ) ) {
				$active_sidebars[] = $sidebar_id;
			}
		}

		return $active_sidebars;
	}

	/**
	 * Get inactive sidebars.
	 *
	 * @param array $sidebar_ids The sidebar ids.
	 *
	 * @return array
	 */
	public function get_inactive_sidebars( array $sidebar_ids ): array {
		$inactive_sidebars = array();

		foreach ( $sidebar_ids as $sidebar_id ) {
			if ( ! $this->is_sidebar_active( $sidebar_id ) ) {
				$inactive_sidebars[] = $sidebar_id;
			}
		}

		return $inactive_sidebars;
	}

	/**
	 * Has any sidebar active.
	 *
	 * @param array $sidebar_ids The sidebar ids.
	 *
	 * @return boolean
	 */
	public function has_any_sidebar_active( array $sidebar_ids ): bool {
		foreach ( $sidebar_ids as $sidebar_id ) {
			if ( $this->is_sidebar_active( $sidebar_id ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Has all sidebars active.
	 *
	 * @param array $sidebar_ids The sidebar ids.
	 *
	 * @return boolean
	 */
	public function has_all_sidebars_active( array $sidebar_ids ): bool {
		foreach ( $sidebar_ids as $sidebar_id ) {
			if ( ! $this->is_sidebar_active( $sidebar_id ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Get active sidebar count.
	 *
	 * @param array $sidebar_ids The sidebar ids.
	 *
	 * @return integer
	 */
	public function get_active_sidebar_count( array $sidebar_ids ): int {
		return count( $this->get_active_sidebars( $sidebar_ids ) );
	}
}
