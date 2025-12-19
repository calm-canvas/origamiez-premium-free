<?php
/**
 * Social Config
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Config;

/**
 * Class SocialConfig
 */
class SocialConfig {

	/**
	 * Social networks data.
	 *
	 * @var array
	 */
	private static array $socials = ORIGAMIEZ_CONFIG['socials'];

	/**
	 * Get all social networks.
	 *
	 * @return array
	 */
	public static function get_socials(): array {
		$socials = self::$socials;
		foreach ( $socials as $key => &$data ) {
			$data['label'] = esc_attr( $data['label'] );
		}
		return apply_filters( 'origamiez_social_networks', $socials );
	}

	/**
	 * Get a specific social network.
	 *
	 * @param string $key Social network key.
	 * @return array|null
	 */
	public static function get_social( string $key ): ?array {
		$socials = self::get_socials();
		return $socials[ $key ] ?? null;
	}

	/**
	 * Get social icon.
	 *
	 * @param string $key Social network key.
	 * @return string
	 */
	public static function get_social_icon( string $key ): string {
		$social = self::get_social( $key );
		return $social['icon'] ?? '';
	}

	/**
	 * Get social label.
	 *
	 * @param string $key Social network key.
	 * @return string
	 */
	public static function get_social_label( string $key ): string {
		$social = self::get_social( $key );
		return $social['label'] ?? '';
	}

	/**
	 * Get social color.
	 *
	 * @param string $key Social network key.
	 * @return string
	 */
	public static function get_social_color( string $key ): string {
		$social = self::get_social( $key );
		return $social['color'] ?? '';
	}
}
