<?php
/**
 * Display Renderer Base Class
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display;

/**
 * Abstract DisplayRenderer class
 *
 * Provides a base template for rendering and displaying content.
 * Implements the Template Method pattern to eliminate code duplication
 * between display classes.
 *
 * @package Origamiez\Engine\Display
 */
abstract class DisplayRenderer {

	/**
	 * Render content as a string.
	 *
	 * @return string The rendered HTML content.
	 */
	abstract public function render(): string;

	/**
	 * Display the rendered content.
	 *
	 * Outputs the rendered content to the page, applying proper escaping.
	 *
	 * @return void
	 */
	public function display(): void {
		echo wp_kses_post( $this->render() );
	}

	/**
	 * Capture output buffer content.
	 *
	 * Helper method to capture PHP output into a string.
	 *
	 * @param callable $callback The callback to execute within output buffer.
	 * @return string The buffered output.
	 */
	protected function capture_output( callable $callback ): string {
		ob_start();
		$callback();
		return ob_get_clean();
	}
}
