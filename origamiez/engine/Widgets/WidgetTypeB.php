<?php

namespace Origamiez\Engine\Widgets;

class WidgetTypeB {

	private array $instance = [];

	public function __construct( array $instance = [] ) {
		$this->instance = wp_parse_args( $instance, $this->getDefaults() );
	}

	public static function getDefaults(): array {
		return [
			'excerpt_words_limit' => 0,
			'is_show_author'      => 0,
			'is_show_date'        => 1,
			'is_show_comments'    => 1,
		];
	}

	public function getExcerptWordLimit(): int {
		return (int) ( $this->instance['excerpt_words_limit'] ?? 0 );
	}

	public function isShowAuthor(): bool {
		return (bool) ( $this->instance['is_show_author'] ?? 0 );
	}

	public function isShowDate(): bool {
		return (bool) ( $this->instance['is_show_date'] ?? 1 );
	}

	public function isShowComments(): bool {
		return (bool) ( $this->instance['is_show_comments'] ?? 1 );
	}

	public function getFields(): array {
		return [
			'excerpt_words_limit' => [
				'label'   => esc_html__( 'Excerpt words limit:', 'origamiez' ),
				'type'    => 'select',
				'options' => [ 0 => '0', 10 => '10', 15 => '15', 20 => '20', 30 => '30', 60 => '60' ],
			],
			'is_show_author'      => [
				'label' => esc_html__( 'Is show author ?', 'origamiez' ),
				'type'  => 'checkbox',
			],
			'is_show_date'        => [
				'label' => esc_html__( 'Is show date ?', 'origamiez' ),
				'type'  => 'checkbox',
			],
			'is_show_comments'    => [
				'label' => esc_html__( 'Is show comments ?', 'origamiez' ),
				'type'  => 'checkbox',
			],
		];
	}

	public function renderMetadata( string $classes = '' ): void {
		if ( ! $this->isShowDate() && ! $this->isShowComments() && ! $this->isShowAuthor() ) {
			return;
		}

		?>
		<p class="<?php echo esc_attr( $classes ); ?>">
			<?php if ( $this->isShowDate() ) : ?>
				<?php get_template_part( 'parts/metadata/date' ); ?>
			<?php endif; ?>

			<?php if ( $this->isShowDate() && $this->isShowComments() ) : ?>
				<?php get_template_part( 'parts/metadata/divider' ); ?>
			<?php endif; ?>

			<?php if ( $this->isShowComments() ) : ?>
				<?php get_template_part( 'parts/metadata/comments' ); ?>
			<?php endif; ?>

			<?php if ( $this->isShowAuthor() && ( $this->isShowComments() || $this->isShowDate() ) ) : ?>
				<?php get_template_part( 'parts/metadata/divider' ); ?>
			<?php endif; ?>

			<?php if ( $this->isShowAuthor() ) : ?>
				<?php get_template_part( 'parts/metadata/author', 'blog' ); ?>
			<?php endif; ?>
		</p>
		<?php
	}

	public function renderExcerpt( string $classes = '' ): void {
		$limit = $this->getExcerptWordLimit();
		if ( ! $limit ) {
			return;
		}

		add_filter( 'excerpt_length', "origamiez_return_{$limit}" );
		?>
		<p class="<?php echo esc_attr( $classes ); ?>"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
		<?php
		remove_filter( 'excerpt_length', "origamiez_return_{$limit}" );
	}
}
