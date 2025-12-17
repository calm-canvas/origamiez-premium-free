<?php
/**
 * Abstract Posts Widget Type B
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

/**
 * Class AbstractPostsWidgetTypeB
 */
abstract class AbstractPostsWidgetTypeB extends AbstractPostsWidget {

	/**
	 * Excerpt length.
	 *
	 * @var int
	 */
	private int $excerpt_length = 0;

	/**
	 * Update widget.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance                        = parent::update( $new_instance, $old_instance );
		$instance['excerpt_words_limit'] = isset( $new_instance['excerpt_words_limit'] ) ? (int) $new_instance['excerpt_words_limit'] : 0;
		$instance['is_show_author']      = isset( $new_instance['is_show_author'] ) ? 1 : 0;
		$instance['is_show_date']        = isset( $new_instance['is_show_date'] ) ? 1 : 0;
		$instance['is_show_comments']    = isset( $new_instance['is_show_comments'] ) ? 1 : 0;

		return $instance;
	}

	/**
	 * Render form.
	 *
	 * @param array $instance Widget instance.
	 */
	public function form( $instance ): void {
		$instance = wp_parse_args( (array) $instance, $this->get_default() );
		extract( $instance, EXTR_SKIP );
		parent::form( $instance );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_words_limit' ) ); ?>"><?php esc_html_e( 'Excerpt words limit:', 'origamiez' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_words_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_words_limit' ) ); ?>">
				<?php
				$limits = array( 0, 10, 15, 20, 30, 60 );
				foreach ( $limits as $limit ) {
					?>
					<option value="<?php echo esc_attr( $limit ); ?>" <?php selected( $instance['excerpt_words_limit'], $limit ); ?>><?php echo esc_html( $limit ); ?></option>
					<?php
				}
				?>
			</select>
		</p>
		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'is_show_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_show_author' ) ); ?>" type="checkbox" value="1" <?php checked( 1, (int) $is_show_author, true ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_show_author' ) ); ?>"><?php esc_html_e( 'Is show author ?', 'origamiez' ); ?></label>
		</p>
		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'is_show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_show_date' ) ); ?>" type="checkbox" value="1" <?php checked( 1, (int) $is_show_date, true ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_show_date' ) ); ?>"><?php esc_html_e( 'Is show date ?', 'origamiez' ); ?></label>
		</p>
		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'is_show_comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_show_comments' ) ); ?>" type="checkbox" value="1" <?php checked( 1, (int) $is_show_comments, true ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_show_comments' ) ); ?>"><?php esc_html_e( 'Is show comments ?', 'origamiez' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Get default values.
	 *
	 * @return array
	 */
	protected function get_default(): array {
		$default                        = parent::get_default();
		$default['excerpt_words_limit'] = 0;
		$default['is_show_author']      = 0;
		$default['is_show_date']        = 1;
		$default['is_show_comments']    = 1;

		return $default;
	}

	/**
	 * Print metadata.
	 *
	 * @param bool   $is_show_date Show date.
	 * @param bool   $is_show_comments Show comments.
	 * @param bool   $is_show_author Show author.
	 * @param string $classes Additional classes.
	 */
	protected function print_metadata( bool $is_show_date = false, bool $is_show_comments = false, bool $is_show_author = false, string $classes = '' ): void {
		if ( $is_show_date || $is_show_comments || $is_show_author ) :
			?>

			<p class="<?php echo esc_attr( $classes ); ?>">

				<?php if ( $is_show_date ) : ?>
					<?php get_template_part( 'parts/metadata/date' ); ?>
				<?php endif; ?>

				<?php if ( $is_show_date && $is_show_comments ) : ?>
					<?php get_template_part( 'parts/metadata/divider' ); ?>
				<?php endif; ?>

				<?php if ( $is_show_comments ) : ?>
					<?php get_template_part( 'parts/metadata/comments' ); ?>
				<?php endif; ?>

				<?php if ( $is_show_author && ( $is_show_comments || $is_show_date ) ) : ?>
					<?php get_template_part( 'parts/metadata/divider' ); ?>
				<?php endif; ?>

				<?php if ( $is_show_author ) : ?>
					<?php get_template_part( 'parts/metadata/author', 'blog' ); ?>
				<?php endif; ?>

			</p>

			<?php
		endif;
	}

	/**
	 * Get excerpt length.
	 *
	 * @param int $length Excerpt length.
	 * @return int
	 */
	public function get_excerpt_length( int $length ): int {
		return $this->excerpt_length;
	}

	/**
	 * Print excerpt.
	 *
	 * @param int    $excerpt_words_limit Excerpt words limit.
	 * @param string $classes Additional classes.
	 */
	protected function print_excerpt( int $excerpt_words_limit, string $classes = '' ): void {
		if ( $excerpt_words_limit ) {
			$this->excerpt_length = $excerpt_words_limit;
			add_filter( 'excerpt_length', array( $this, 'get_excerpt_length' ) );
			?>
			<p class="<?php echo esc_attr( $classes ); ?>"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
			<?php
			remove_filter( 'excerpt_length', array( $this, 'get_excerpt_length' ) );
		}
	}
}
