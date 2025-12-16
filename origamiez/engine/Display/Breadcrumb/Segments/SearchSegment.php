<?php

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

class SearchSegment implements SegmentInterface {

	private string $prefix;

	public function __construct( string $prefix = '&nbsp;&rsaquo;&nbsp;' ) {
		$this->prefix = $prefix;
	}

	public function render(): string {
		if ( ! is_search() ) {
			return '';
		}

		global $wp_query;
		$searchQuery = get_search_query();
		$resultCount = $wp_query->found_posts;

		return $this->prefix . sprintf(
			'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
			sprintf( esc_attr__( 'Searched for "%1$s" return %2$s results', 'origamiez' ), esc_html( $searchQuery ), $resultCount )
		);
	}
}
