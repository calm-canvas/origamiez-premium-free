<?php

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

class NotFoundSegment implements SegmentInterface {

	private string $prefix;

	public function __construct( string $prefix = '&nbsp;&rsaquo;&nbsp;' ) {
		$this->prefix = $prefix;
	}

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
