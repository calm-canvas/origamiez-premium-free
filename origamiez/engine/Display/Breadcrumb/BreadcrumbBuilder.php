<?php

namespace Origamiez\Engine\Display\Breadcrumb;

use Origamiez\Engine\Display\Breadcrumb\Segments\SegmentInterface;
use Origamiez\Engine\Display\Breadcrumb\Segments\HomeSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\ArchiveSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\SearchSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\PageSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\SingleSegment;
use Origamiez\Engine\Display\Breadcrumb\Segments\NotFoundSegment;

class BreadcrumbBuilder {

	private string $prefix     = '&nbsp;&rsaquo;&nbsp;';
	private string $beforeHtml = '<div class="breadcrumb">';
	private string $afterHtml  = '</div>';
	private array $segments    = array();

	public function __construct() {
		$this->registerDefaultSegments();
	}

	private function registerDefaultSegments(): void {
		$this->segments = array(
			new HomeSegment( $this->prefix ),
			new ArchiveSegment( $this->prefix ),
			new SearchSegment( $this->prefix ),
			new PageSegment( $this->prefix ),
			new SingleSegment( $this->prefix ),
			new NotFoundSegment( $this->prefix ),
		);
	}

	public function registerSegment( SegmentInterface $segment ): self {
		$this->segments[] = $segment;
		return $this;
	}

	public function build(): string {
		$html = $this->beforeHtml;

		foreach ( $this->segments as $segment ) {
			$html .= $segment->render();
		}

		$html .= $this->afterHtml;

		return $html;
	}

	public function setPrefix( string $prefix ): self {
		$this->prefix = $prefix;
		return $this;
	}

	public function setBeforeHtml( string $html ): self {
		$this->beforeHtml = $html;
		return $this;
	}

	public function setAfterHtml( string $html ): self {
		$this->afterHtml = $html;
		return $this;
	}
}
