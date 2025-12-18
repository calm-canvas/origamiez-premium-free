<?php
/**
 * Widget Type B
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

/**
 * Class WidgetTypeB
 */
class WidgetTypeB {

	/**
	 * Instance.
	 *
	 * @var array
	 */
	private array $instance = array();

	/**
	 * WidgetTypeB constructor.
	 *
	 * @param array $instance Widget instance.
	 */
	public function __construct( array $instance = array() ) {
		$this->instance = wp_parse_args( $instance, $this->get_defaults() );
	}

	/**
	 * Get defaults.
	 *
	 * @return array
	 */
	public static function get_defaults(): array {
		return array(
			'excerpt_words_limit' => 0,
			'is_show_author'      => 0,
			'is_show_date'        => 1,
			'is_show_comments'    => 1,
		);
	}

	/**
	 * Get excerpt word limit.
	 *
	 * @return int
	 */
	public function get_excerpt_word_limit(): int {
		return (int) ( $this->instance['excerpt_words_limit'] ?? 0 );
	}

	/**
	 * Is show author.
	 *
	 * @return bool
	 */
	public function is_show_author(): bool {
		return (bool) ( $this->instance['is_show_author'] ?? 0 );
	}

	/**
	 * Is show date.
	 *
	 * @return bool
	 */
	public function is_show_date(): bool {
		return (bool) ( $this->instance['is_show_date'] ?? 1 );
	}

	/**
	 * Is show comments.
	 *
	 * @return bool
	 */
	public function is_show_comments(): bool {
		return (bool) ( $this->instance['is_show_comments'] ?? 1 );
	}

	/**
	 * Get fields.
	 *
	 * @return array
	 */
	public function get_fields(): array {
		return array(
			'excerpt_words_limit' => array(
				'label'   => esc_html__( 'Excerpt words limit:', 'origamiez' ),
				'type'    => 'select',
				'options' => array(
					0  => '0',
					10 => '10',
					15 => '15',
					20 => '20',
					30 => '30',
					60 => '60',
				),
			),
			'is_show_author'      => array(
				'label' => esc_html__( 'Is show author ?', 'origamiez' ),
				'type'  => 'checkbox',
			),
			'is_show_date'        => array(
				'label' => esc_html__( 'Is show date ?', 'origamiez' ),
				'type'  => 'checkbox',
			),
			'is_show_comments'    => array(
				'label' => esc_html__( 'Is show comments ?', 'origamiez' ),
				'type'  => 'checkbox',
			),
		);
	}

	/**
	 * Render metadata.
	 *
	 * @param string $classes Additional classes.
	 */
	public function render_metadata( string $classes = '' ): void {
		if ( ! $this->is_show_date() && ! $this->is_show_comments() && ! $this->is_show_author() ) {
			return;
		}

		?>
		<p class="<?php echo esc_attr( $classes ); ?>">
			<?php if ( $this->is_show_date() ) : ?>
				<?php get_template_part( 'parts/metadata/date' ); ?>
			<?php endif; ?>

			<?php if ( $this->is_show_date() && $this->is_show_comments() ) : ?>
				<?php get_template_part( 'parts/metadata/divider' ); ?>
			<?php endif; ?>

			<?php if ( $this->is_show_comments() ) : ?>
				<?php get_template_part( 'parts/metadata/comments' ); ?>
			<?php endif; ?>

			<?php if ( $this->is_show_author() && ( $this->is_show_comments() || $this->is_show_date() ) ) : ?>
				<?php get_template_part( 'parts/metadata/divider' ); ?>
			<?php endif; ?>

			<?php if ( $this->is_show_author() ) : ?>
				<?php get_template_part( 'parts/metadata/author', 'blog' ); ?>
			<?php endif; ?>
		</p>
		<?php
	}

	/**
	 * Render excerpt.
	 *
	 * @param string $classes Additional classes.
	 */
	public function render_excerpt( string $classes = '' ): void {
		$limit = $this->get_excerpt_word_limit();
		if ( ! $limit ) {
			return;
		}

		$callback = origamiez_get_value_callback( $limit );
		add_filter( 'excerpt_length', $callback );
		?>
		<p class="<?php echo esc_attr( $classes ); ?>"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
		<?php
		remove_filter( 'excerpt_length', $callback );
	}
}
