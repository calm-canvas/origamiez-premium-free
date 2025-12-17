<?php
/**
 * Page Segment
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Class PageSegment
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
class PageSegment implements SegmentInterface {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix;

	/**
	 * PageSegment constructor.
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
		if ( ! is_page() ) {
			return '';
		}

		global $post;
		$html = '';

		$post_ancestors = get_post_ancestors( $post );
		if ( $post_ancestors ) {
			$post_ancestors = array_reverse( $post_ancestors );
			foreach ( $post_ancestors as $crumb ) {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%s" itemprop="url"><span itemprop="title">%s</span></a></span>',
					get_permalink( $crumb ),
					esc_html( get_the_title( $crumb ) )
				);
			}
		}

		$page_id = get_queried_object_id();
		$html   .= $this->prefix . sprintf(
			'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url" href="%s"><span itemprop="title">%s</span></a></span>',
			get_permalink( $page_id ),
			esc_html( get_the_title( $page_id ) )
		);

		return $html;
	}
}
