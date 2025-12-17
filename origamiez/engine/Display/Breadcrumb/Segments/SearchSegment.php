<?php
/**
 * Search Segment
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Class SearchSegment
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
class SearchSegment implements SegmentInterface {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix;

	/**
	 * SearchSegment constructor.
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
		if ( ! is_search() ) {
			return '';
		}

		global $wp_query;
		$search_query = get_search_query();
		$result_count = $wp_query->found_posts;

		return $this->prefix . sprintf(
			'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
			sprintf( esc_attr__( 'Searched for "%1$s" return %2$s results', 'origamiez' ), esc_html( $search_query ), $result_count )
		);
	}
}
