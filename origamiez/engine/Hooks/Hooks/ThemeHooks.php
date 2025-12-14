<?php

namespace Origamiez\Engine\Hooks\Hooks;

use Origamiez\Engine\Hooks\HookProviderInterface;
use Origamiez\Engine\Hooks\HookRegistry;

class ThemeHooks implements HookProviderInterface {

	public function register( HookRegistry $registry ): void {
		$registry
			->addAction( 'after_setup_theme', [ $this, 'themeSetup' ] )
			->addAction( 'init', [ $this, 'configTextDomain' ], 5 )
			->addAction( 'init', [ $this, 'registerTranslatedMenus' ], 20 )
			->addAction( 'updated_option', [ $this, 'saveUnysonOptions' ], 10, 3 );
	}

	public function themeSetup(): void {
	}

	public function configTextDomain(): void {
	}

	public function registerTranslatedMenus(): void {
	}

	public function saveUnysonOptions( string $optionName, mixed $oldValue, mixed $newValue ): void {
	}
}
