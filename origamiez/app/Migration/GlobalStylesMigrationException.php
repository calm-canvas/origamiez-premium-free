<?php
/**
 * Migration failure for Customizer → global styles (Theme JSON) one-shot.
 *
 * @package Origamiez
 */

namespace Origamiez\Migration;

use RuntimeException;

/**
 * Thrown when the global styles post cannot be read, merged, or saved.
 */
class GlobalStylesMigrationException extends RuntimeException {
}
