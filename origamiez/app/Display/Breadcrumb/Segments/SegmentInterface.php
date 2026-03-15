<?php
/**
 * Segment Interface
 *
 * @package Origamiez
 */

namespace Origamiez\Display\Breadcrumb\Segments;

/**
 * Interface SegmentInterface
 *
 * @package Origamiez\Display\Breadcrumb\Segments
 */
interface SegmentInterface {

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string;
}
