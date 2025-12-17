<?php
/**
 * Not Found Segment
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Class NotFoundSegment
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
class NotFoundSegment implements SegmentInterface {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix;

	/**
	 * NotFoundSegment constructor.
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
		if ( ! is_404() ) {
			return '';
		}

		return $this->prefix . sprintf(
			'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
			esc_html__( 'Not Found', 'origamiez' )
		);
	}
}
