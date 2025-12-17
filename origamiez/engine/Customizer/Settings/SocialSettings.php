<?php
/**
 * Social Settings for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

/**
 * Class SocialSettings
 */
class SocialSettings implements SettingsInterface {

	/**
	 * Register social settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void {
		$service->register_panel(
			'origamiez_social_links',
			array(
				'title' => esc_attr__( 'Social links', 'origamiez' ),
			)
		);

		$social_objects = origamiez_get_socials();
		foreach ( $social_objects as $social_slug => $social ) {
			$service->register_section(
				"social_{$social_slug}",
				array(
					'panel' => 'origamiez_social_links',
					'title' => esc_attr( $social['label'] ),
				)
			);

			$service->register_setting(
				"{$social_slug}_url",
				array(
					'label'       => esc_attr__( 'URL', 'origamiez' ),
					'description' => '',
					'default'     => '',
					'type'        => 'text',
					'section'     => "social_{$social_slug}",
					'transport'   => 'refresh',
				)
			);

			$service->register_setting(
				"{$social_slug}_color",
				array(
					'label'       => esc_attr__( 'Color', 'origamiez' ),
					'description' => '',
					'default'     => esc_attr( $social['color'] ),
					'type'        => 'color',
					'section'     => "social_{$social_slug}",
					'transport'   => 'refresh',
				)
			);
		}
	}
}
