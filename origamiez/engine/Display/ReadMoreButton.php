<?php

namespace Origamiez\Engine\Display;

class ReadMoreButton {

	private int $postId;

	private string $buttonText;

	public function __construct( int $postId = 0, string $buttonText = '' ) {
		$this->postId    = $postId ?: get_the_ID();
		$this->buttonText = $buttonText ?: esc_html__( 'Read more &raquo;', 'origamiez' );
	}

	public function setPostId( int $postId ): self {
		$this->postId = $postId;
		return $this;
	}

	public function setButtonText( string $text ): self {
		$this->buttonText = $text;
		return $this;
	}

	public function getPostPermalink(): string {
		return get_permalink( $this->postId );
	}

	public function getPostTitle(): string {
		return get_the_title( $this->postId );
	}

	public function render(): string {
		ob_start();
		?>
		<p class="origamiez-readmore-block">
			<a href="<?php echo esc_url( $this->getPostPermalink() ); ?>" title="<?php echo esc_attr( $this->getPostTitle() ); ?>" class="origamiez-readmore-button">
				<?php echo esc_html( $this->buttonText ); ?>
			</a>
		</p>
		<?php
		return ob_get_clean();
	}

	public function display(): void {
		echo wp_kses_post( $this->render() );
	}
}
