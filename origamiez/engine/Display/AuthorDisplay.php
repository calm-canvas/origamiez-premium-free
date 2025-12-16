<?php

namespace Origamiez\Engine\Display;

class AuthorDisplay {

	private ?int $userId = null;

	public function __construct( ?int $userId = null ) {
		$this->userId = $userId;
	}

	private function ensureUserId(): void {
		if ( $this->userId === null ) {
			global $post;
			if ( $post ) {
				$this->userId = (int) $post->post_author;
			} else {
				$this->userId = 0;
			}
		}
	}

	public function setUserId( int $userId ): self {
		$this->userId = $userId;
		return $this;
	}

	public function getAuthorDescription(): string {
		$this->ensureUserId();
		return get_the_author_meta( 'description', $this->userId );
	}

	public function getAuthorEmail(): string {
		$this->ensureUserId();
		return get_the_author_meta( 'user_email', $this->userId );
	}

	public function getAuthorName(): string {
		$this->ensureUserId();
		return get_the_author_meta( 'display_name', $this->userId );
	}

	public function getAuthorUrl(): string {
		$this->ensureUserId();
		$url = trim( get_the_author_meta( 'user_url', $this->userId ) );
		return ! $url ? get_author_posts_url( $this->userId ) : $url;
	}

	public function getAuthorAvatar( int $size = 90 ): string {
		$email = $this->getAuthorEmail();
		return get_avatar( $email, $size );
	}

	public function render(): string {
		$description = $this->getAuthorDescription();
		$name         = $this->getAuthorName();
		$link         = $this->getAuthorUrl();
		$avatar       = $this->getAuthorAvatar( 90 );

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

	public function display(): void {
		echo wp_kses_post( $this->render() );
	}
}
