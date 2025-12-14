<?php

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

class HomeSegment implements SegmentInterface {

	private string $prefix;

	public function __construct( string $prefix = '&nbsp;&rsaquo;&nbsp;' ) {
		$this->prefix = $prefix;
	}

	public function render(): string {
		return '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">'
			. '<a href="' . esc_url( home_url() ) . '" itemprop="url">'
			. '<span itemprop="title">' . esc_attr__( 'Home', 'origamiez' ) . '</span>'
			. '</a>'
			. '</span>';
	}
}
