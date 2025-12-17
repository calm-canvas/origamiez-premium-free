<?php
/**
 * Settings Interface for Customizer
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

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
