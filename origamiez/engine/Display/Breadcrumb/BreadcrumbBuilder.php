<?php
/**
 * Breadcrumb Builder
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display\Breadcrumb;

use Origamiez\Engine\Display\Breadcrumb\Segments\SegmentInterface;
use Origamiez\Engine\Display\Breadcrumb\Segments\HomeSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\ArchiveSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\SearchSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\PageSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\SingleSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\NotFoundSegment;

/**
 * Class BreadcrumbBuilder
 *
 * @package Origamiez\Engine\Display\Breadcrumb
 */
class BreadcrumbBuilder {

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private string $prefix = '&nbsp;&rsaquo;&nbsp;';
	/**
	 * Before html.
	 *
	 * @var string
	 */
	private string $before_html = '<div class="breadcrumb">';
	/**
	 * After html.
	 *
	 * @var string
	 */
	private string $after_html = '</div>';
	/**
	 * Segments.
	 *
	 * @var array
	 */
	private array $segments = array();

	/**
	 * BreadcrumbBuilder constructor.
	 */
	public function __construct() {
		$this->register_default_segments();
	}

	/**
	 * Register default segments.
	 *
	 * @return void
	 */
	private function register_default_segments(): void {
		$this->segments = array(
			new HomeSegment( $this->prefix ),
			new ArchiveSegment( $this->prefix ),
			new SearchSegment( $this->prefix ),
			new PageSegment( $this->prefix ),
			new SingleSegment( $this->prefix ),
			new NotFoundSegment( $this->prefix ),
		);
	}

	/**
	 * Register segment.
	 *
	 * @param SegmentInterface $segment The segment.
	 *
	 * @return self
	 */
	public function register_segment( SegmentInterface $segment ): self {
		$this->segments[] = $segment;
		return $this;
	}

	/**
	 * Build.
	 *
	 * @return string
	 */
	public function build(): string {
		$html = $this->before_html;

		foreach ( $this->segments as $segment ) {
			$html .= $segment->render();
		}

		$html .= $this->after_html;

		return $html;
	}

	/**
	 * Set prefix.
	 *
	 * @param string $prefix The prefix.
	 *
	 * @return self
	 */
	public function set_prefix( string $prefix ): self {
		$this->prefix = $prefix;
		return $this;
	}

	/**
	 * Set before html.
	 *
	 * @param string $html The html.
	 *
	 * @return self
	 */
	public function set_before_html( string $html ): self {
		$this->before_html = $html;
		return $this;
	}

	/**
	 * Set after html.
	 *
	 * @param string $html The html.
	 *
	 * @return self
	 */
	public function set_after_html( string $html ): self {
		$this->after_html = $html;
		return $this;
	}
}
