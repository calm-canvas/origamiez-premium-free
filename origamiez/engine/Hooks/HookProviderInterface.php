<?php

namespace Origamiez\Engine\Hooks;

interface HookProviderInterface {

	public function register( HookRegistry $registry ): void;
}
