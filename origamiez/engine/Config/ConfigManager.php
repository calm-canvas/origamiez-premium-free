<?php

namespace Origamiez\Engine\Config;

class ConfigManager {

	private array $config          = array();
	private static ?self $instance = null;

	private function __construct() {
		$this->initializeDefaults();
	}

	public static function getInstance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function initializeDefaults(): void {
		$this->config = array(
			'theme'         => array(
				'name'          => 'Origamiez',
				'prefix'        => 'origamiez_',
				'content_width' => 817,
			),
			'image_sizes'   => array(),
			'menus'         => array(
				'main-nav'   => 'Main Menu',
				'top-nav'    => 'Top Menu (do not support sub-menu)',
				'footer-nav' => 'Footer Menu (do not support sub-menu)',
				'mobile-nav' => 'Mobile Menu (will be replace by Main Menu - if null).',
			),
			'features'      => array(
				'wp-block-styles'      => true,
				'responsive-embeds'    => true,
				'align-wide'           => true,
				'title-tag'            => true,
				'post-thumbnails'      => true,
				'loop-pagination'      => true,
				'automatic-feed-links' => true,
				'editor_style'         => true,
			),
			'post_formats'  => array( 'gallery', 'video', 'audio' ),
			'html5_support' => array(
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
			),
		);
	}

	public function get( string $key, mixed $default = null ): mixed {
		$keys  = explode( '.', $key );
		$value = $this->config;

		foreach ( $keys as $k ) {
			if ( ! isset( $value[ $k ] ) ) {
				return $default;
			}
			$value = $value[ $k ];
		}

		return $value;
	}

	public function set( string $key, mixed $value ): void {
		$keys   = explode( '.', $key );
		$target = &$this->config;

		foreach ( $keys as $k ) {
			if ( ! isset( $target[ $k ] ) ) {
				$target[ $k ] = array();
			}
			$target = &$target[ $k ];
		}

		$target = $value;
	}

	public function has( string $key ): bool {
		$keys  = explode( '.', $key );
		$value = $this->config;

		foreach ( $keys as $k ) {
			if ( ! isset( $value[ $k ] ) ) {
				return false;
			}
			$value = $value[ $k ];
		}

		return true;
	}

	public function getAll(): array {
		return $this->config;
	}

	public function merge( array $config ): void {
		$this->config = array_merge_recursive( $this->config, $config );
	}

	public function getThemeOption( string $option, mixed $default = null ): mixed {
		return get_theme_mod( $option, $default );
	}

	public function setThemeOption( string $option, mixed $value ): bool {
		return set_theme_mod( $option, $value );
	}

	public function getImageSizes(): array {
		return $this->get( 'image_sizes', array() );
	}

	public function addImageSize( string $name, int $width, int $height, bool $crop = false ): void {
		$sizes          = $this->getImageSizes();
		$sizes[ $name ] = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);
		$this->set( 'image_sizes', $sizes );
	}

	public function getMenus(): array {
		return $this->get( 'menus', array() );
	}

	public function getContentWidth(): int {
		return $this->get( 'theme.content_width', 817 );
	}

	public function setContentWidth( int $width ): void {
		$this->set( 'theme.content_width', $width );
	}
}
