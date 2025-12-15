<?php

namespace Origamiez\Engine\Customizer\Settings;

use Origamiez\Engine\Customizer\CustomizerService;

interface SettingsInterface {
	public function register( CustomizerService $service ): void;
}
