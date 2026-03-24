<?php
/**
 * Posts List Grid Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsListTypeCWidget;
use WP_Query;

/**
 * Class PostsListGridWidget
 */
class PostsListGridWidget extends AbstractPostsListTypeCWidget {

	/**
	 * Widget id, labels, and body class for WP_Widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function widget_registration_config(): array {
		return static::make_widget_registration(
			'origamiez-widget-post-grid',
			esc_attr__( 'Origamiez Posts Grid', 'origamiez' ),
			'origamiez-widget-posts-grid',
			esc_attr__( 'Display posts grid with small thumbnail.', 'origamiez' )
		);
	}

	/**
	 * Print the posts markup for this widget layout.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	protected function render_posts_list_markup( WP_Query $posts, array $instance ): void {
		$this->render_posts_grid_widget_content( $posts, $instance );
	}

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance                 = parent::update( $new_instance, $old_instance );
		$instance['cols_per_row'] = (int) esc_attr( $new_instance['cols_per_row'] );

		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		parent::form( $instance );
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cols_per_row' ) ); ?>"><?php esc_html_e( 'Cols per row:', 'origamiez' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cols_per_row' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'cols_per_row' ) ); ?>">
				<?php
				$cols = array( 3, 4, 6 );
				foreach ( $cols as $col ) {
					?>
					<option value="<?php echo esc_attr( $col ); ?>" <?php selected( $instance['cols_per_row'], $col ); ?>><?php echo esc_html( $col ); ?></option>
					<?php
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default(): array {
		$default                 = parent::get_default();
		$default['cols_per_row'] = 3;

		return $default;
	}
}
