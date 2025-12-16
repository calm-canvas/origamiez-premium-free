<?php

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

class PageSegment implements SegmentInterface {

	private string $prefix;

	public function __construct( string $prefix = '&nbsp;&rsaquo;&nbsp;' ) {
		$this->prefix = $prefix;
	}

	public function render(): string {
		if ( ! is_page() ) {
			return '';
		}

		global $post;
		$html = '';

		$postAncestors = get_post_ancestors( $post );
		if ( $postAncestors ) {
			$postAncestors = array_reverse( $postAncestors );
			foreach ( $postAncestors as $crumb ) {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%s" itemprop="url"><span itemprop="title">%s</span></a></span>',
					get_permalink( $crumb ),
					esc_html( get_the_title( $crumb ) )
				);
			}
		}

		$pageId = get_queried_object_id();
		$html  .= $this->prefix . sprintf(
			'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url" href="%s"><span itemprop="title">%s</span></a></span>',
			get_permalink( $pageId ),
			esc_html( get_the_title( $pageId ) )
		);

		return $html;
	}
}
