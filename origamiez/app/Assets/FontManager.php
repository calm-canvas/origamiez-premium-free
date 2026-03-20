<?php
/**
 * Manages theme fonts.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Assets;

/**
 * Class FontManager
 *
 * Google Fonts and dynamic slots load in {@see StylesheetManager} to avoid duplicate handles.
 */
class FontManager {

	/**
	 * FontManager constructor.
	 */
	public function __construct() {
	}

	/**
	 * Reserved; font stylesheets enqueue in StylesheetManager.
	 */
	public function enqueue(): void {
	}
}
