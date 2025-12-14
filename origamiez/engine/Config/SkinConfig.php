<?php

namespace Origamiez\Engine\Config;

class SkinConfig {

	private array $skins = [];
	private string $activeSkin = 'default';

	public function __construct() {
		$this->initializeSkins();
	}

	private function initializeSkins(): void {
		$this->skins = [
			'default' => [
				'name'        => 'Default',
				'colors'      => [
					'primary'   => '#333333',
					'secondary' => '#666666',
					'accent'    => '#0066cc',
				],
				'fonts'       => [],
			],
		];
	}

	public function registerSkin( string $id, array $config ): void {
		$this->skins[ $id ] = array_merge(
			[
				'name'   => $id,
				'colors' => [],
				'fonts'  => [],
			],
			$config
		);
	}

	public function getSkin( string $id ): ?array {
		return $this->skins[ $id ] ?? null;
	}

	public function getAllSkins(): array {
		return $this->skins;
	}

	public function getActiveSkin(): string {
		return $this->activeSkin;
	}

	public function setActiveSkin( string $id ): bool {
		if ( ! isset( $this->skins[ $id ] ) ) {
			return false;
		}
		$this->activeSkin = $id;
		return true;
	}

	public function getSkinColor( string $colorKey, string $skinId = null ): ?string {
		$skin = $this->getSkin( $skinId ?? $this->activeSkin );
		if ( $skin === null ) {
			return null;
		}
		return $skin['colors'][ $colorKey ] ?? null;
	}

	public function getSkinFont( string $fontKey, string $skinId = null ): ?array {
		$skin = $this->getSkin( $skinId ?? $this->activeSkin );
		if ( $skin === null ) {
			return null;
		}
		return $skin['fonts'][ $fontKey ] ?? null;
	}
}
