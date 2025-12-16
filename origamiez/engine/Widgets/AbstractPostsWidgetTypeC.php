<?php
/**
 * Abstract Posts Widget Type C
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

/**
 * Class AbstractPostsWidgetTypeC
 */
abstract class AbstractPostsWidgetTypeC extends AbstractPostsWidgetTypeB {

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance           = parent::update( $new_instance, $old_instance );
		$instance['offset'] = isset( $new_instance['offset'] ) ? (int) $new_instance['offset'] : 0;
		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		extract( $instance, EXTR_SKIP );
		parent::form( $instance );
		?>
		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" value="<?php echo esc_attr( $offset ); ?>"/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset. Number of post to displace or pass over.', 'origamiez' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default() {
		$default           = parent::get_default();
		$default['offset'] = 0;
		return $default;
	}

	/**
	 * Get query.
	 *
	 * @param array $instance Widget instance.
	 * @param array $args_extra Extra arguments.
	 * @return array
	 */
	public function get_query( $instance, $args_extra = array() ) {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		extract( $instance, EXTR_SKIP );

		$args = parent::get_query( $instance, $args_extra );

		if ( $offset ) {
			$args['offset'] = $offset;
		}

		return $args;
	}
}
