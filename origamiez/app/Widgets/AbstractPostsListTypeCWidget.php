<?php
/**
 * Shared bootstrap for Origamiez "posts list" Type C widgets (register, WP_Widget args, widget shell).
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets;

use WP_Query;

/**
 * Class AbstractPostsListTypeCWidget
 */
abstract class AbstractPostsListTypeCWidget extends AbstractPostsWidgetTypeC {

	/**
	 * Register widget.
	 */
	public static function register(): void {
		register_widget( static::class );
	}

	/**
	 * Subclasses provide registration data and implement {@see render_posts_list_markup()}.
	 */
	public function __construct() {
		$c           = static::widget_registration_config();
		$widget_ops  = array(
			'classname'   => $c['classname'],
			'description' => $c['description'],
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( $c['id_base'], $c['title'], $widget_ops, $control_ops );
	}

	/**
	 * Render widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
		$this->render_posts_widget_with_query(
			$args,
			$instance,
			array( $this, 'render_posts_list_markup' )
		);
	}

	/**
	 * Widget id, labels, and body class for WP_Widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	abstract protected static function widget_registration_config(): array;

	/**
	 * Build registration array (keeps CPD from repeating the same keys in every widget file).
	 *
	 * @param string $id_base     Widget id_base.
	 * @param string $title       Translated admin title.
	 * @param string $classname   Body class.
	 * @param string $description Translated picker description.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function make_widget_registration( string $id_base, string $title, string $classname, string $description ): array {
		return array(
			'id_base'     => $id_base,
			'title'       => $title,
			'classname'   => $classname,
			'description' => $description,
		);
	}

	/**
	 * Output posts when the query has results (invoked from the shared widget shell).
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	abstract protected function render_posts_list_markup( WP_Query $posts, array $instance ): void;
}
