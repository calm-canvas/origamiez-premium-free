<?php

namespace Origamiez\Engine\Config;

class LayoutConfig {

	private array $layouts = [];
	private string $defaultLayout = 'default';

	public function __construct() {
		$this->initializeLayouts();
	}

	private function initializeLayouts(): void {
		$this->layouts = [
			'default'               => [
				'name'        => 'Default Layout',
				'sidebar'     => 'right',
				'columns'     => 2,
			],
			'fullwidth'             => [
				'name'        => 'Full Width',
				'sidebar'     => 'none',
				'columns'     => 1,
			],
			'fullwidth-centered'    => [
				'name'        => 'Full Width Centered',
				'sidebar'     => 'none',
				'columns'     => 1,
				'centered'    => true,
			],
			'magazine'              => [
				'name'        => 'Magazine',
				'sidebar'     => 'right',
				'columns'     => 2,
				'feature'     => 'magazine',
			],
			'three-cols'            => [
				'name'        => 'Three Columns',
				'sidebar'     => 'both',
				'columns'     => 3,
			],
			'three-cols-slm'        => [
				'name'        => 'Three Columns - Small Left/Middle',
				'sidebar'     => 'both',
				'columns'     => 3,
				'slim'        => true,
			],
		];
	}

	public function registerLayout( string $id, array $config ): void {
		$this->layouts[ $id ] = array_merge(
			[
				'name'    => $id,
				'sidebar' => 'right',
				'columns' => 2,
			],
			$config
		);
	}

	public function getLayout( string $id ): ?array {
		return $this->layouts[ $id ] ?? null;
	}

	public function getAllLayouts(): array {
		return $this->layouts;
	}

	public function getDefaultLayout(): string {
		return $this->defaultLayout;
	}

	public function setDefaultLayout( string $id ): bool {
		if ( ! isset( $this->layouts[ $id ] ) ) {
			return false;
		}
		$this->defaultLayout = $id;
		return true;
	}

	public function getLayoutSidebar( string $layoutId ): string {
		$layout = $this->getLayout( $layoutId );
		return $layout['sidebar'] ?? 'right';
	}

	public function getLayoutColumns( string $layoutId ): int {
		$layout = $this->getLayout( $layoutId );
		return $layout['columns'] ?? 2;
	}

	public function isFullwidth( string $layoutId ): bool {
		$layout = $this->getLayout( $layoutId );
		return isset( $layout['sidebar'] ) && $layout['sidebar'] === 'none';
	}
}
