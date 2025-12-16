<?php

namespace Origamiez\Engine\Layout;

class SidebarVisibilityModifier {

	private SidebarManager $sidebarManager;

	public function __construct( SidebarManager $sidebarManager = null ) {
		$this->sidebarManager = $sidebarManager ?? new SidebarManager();
	}

	public function isSidebarActive( string $sidebarId ): bool {
		return is_active_sidebar( $sidebarId );
	}

	public function addMissingSidebarClass( string $sidebarId, string $className ): bool {
		return ! $this->isSidebarActive( $sidebarId );
	}

	public function modifyBodyClassesForMissingSidebars( array $classes ): array {
		$sidebarToClass = array(
			'sidebar-right' => 'origamiez-missing-sidebar-right',
			'sidebar-left'  => 'origamiez-missing-sidebar-left',
		);

		foreach ( $sidebarToClass as $sidebarId => $className ) {
			if ( ! $this->isSidebarActive( $sidebarId ) ) {
				if ( ! in_array( $className, $classes, true ) ) {
					$classes[] = $className;
				}
			}
		}

		return $classes;
	}

	public function shouldDisplaySidebar( string $sidebarId ): bool {
		return $this->isSidebarActive( $sidebarId );
	}

	public function displaySidebarIfActive( string $sidebarId ): bool {
		if ( $this->shouldDisplaySidebar( $sidebarId ) ) {
			dynamic_sidebar( $sidebarId );
			return true;
		}

		return false;
	}

	public function getActiveSidebars( array $sidebarIds ): array {
		$activeSidebars = array();

		foreach ( $sidebarIds as $sidebarId ) {
			if ( $this->isSidebarActive( $sidebarId ) ) {
				$activeSidebars[] = $sidebarId;
			}
		}

		return $activeSidebars;
	}

	public function getInactiveSidebars( array $sidebarIds ): array {
		$inactiveSidebars = array();

		foreach ( $sidebarIds as $sidebarId ) {
			if ( ! $this->isSidebarActive( $sidebarId ) ) {
				$inactiveSidebars[] = $sidebarId;
			}
		}

		return $inactiveSidebars;
	}

	public function hasAnySidebarActive( array $sidebarIds ): bool {
		foreach ( $sidebarIds as $sidebarId ) {
			if ( $this->isSidebarActive( $sidebarId ) ) {
				return true;
			}
		}

		return false;
	}

	public function hasAllSidebarsActive( array $sidebarIds ): bool {
		foreach ( $sidebarIds as $sidebarId ) {
			if ( ! $this->isSidebarActive( $sidebarId ) ) {
				return false;
			}
		}

		return true;
	}

	public function getActiveSidebarCount( array $sidebarIds ): int {
		return count( $this->getActiveSidebars( $sidebarIds ) );
	}
}
