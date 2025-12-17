<?php
/**
 * Single Segment
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Class SingleSegment
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
class SingleSegment implements SegmentInterface {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix;

	/**
	 * SingleSegment constructor.
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
		if ( ! is_single() ) {
			return '';
		}

		$html       = '';
		$post_id    = get_queried_object_id();
		$categories = get_the_category( $post_id );

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
			get_permalink( $post_id ),
			esc_html( get_the_title( $post_id ) )
		);

		return $html;
	}
}
