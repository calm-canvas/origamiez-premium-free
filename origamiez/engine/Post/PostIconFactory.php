<?php
/**
 * Post Icon Factory
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Post;

/**
 * Class PostIconFactory
 *
 * @package Origamiez\Engine\Post
 */
class PostIconFactory {

	/**
	 * Icons
	 *
	 * @var array
	 */
	private array $icons = array();

	/**
	 * Post_Icon_Factory constructor.
	 */
	public function __construct() {
		$this->initialize_default_icons();
	}

	/**
	 * Initialize default icons.
	 *
	 * @return void
	 */
	private function initialize_default_icons(): void {
		$this->icons = array(
			'video'    => 'fa fa-play',
			'audio'    => 'fa fa-headphones',
			'image'    => 'fa fa-camera',
			'gallery'  => 'fa fa-picture-o',
			'standard' => 'fa fa-pencil',
		);
	}

	/**
	 * Get icon.
	 *
	 * @param string $format The format.
	 *
	 * @return string
	 */
	public function get_icon( string $format ): string {
		$format = sanitize_key( $format );

		if ( empty( $format ) ) {
			$format = 'standard';
		}

		$icon = $this->icons[ $format ] ?? $this->icons['standard'];

		return apply_filters( 'origamiez_get_format_icon', $icon, $format );
	}

	/**
	 * Register icon.
	 *
	 * @param string $format The format.
	 * @param string $icon_class The icon class.
	 *
	 * @return self
	 */
	public function register_icon( string $format, string $icon_class ): self {
		$this->icons[ sanitize_key( $format ) ] = sanitize_text_field( $icon_class );

		return $this;
	}

	/**
	 * Has icon.
	 *
	 * @param string $format The format.
	 *
	 * @return boolean
	 */
	public function has_icon( string $format ): bool {
		return isset( $this->icons[ sanitize_key( $format ) ] );
	}

	/**
	 * Get all icons.
	 *
	 * @return array
	 */
	public function get_all_icons(): array {
		return $this->icons;
	}

	/**
	 * Get icons by format.
	 *
	 * @param array $formats The formats.
	 *
	 * @return array
	 */
	public function get_icons_by_format( array $formats ): array {
		$result = array();

		foreach ( $formats as $format ) {
			$format = sanitize_key( $format );
			if ( ! empty( $format ) ) {
				$result[ $format ] = $this->get_icon( $format );
			}
		}

		return $result;
	}
}
