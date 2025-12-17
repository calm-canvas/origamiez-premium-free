<?php
/**
 * Read More Button
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display;

/**
 * Class ReadMoreButton
 *
 * @package Origamiez\Engine\Display
 */
class ReadMoreButton {

	/**
	 * Post id.
	 *
	 * @var int
	 */
	private int $post_id;

	/**
	 * Button text.
	 *
	 * @var string
	 */
	private string $button_text;

	/**
	 * ReadMoreButton constructor.
	 *
	 * @param integer $post_id The post id.
	 * @param string  $button_text The button text.
	 */
	public function __construct( int $post_id = 0, string $button_text = '' ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		if ( ! $button_text ) {
			$button_text = esc_html__( 'Read more &raquo;', 'origamiez' );
		}
		$this->post_id     = $post_id;
		$this->button_text = $button_text;
	}

	/**
	 * Set post id.
	 *
	 * @param int $post_id The post id.
	 *
	 * @return self
	 */
	public function set_post_id( int $post_id ): self {
		$this->post_id = $post_id;
		return $this;
	}

	/**
	 * Set button text.
	 *
	 * @param string $text The text.
	 *
	 * @return self
	 */
	public function set_button_text( string $text ): self {
		$this->button_text = $text;
		return $this;
	}

	/**
	 * Get post permalink.
	 *
	 * @return string
	 */
	public function get_post_permalink(): string {
		return get_permalink( $this->post_id );
	}

	/**
	 * Get post title.
	 *
	 * @return string
	 */
	public function get_post_title(): string {
		return get_the_title( $this->post_id );
	}

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string {
		ob_start();
		?>
		<p class="origamiez-readmore-block">
			<a href="<?php echo esc_url( $this->get_post_permalink() ); ?>" title="<?php echo esc_attr( $this->get_post_title() ); ?>" class="origamiez-readmore-button">
				<?php echo esc_html( $this->button_text ); ?>
			</a>
		</p>
		<?php
		return ob_get_clean();
	}

	/**
	 * Display.
	 *
	 * @return void
	 */
	public function display(): void {
		echo wp_kses_post( $this->render() );
	}
}
