<?php

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

class SingleSegment implements SegmentInterface {

	private string $prefix;

	public function __construct( string $prefix = '&nbsp;&rsaquo;&nbsp;' ) {
		$this->prefix = $prefix;
	}

	public function render(): string {
		if ( ! is_single() ) {
			return '';
		}

		$html = '';
		$postId = get_queried_object_id();
		$categories = get_the_category( $postId );

		if ( $categories ) {
			foreach ( $categories as $category ) {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%s" itemprop="url"><span itemprop="title">%s</span></a></span>',
					get_category_link( $category->term_id ),
					esc_html( $category->name )
				);
			}
		}

		$html .= $this->prefix . sprintf(
			'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url" href="%s"><span itemprop="title">%s</span></a></span>',
			get_permalink( $postId ),
			esc_html( get_the_title( $postId ) )
		);

		return $html;
	}
}
