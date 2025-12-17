<?php
/**
 * Config Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class ConfigManager
 */
class ConfigManager {

	/**
	 * Config array.
	 *
	 * @var array
	 */
	private array $config = array();

	/**
	 * Instance.
	 *
	 * @var ?self
	 */
	private static ?self $instance = null;

	/**
	 * ConfigManager constructor.
	 */
	private function __construct() {
		$this->initialize_defaults();
	}

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize defaults.
	 */
	private function initialize_defaults(): void {
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

	/**
	 * Get config value.
	 *
	 * @param string $key Config key.
	 * @param mixed  $default_value Default value.
	 * @return mixed
	 */
	public function get( string $key, mixed $default_value = null ): mixed {
		$keys  = explode( '.', $key );
		$value = $this->config;

		foreach ( $keys as $k ) {
			if ( ! isset( $value[ $k ] ) ) {
				return $default_value;
			}
			$value = $value[ $k ];
		}

		return $value;
	}

	/**
	 * Set config value.
	 *
	 * @param string $key Config key.
	 * @param mixed  $value Config value.
	 */
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

	/**
	 * Check if config key exists.
	 *
	 * @param string $key Config key.
	 * @return bool
	 */
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

	/**
	 * Get all config.
	 *
	 * @return array
	 */
	public function get_all(): array {
		return $this->config;
	}

	/**
	 * Merge config.
	 *
	 * @param array $config Config to merge.
	 */
	public function merge( array $config ): void {
		$this->config = array_merge_recursive( $this->config, $config );
	}

	/**
	 * Get theme option.
	 *
	 * @param string $option Option name.
	 * @param mixed  $default_value Default value.
	 * @return mixed
	 */
	public function get_theme_option( string $option, mixed $default_value = null ): mixed {
		return get_theme_mod( $option, $default_value );
	}

	/**
	 * Set theme option.
	 *
	 * @param string $option Option name.
	 * @param mixed  $value Option value.
	 * @return bool
	 */
	public function set_theme_option( string $option, mixed $value ): bool {
		return set_theme_mod( $option, $value );
	}

	/**
	 * Get image sizes.
	 *
	 * @return array
	 */
	public function get_image_sizes(): array {
		return $this->get( 'image_sizes', array() );
	}

	/**
	 * Add image size.
	 *
	 * @param string $name Image size name.
	 * @param int    $width Image width.
	 * @param int    $height Image height.
	 * @param bool   $crop Crop image.
	 */
	public function add_image_size( string $name, int $width, int $height, bool $crop = false ): void {
		$sizes          = $this->get_image_sizes();
		$sizes[ $name ] = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);
		$this->set( 'image_sizes', $sizes );
	}

	/**
	 * Get menus.
	 *
	 * @return array
	 */
	public function get_menus(): array {
		return $this->get( 'menus', array() );
	}

	/**
	 * Get content width.
	 *
	 * @return int
	 */
	public function get_content_width(): int {
		return $this->get( 'theme.content_width', 817 );
	}

	/**
	 * Set content width.
	 *
	 * @param int $width Content width.
	 */
	public function set_content_width( int $width ): void {
		$this->set( 'theme.content_width', $width );
	}
}
