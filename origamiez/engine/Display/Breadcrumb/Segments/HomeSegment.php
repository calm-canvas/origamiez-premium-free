<?php
/**
 * Home Segment
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Class HomeSegment
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
class HomeSegment implements SegmentInterface {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix;

	/**
	 * HomeSegment constructor.
	 *
	 * @param string $prefix The prefix.
	 */
	public function __construct( string $prefix = '&nbsp;&rsaquo;&nbsp;' ) {
		$this->prefix = $prefix;
	}

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string {
		return '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">'
			. '<a href="' . esc_url( home_url() ) . '" itemprop="url">'
			. '<span itemprop="title">' . esc_attr__( 'Home', 'origamiez' ) . '</span>'
			. '</a>'
			. '</span>';
	}
}
