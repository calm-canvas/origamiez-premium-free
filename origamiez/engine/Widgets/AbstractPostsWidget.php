<?php
/**
 * Abstract Posts Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

use WP_Widget;

/**
 * Class AbstractPostsWidget
 */
abstract class AbstractPostsWidget extends WP_Widget {

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance = $old_instance;

		$instance['title']               = wp_strip_all_tags( $new_instance['title'] );
		$instance['posts_per_page']      = (int) wp_strip_all_tags( $new_instance['posts_per_page'] );
		$instance['orderby']             = isset( $new_instance['orderby'] ) && in_array( $new_instance['orderby'], array( 'date', 'popular', 'comment_count', 'rand' ), true ) ? $new_instance['orderby'] : 'date';
		$instance['category']            = ( isset( $new_instance['category'] ) && is_array( $new_instance['category'] ) ) ? array_filter( $new_instance['category'] ) : array();
		$instance['post_tag']            = ( isset( $new_instance['post_tag'] ) && is_array( $new_instance['post_tag'] ) ) ? array_filter( $new_instance['post_tag'] ) : array();
		$instance['post_format']         = ( isset( $new_instance['post_format'] ) && is_array( $new_instance['post_format'] ) ) ? array_filter( $new_instance['post_format'] ) : array();
		$instance['relation']            = isset( $new_instance['relation'] ) && in_array( $new_instance['relation'], array( 'AND', 'OR' ), true ) ? $new_instance['relation'] : 'OR';
		$instance['in']                  = wp_strip_all_tags( $new_instance['in'] );
		$instance['is_include_children'] = (int) isset( $new_instance['is_include_children'] ) ? 1 : 0;

		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		$instance            = wp_parse_args( (array) $instance, $this->get_default() );
		$is_include_children = $instance['is_include_children'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'origamiez' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( wp_strip_all_tags( $instance['title'] ) ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'origamiez' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_per_page' ) ); ?>" type="text" value="<?php echo esc_attr( (int) $instance['posts_per_page'] ); ?>" />
		</p>

		<?php $this->render_orderby_field( $instance ); ?>

		<?php $this->render_term_selector( 'category', esc_html__( 'Categories:', 'origamiez' ), $instance['category'], true ); ?>

		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'is_include_children' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_include_children' ) ); ?>" type="checkbox" value="1" <?php checked( 1, (int) $is_include_children, true ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_include_children' ) ); ?>"><?php esc_html_e( 'Is include categories children ?', 'origamiez' ); ?></label>
		</p>

		<?php $this->render_term_selector( 'post_tag', esc_html__( 'Tags:', 'origamiez' ), $instance['post_tag'] ); ?>

		<?php $this->render_term_selector( 'post_format', esc_html__( 'Format:', 'origamiez' ), $instance['post_format'] ); ?>

		<?php $this->render_relation_field( $instance ); ?>

		<?php $this->render_time_range_field( $instance ); ?>

