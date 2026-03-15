<?php
/**
 * Widget Factory
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets;

use Origamiez\Widgets\Types\PostsListGridWidget;
use Origamiez\Widgets\Types\PostsListMediaWidget;
use Origamiez\Widgets\Types\PostsListSliderWidget;
use Origamiez\Widgets\Types\PostsListSmallWidget;
use Origamiez\Widgets\Types\PostsListTwoColsWidget;
use Origamiez\Widgets\Types\PostsListWithBackgroundWidget;
use Origamiez\Widgets\Types\PostsListZebraWidget;
use Origamiez\Widgets\Types\SocialLinksWidget;

/**
 * Class WidgetFactory
 */
class WidgetFactory {

	/**
	 * Widget registry.
	 *
	 * @var WidgetRegistry
	 */
	private WidgetRegistry $widget_registry;

	/**
	 * WidgetFactory constructor.
	 */
	public function __construct() {
		$this->widget_registry = WidgetRegistry::get_instance();
	}

	/**
	 * Boot the factory.
	 */
	public function boot(): void {
		$this->register_widgets();
		$this->widget_registry->register();
	}

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		static $instance = null;
		if ( null === $instance ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Register widgets.
	 *
	 * @return self
	 */
	public function register_widgets(): self {
		$this->widget_registry->register_widget( SocialLinksWidget::class );
		$this->widget_registry->register_widget( PostsListGridWidget::class );
		$this->widget_registry->register_widget( PostsListSmallWidget::class );
		$this->widget_registry->register_widget( PostsListZebraWidget::class );
		$this->widget_registry->register_widget( PostsListSliderWidget::class );
		$this->widget_registry->register_widget( PostsListTwoColsWidget::class );
		$this->widget_registry->register_widget( PostsListWithBackgroundWidget::class );
		$this->widget_registry->register_widget( PostsListMediaWidget::class );
		return $this;
	}

	/**
	 * Get widget registry.
	 *
	 * @return WidgetRegistry
	 */
	public function get_widget_registry(): WidgetRegistry {
		return $this->widget_registry;
	}
}
