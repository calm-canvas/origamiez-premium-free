<?php

namespace Origamiez\Engine\Widgets;

use Origamiez\Engine\Widgets\Types\PostsListGridWidget;
use Origamiez\Engine\Widgets\Types\PostsListMediaWidget;
use Origamiez\Engine\Widgets\Types\PostsListSliderWidget;
use Origamiez\Engine\Widgets\Types\PostsListSmallWidget;
use Origamiez\Engine\Widgets\Types\PostsListTwoColsWidget;
use Origamiez\Engine\Widgets\Types\PostsListWithBackgroundWidget;
use Origamiez\Engine\Widgets\Types\PostsListZebraWidget;
use Origamiez\Engine\Widgets\Types\SocialLinksWidget;

require_once __DIR__ . '/AbstractPostsWidget.php';
require_once __DIR__ . '/AbstractPostsWidgetTypeB.php';
require_once __DIR__ . '/AbstractPostsWidgetTypeC.php';

class WidgetFactory {

	private WidgetRegistry $widgetRegistry;

	public function __construct() {
		$this->widgetRegistry = WidgetRegistry::getInstance();
	}

	public function boot(): void {
		$this->registerWidgets();
		$this->widgetRegistry->register();
	}

	public static function getInstance(): self {
		static $instance = null;
		if ( $instance === null ) {
			$instance = new self();
		}
		return $instance;
	}

	public function registerWidgets(): self {
		$this->widgetRegistry->registerWidget( SocialLinksWidget::class );
		$this->widgetRegistry->registerWidget( PostsListGridWidget::class );
		$this->widgetRegistry->registerWidget( PostsListSmallWidget::class );
		$this->widgetRegistry->registerWidget( PostsListZebraWidget::class );
		$this->widgetRegistry->registerWidget( PostsListSliderWidget::class );
		$this->widgetRegistry->registerWidget( PostsListTwoColsWidget::class );
		$this->widgetRegistry->registerWidget( PostsListWithBackgroundWidget::class );
		$this->widgetRegistry->registerWidget( PostsListMediaWidget::class );
		return $this;
	}

	public function getWidgetRegistry(): WidgetRegistry {
		return $this->widgetRegistry;
	}
}
