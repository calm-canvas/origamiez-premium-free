<?php

namespace Origamiez\Engine\Post;

class PostIconFactory {

	private array $icons = [];

	public function __construct() {
		$this->initializeDefaultIcons();
	}

	private function initializeDefaultIcons(): void {
		$this->icons = [
			'video'    => 'fa fa-play',
			'audio'    => 'fa fa-headphones',
			'image'    => 'fa fa-camera',
			'gallery'  => 'fa fa-picture-o',
			'standard' => 'fa fa-pencil',
		];
	}

	public function getIcon( string $format ): string {
		$format = sanitize_key( $format );

		if ( empty( $format ) ) {
			$format = 'standard';
		}

		$icon = $this->icons[ $format ] ?? $this->icons['standard'];

		return apply_filters( 'origamiez_get_format_icon', $icon, $format );
	}

	public function registerIcon( string $format, string $iconClass ): self {
		$this->icons[ sanitize_key( $format ) ] = sanitize_text_field( $iconClass );

		return $this;
	}

	public function hasIcon( string $format ): bool {
		return isset( $this->icons[ sanitize_key( $format ) ] );
	}

	public function getAllIcons(): array {
		return $this->icons;
	}

	public function getIconsByFormat( array $formats ): array {
		$result = [];

		foreach ( $formats as $format ) {
			$format = sanitize_key( $format );
			if ( ! empty( $format ) ) {
				$result[ $format ] = $this->getIcon( $format );
			}
		}

		return $result;
	}
}
