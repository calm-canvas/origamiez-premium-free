<?php
/**
 * Shared Customizer section registration for the Origamiez General panel.
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Class CustomizerPanelHelper
 */
class CustomizerPanelHelper {

	/**
	 * Register a section under panel `origamiez_general`.
	 *
	 * @param CustomizerService $service The customizer service.
	 * @param string            $id      Section ID.
	 * @param string            $title   Translated section title.
	 */
	public static function register_section_under_general( CustomizerService $service, string $id, string $title ): void {
		$service->register_section(
			$id,
			array(
				'panel' => 'origamiez_general',
				'title' => $title,
			)
		);
	}
}
