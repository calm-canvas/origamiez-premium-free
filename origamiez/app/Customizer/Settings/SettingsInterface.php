<?php
/**
 * Settings Interface for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

use Origamiez\Customizer\CustomizerService;

/**
 * Interface SettingsInterface
 */
interface SettingsInterface {
	/**
	 * Register settings.
	 *
	 * @param CustomizerService $service The customizer service.
	 */
	public function register( CustomizerService $service ): void;
}
