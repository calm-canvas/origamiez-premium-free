<?php
namespace Origamiez\Engine\Security\Sanitizers;

interface SanitizerInterface {
	public function sanitize( $value );
}
