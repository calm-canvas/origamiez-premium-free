<?php
/**
 * Widget Wrapper Manager
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Layout;

/**
 * Class WidgetWrapperManager
 *
 * @package Origamiez\Engine\Layout
 */
class WidgetWrapperManager {

	/**
	 * Custom wrappers.
	 *
	 * @var array
	 */
	private array $custom_wrappers = array();

	/**
	 * WidgetWrapperManager constructor.
	 */
	public function __construct() {
		$this->initialize_default_wrappers();
	}

	/**
	 * Initialize default wrappers.
	 *
	 * @return void
	 */
	private function initialize_default_wrappers(): void {
		$this->custom_wrappers = array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		);
	}

	/**
	 * Get dynamic sidebar params.
	 *
	 * @param array $params The params.
	 *
	 * @return array
	 */
	public function get_dynamic_sidebar_params( array $params ): array {
		global $wp_registered_widgets;

		$widget_id  = $params[0]['widget_id'] ?? null;
		$widget_obj = $wp_registered_widgets[ $widget_id ] ?? null;

		if ( null === $widget_obj || ! isset( $widget_obj['callback'][0] ) ) {
			return $params;
		}

		$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
		$widget_num = $widget_obj['params'][0]['number'] ?? null;

		if ( null === $widget_num ) {
			return $params;
		}

		if ( ! isset( $widget_opt[ $widget_num ]['title'] ) ||
			( isset( $widget_opt[ $widget_num ]['title'] ) && empty( $widget_opt[ $widget_num ]['title'] ) ) ) {

			$params[0]['before_widget'] .= '<div class="origamiez-widget-content clearfix">';
			$params[0]['before_title']   = '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">';
			$params[0]['after_title']    = '</span></h2>';
		}

		return apply_filters( 'origamiez_dynamic_sidebar_params', $params );
	}

	/**
	 * Set custom wrapper.
	 *
	 * @param string $key The key.
	 * @param string $html The html.
	 *
	 * @return self
	 */
	public function set_custom_wrapper( string $key, string $html ): self {
		$valid_keys = array( 'before_widget', 'after_widget', 'before_title', 'after_title' );

		if ( in_array( $key, $valid_keys, true ) ) {
			$this->custom_wrappers[ $key ] = $html;
		}

		return $this;
	}

	/**
	 * Get custom wrapper.
	 *
	 * @param string $key The key.
	 *
	 * @return string|null
	 */
	public function get_custom_wrapper( string $key ): ?string {
		return $this->custom_wrappers[ $key ] ?? null;
	}

	/**
	 * Get all custom wrappers.
	 *
	 * @return array
	 */
	public function get_all_custom_wrappers(): array {
		return $this->custom_wrappers;
	}

	/**
	 * Reset wrappers.
	 *
	 * @return self
	 */
	public function reset_wrappers(): self {
		$this->initialize_default_wrappers();

		return $this;
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register(): void {
		add_filter( 'dynamic_sidebar_params', array( $this, 'get_dynamic_sidebar_params' ) );
	}
}
