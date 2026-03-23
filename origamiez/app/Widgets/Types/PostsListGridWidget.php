<?php
/**
 * Posts List Grid Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsWidgetTypeC;
use WP_Query;

/**
 * Class PostsListGridWidget
 */
class PostsListGridWidget extends AbstractPostsWidgetTypeC {
	/**
	 * Register widget.
	 */
	public static function register(): void {
		register_widget( __CLASS__ );
	}

	/**
	 * PostsListGridWidget constructor.
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'origamiez-widget-posts-grid',
			'description' => esc_attr__( 'Display posts grid with small thumbnail.', 'origamiez' ),
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( 'origamiez-widget-post-grid', esc_attr__( 'Origamiez Posts Grid', 'origamiez' ), $widget_ops, $control_ops );
	}

	/**
	 * Render widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		$this->echo_widget_shell_open( $args, $instance );
		$query = $this->get_query( $instance );
		$posts = new WP_Query( $query );
		$this->render_posts_grid_widget_content( $posts, $instance );
		wp_reset_postdata();
		$this->echo_widget_shell_close( $args );
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