		<?php
	}

	/**
	 * Render the orderby field.
	 *
	 * @param array $instance Widget instance.
	 */
	private function render_orderby_field( array $instance ): void {
		$orderbys = array(
			'date'          => esc_attr__( 'Latest news', 'origamiez' ),
			'comment_count' => esc_attr__( 'Most comments', 'origamiez' ),
			'rand'          => esc_attr__( 'Random', 'origamiez' ),
		);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by:', 'origamiez' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<?php foreach ( $orderbys as $value => $title ) { ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo esc_html( $title ); ?></option>
				<?php } ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Render a term selector field (for categories, tags, formats).
	 *
	 * @param string $taxonomy The taxonomy name.
	 * @param string $label The field label.
	 * @param array  $selected_terms Currently selected term IDs.
	 * @param bool   $use_prefix Whether to show metadata prefix in empty option.
	 */
	private function render_term_selector( string $taxonomy, string $label, array $selected_terms, bool $use_prefix = false ): void {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $taxonomy ) ); ?>"><?php echo esc_html( $label ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $taxonomy ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $taxonomy ) ); ?>[]" multiple="multiple" size="5">
				<?php if ( $use_prefix ) { ?>
					<option value=""><?php origamiez_get_metadata_prefix(); ?> <?php esc_html_e( 'All', 'origamiez' ); ?> <?php origamiez_get_metadata_prefix(); ?></option>
				<?php } else { ?>
					<option value=""><?php esc_html_e( '-- All --', 'origamiez' ); ?></option>
				<?php } ?>
				<?php
				$terms = get_terms( $taxonomy );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						$is_selected = in_array( $term->term_id, $selected_terms, true );
						?>
						<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php selected( $is_selected ); ?>><?php echo esc_html( $term->name ); ?></option>
						<?php
					}
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * Render the relation field.
	 *
	 * @param array $instance Widget instance.
	 */
	private function render_relation_field( array $instance ): void {
		$relations = array(
			'AND' => esc_attr__( 'And', 'origamiez' ),
			'OR'  => esc_attr__( 'Or', 'origamiez' ),
		);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'relation' ) ); ?>"><?php esc_html_e( 'Combine condition by Tags, Categories, Format', 'origamiez' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'relation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'relation' ) ); ?>">
				<?php foreach ( $relations as $value => $title ) { ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $instance['relation'], $value ); ?>><?php echo esc_html( $title ); ?></option>
				<?php } ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Render the time range field.
	 *
	 * @param array $instance Widget instance.
	 */
	private function render_time_range_field( array $instance ): void {
		$times = array(
			''          => esc_attr__( '-- All --', 'origamiez' ),
			'-1 week'   => esc_attr__( '1 week', 'origamiez' ),
			'-2 week'   => esc_attr__( '2 weeks', 'origamiez' ),
			'-3 week'   => esc_attr__( '3 weeks', 'origamiez' ),
			'-1 month'  => esc_attr__( '1 months', 'origamiez' ),
			'-2 month'  => esc_attr__( '2 months', 'origamiez' ),
			'-3 month'  => esc_attr__( '3 months', 'origamiez' ),
			'-4 month'  => esc_attr__( '4 months', 'origamiez' ),
			'-5 month'  => esc_attr__( '5 months', 'origamiez' ),
			'-6 month'  => esc_attr__( '6 months', 'origamiez' ),
			'-7 month'  => esc_attr__( '7 months', 'origamiez' ),
			'-8 month'  => esc_attr__( '8 months', 'origamiez' ),
			'-9 month'  => esc_attr__( '9 months', 'origamiez' ),
			'-10 month' => esc_attr__( '10 months', 'origamiez' ),
			'-11 month' => esc_attr__( '11 months', 'origamiez' ),
			'-1 year'   => esc_attr__( '1 year', 'origamiez' ),
			'-2 year'   => esc_attr__( '2 years', 'origamiez' ),
			'-3 year'   => esc_attr__( '3 years', 'origamiez' ),
			'-4 year'   => esc_attr__( '4 years', 'origamiez' ),
			'-5 year'   => esc_attr__( '5 years', 'origamiez' ),
		);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'in' ) ); ?>"><?php esc_html_e( 'In:', 'origamiez' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'in' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'in' ) ); ?>">
				<?php foreach ( $times as $value => $title ) { ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $instance['in'], $value ); ?>><?php echo esc_html( $title ); ?></option>
				<?php } ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Get query.
	 *
	 * @param array $instance Widget instance.
	 * @param array $args_extra Extra arguments.
	 * @return array
	 */
	public function get_query( $instance, $args_extra = array() ): array {
		global $wp_version;

		$args = array(
			'post_type'           => array( 'post' ),
			'posts_per_page'      => (int) $instance['posts_per_page'],
			'post_status'         => array( 'publish' ),
			'ignore_sticky_posts' => true,
		);

		$this->add_tax_query( $args, $instance );
		$this->set_orderby( $args, $instance );
		$this->add_date_query( $args, $instance, $wp_version );

		return ! empty( $args_extra ) ? array_merge( $args, $args_extra ) : $args;
	}

	/**
	 * Add taxonomy queries to args.
	 *
	 * @param array $args Query arguments (passed by reference).
	 * @param array $instance Widget instance.
	 */
	private function add_tax_query( array &$args, array $instance ): void {
		$tax_queries = array();

		if ( ! empty( $instance['category'] ) ) {
			$tax_queries[] = array(
				'taxonomy'         => 'category',
				'field'            => 'id',
				'terms'            => $instance['category'],
				'include_children' => (int) $instance['is_include_children'],
			);
		}

		if ( ! empty( $instance['post_tag'] ) ) {
			$tax_queries[] = array(
				'taxonomy' => 'post_tag',
				'field'    => 'id',
				'terms'    => $instance['post_tag'],
			);
		}

		if ( ! empty( $instance['post_format'] ) ) {
			$tax_queries[] = array(
				'taxonomy' => 'post_format',
				'field'    => 'id',
				'terms'    => $instance['post_format'],
			);
		}

		if ( ! empty( $tax_queries ) ) {
			$args['tax_query'] = $tax_queries;
			if ( count( $tax_queries ) >= 2 ) {
				$args['tax_query']['relation'] = $instance['relation'];
			}
		}
	}

	/**
	 * Set the orderby parameter.
	 *
	 * @param array $args Query arguments (passed by reference).
	 * @param array $instance Widget instance.
	 */
	private function set_orderby( array &$args, array $instance ): void {
		$valid_orderbys  = array( 'comment_count', 'rand', 'date' );
		$orderby         = $instance['orderby'] ?? 'date';
		$args['orderby'] = in_array( $orderby, $valid_orderbys, true ) ? $orderby : 'date';
	}

	/**
	 * Add date query if specified.
	 *
	 * @param array  $args Query arguments (passed by reference).
	 * @param array  $instance Widget instance.
	 * @param string $wp_version Current WordPress version.
	 */
	private function add_date_query( array &$args, array $instance, string $wp_version ): void {
		if ( version_compare( $wp_version, '3.7', '<' ) || empty( $instance['in'] ) ) {
			return;
		}

		$in                 = $instance['in'];
		$args['date_query'] = array(
			array(
				'after' => array(
					'year'  => (int) gmdate( 'Y', strtotime( $in ) ),
					'month' => (int) gmdate( 'm', strtotime( $in ) ),
					'day'   => (int) gmdate( 'd', strtotime( $in ) ),
				),
			),
		);
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default(): array {
		return array(
			'title'               => '',
			'posts_per_page'      => 5,
			'orderby'             => 'date',
			'category'            => array(),
			'is_include_children' => 1,
			'post_tag'            => array(),
			'post_format'         => array(),
			'relation'            => 'OR',
			'in'                  => '',
		);
	}
}
