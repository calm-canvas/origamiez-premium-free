<?php
/**
 * Author Display
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display;

/**
 * Class AuthorDisplay
 *
 * @package Origamiez\Engine\Display
 */
class AuthorDisplay {

	/**
	 * User id.
	 *
	 * @var ?int
	 */
	private ?int $user_id = null;

	/**
	 * AuthorDisplay constructor.
	 *
	 * @param ?int $user_id The user id.
	 */
	public function __construct( ?int $user_id = null ) {
		$this->user_id = $user_id;
	}

	/**
	 * Ensure user id.
	 *
	 * @return void
	 */
	private function ensure_user_id(): void {
		if ( null === $this->user_id ) {
			global $post;
			if ( $post ) {
				$this->user_id = (int) $post->post_author;
			} else {
				$this->user_id = 0;
			}
		}
	}

	/**
	 * Set user id.
	 *
	 * @param int $user_id The user id.
	 *
	 * @return self
	 */
	public function set_user_id( int $user_id ): self {
		$this->user_id = $user_id;
		return $this;
	}

	/**
	 * Get author description.
	 *
	 * @return string
	 */
	public function get_author_description(): string {
		$this->ensure_user_id();
		return get_the_author_meta( 'description', $this->user_id );
	}

	/**
	 * Get author email.
	 *
	 * @return string
	 */
	public function get_author_email(): string {
		$this->ensure_user_id();
		return get_the_author_meta( 'user_email', $this->user_id );
	}

	/**
	 * Get author name.
	 *
	 * @return string
	 */
	public function get_author_name(): string {
		$this->ensure_user_id();
		return get_the_author_meta( 'display_name', $this->user_id );
	}

	/**
	 * Get author url.
	 *
	 * @return string
	 */
	public function get_author_url(): string {
		$this->ensure_user_id();
		$url = trim( get_the_author_meta( 'user_url', $this->user_id ) );
		return ! $url ? get_author_posts_url( $this->user_id ) : $url;
	}

	/**
	 * Get author avatar.
	 *
	 * @param integer $size The size.
	 *
	 * @return string
	 */
	public function get_author_avatar( int $size = 90 ): string {
		$email = $this->get_author_email();
		return get_avatar( $email, $size );
	}

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string {
		$description = $this->get_author_description();
		$name        = $this->get_author_name();
		$link        = $this->get_author_url();
		$avatar      = $this->get_author_avatar( 90 );

		ob_start();
		?>
		<div id="origamiez-post-author">
			<div class="origamiez-author-info clearfix">
				<a href="<?php echo esc_url( $link ); ?>" class="origamiez-author-avatar">
					<?php echo wp_kses( $avatar, origamiez_get_allowed_tags() ); ?>
				</a>
				<div class="origamiez-author-detail">
					<p class="origamiez-author-name">
						<?php esc_html_e( 'Author:', 'origamiez' ); ?>&nbsp;
						<a href="<?php echo esc_url( $link ); ?>">
							<?php echo esc_html( $name ); ?>
						</a>
					</p>
					<p class="origamiez-author-bio">
						<?php echo wp_kses( $description, origamiez_get_allowed_tags() ); ?>
					</p>
				</div>
			</div>
		</div>
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
