<?php
/**
 * BbPress Hooks
 *
 * @package Origamiez
 */

namespace Origamiez\Hooks\Plugins;

use Origamiez\Hooks\HookProviderInterface;
use Origamiez\Hooks\HookRegistry;

/**
 * Class BbpressHooks
 *
 * @package Origamiez\Hooks\Plugins
 */
class BbpressHooks implements HookProviderInterface {

	/**
	 * Register hooks.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		if ( ! class_exists( 'bbPress' ) ) {
			return;
		}

		$registry->add_action( 'init', array( $this, 'register_sidebar' ), 40 );
		$registry->add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 5 );
	}

	/**
	 * Registers the bbPress sidebar.
	 *
	 * @return void
	 */
	public function register_sidebar(): void {
		register_sidebar(
			array(
				'id'            => 'bbpress_right_sidebar',
				'name'          => esc_attr__( 'Right (bbPress)', 'origamiez' ),
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget origamiez-bbpress-widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">',
				'after_title'   => '</span></h2><div class="origamiez-widget-content clearfix">',
			)
		);
	}

	/**
	 * Sets up bbPress theme support.
	 *
	 * @return void
	 */
	public function theme_setup(): void {
		if ( ! is_admin() ) {
			add_filter( 'origamiez_get_current_sidebar', array( $this, 'set_sidebar' ), 20, 2 );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			add_filter( 'bbp_get_reply_content', array( $this, 'shortcodes' ), 10, 2 );
			add_filter( 'bbp_get_topic_content', array( $this, 'shortcodes' ), 10, 2 );
		}
	}

	/**
	 * Processes shortcodes in bbPress content.
	 *
	 * @param string $content  The content.
	 * @param int    $reply_id The reply ID.
	 *
	 * @return string The processed content.
	 */
	public function shortcodes( string $content, int $reply_id ): string {
		$reply_author = bbp_get_reply_author_id( $reply_id );

		// phpcs:ignore WordPress.WP.Capabilities.Unknown
		if ( user_can( $reply_author, 'publish_forums' ) ) {
			$content = do_shortcode( $content );
		}

		return $content;
	}

	/**
	 * Sets the bbPress sidebar.
	 *
	 * @param string $sidebar  The sidebar ID.
	 * @param string $position The sidebar position.
	 *
	 * @return string The sidebar ID.
	 */
	public function set_sidebar( string $sidebar, string $position ): string {
		if ( 'right' === $position ) {
			$tax = get_queried_object();

			if ( is_singular( 'topic' ) ||
				is_singular( 'forum' ) ||
				is_post_type_archive( 'forum' ) ||
				is_post_type_archive( 'topic' ) ||
				( isset( $tax->taxonomy ) && in_array( $tax->taxonomy, array( 'topic-tag' ), true ) ) ||
				bbp_is_search()
			) {
				$sidebar = 'bbpress_right_sidebar';
			}
		}

		return $sidebar;
	}

	/**
	 * Adds bbPress body classes.
	 *
	 * @param array $classes The body classes.
	 *
	 * @return array The filtered body classes.
	 */
	public function body_class( array $classes ): array {
		$tax = get_queried_object();

		if ( is_singular( 'topic' ) ||
			is_singular( 'forum' ) ||
			is_post_type_archive( 'forum' ) ||
			is_post_type_archive( 'topic' ) ||
			( isset( $tax->taxonomy ) && in_array( $tax->taxonomy, array( 'topic-tag' ), true ) ) ||
			bbp_is_search()
		) {
			array_push( $classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single' );
		}

		return $classes;
	}
}
