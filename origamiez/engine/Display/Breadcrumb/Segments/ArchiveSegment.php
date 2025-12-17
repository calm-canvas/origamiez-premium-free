<?php
/**
 * Archive Segment
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb\Segments;

/**
 * Class ArchiveSegment
 *
 * @package Origamiez\Engine\Display\Breadcrumb\Segments
 */
class ArchiveSegment implements SegmentInterface {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix;

	/**
	 * ArchiveSegment constructor.
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
		if ( ! is_archive() && ! is_home() ) {
			return '';
		}

		$html = '';

		if ( is_tag() ) {
			$term = get_term( get_queried_object_id(), 'post_tag' );
			$html = $this->prefix . sprintf(
				'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
				esc_html( $term->name )
			);
		} elseif ( is_category() ) {
			$category_id  = get_queried_object_id();
			$parents_html = get_category_parents( $category_id, true, $this->prefix );
			$parents_html = substr( $parents_html, 0, -strlen( $this->prefix ) );
			$html         = $this->prefix . $parents_html;
		} elseif ( is_year() || is_month() || is_day() ) {
			$html = $this->render_date_archive();
		} elseif ( is_author() ) {
			$author_id = get_queried_object_id();
			$html      = $this->prefix . sprintf(
				'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
				sprintf( esc_attr__( 'Posts created by %1$s', 'origamiez' ), get_the_author_meta( 'display_name', $author_id ) )
			);
		}

		return $html;
	}

	/**
	 * Render date archive.
	 *
	 * @return string
	 */
	private function render_date_archive(): string {
		$m    = get_query_var( 'm' );
		$date = array(
			'y' => null,
			'm' => null,
			'd' => null,
		);

		if ( strlen( $m ) >= 4 ) {
			$date['y'] = substr( $m, 0, 4 );
		}
		if ( strlen( $m ) >= 6 ) {
			$date['m'] = substr( $m, 4, 2 );
		}
		if ( strlen( $m ) >= 8 ) {
			$date['d'] = substr( $m, 6, 2 );
		}

		$html = '';

		if ( $date['y'] ) {
			if ( is_year() ) {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
					$date['y']
				);
			} else {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%s" itemprop="url"><span itemprop="title">%s</span></a></span>',
					get_year_link( $date['y'] ),
					$date['y']
				);
			}
		}

		if ( $date['m'] ) {
			if ( is_month() ) {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
					date( 'F', mktime( 0, 0, 0, (int) $date['m'] ) )
				);
			} else {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%s" itemprop="url"><span itemprop="title">%s</span></a></span>',
					get_month_link( (int) $date['y'], (int) $date['m'] ),
					date( 'F', mktime( 0, 0, 0, (int) $date['m'] ) )
				);
			}
		}

		if ( $date['d'] ) {
			if ( is_day() ) {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="current-page" itemprop="url"><span itemprop="title">%s</span></a></span>',
					$date['d']
				);
			} else {
				$html .= $this->prefix . sprintf(
					'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%s" itemprop="url"><span itemprop="title">%s</span></a></span>',
					get_day_link( (int) $date['y'], (int) $date['m'], (int) $date['d'] ),
					$date['d']
				);
			}
		}

		return $html;
	}
}
