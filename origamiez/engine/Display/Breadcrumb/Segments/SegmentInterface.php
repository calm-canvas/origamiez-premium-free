<?php
/**
 * Segment Interface
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Interface SegmentInterface
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
interface SegmentInterface {

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string;
}
