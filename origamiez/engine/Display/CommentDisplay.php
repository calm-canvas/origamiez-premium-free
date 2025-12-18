<?php
/**
 * Comment Display
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display;

/**
 * Class CommentDisplay
 *
 * @package Origamiez\Engine\Display
 */
class CommentDisplay extends DisplayRenderer {

	/**
	 * Comment.
	 *
	 * @var \WP_Comment
	 */
	private $comment;

	/**
	 * Args.
	 *
	 * @var array
	 */
	private array $args;

	/**
	 * Depth.
	 *
	 * @var int
	 */
	private int $depth;

	/**
	 * CommentDisplay constructor.
	 *
	 * @param \WP_Comment $comment The comment.
	 * @param array       $args The args.
	 * @param integer     $depth The depth.
	 */
	public function __construct( $comment, array $args = array(), int $depth = 1 ) {
		$this->comment = $comment;
		$this->args    = $args;
		$this->depth   = $depth;
	}

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string {
		ob_start();
		?>
		<li <?php comment_class( '', $this->comment ); ?> id="comment-<?php echo esc_attr( $this->comment->comment_ID ); ?>">
			<article class="comment-body clearfix" id="div-comment-<?php echo esc_attr( $this->comment->comment_ID ); ?>">
				<span class="comment-avatar pull-left">
					<?php echo wp_kses_post( get_avatar( $this->comment->comment_author_email, $this->args['avatar_size'] ?? 50 ) ); ?>
				</span>
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<span class="fn"><?php comment_author_link( $this->comment ); ?></span>
					</div>
					<div class="comment-metadata">
						<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>
						<a href="#">
							<?php comment_time( get_option( 'date_format' ) . ' - ' . get_option( 'time_format' ), $this->comment ); ?>
						</a>
						<?php
						comment_reply_link(
							array_merge(
								$this->args,
								array(
									'before'    => '<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>&nbsp;',
									'depth'     => $this->depth,
									'max_depth' => $this->args['max_depth'] ?? 10,
								)
							),
							$this->comment
						);
						?>
						<?php edit_comment_link( esc_attr__( 'Edit', 'origamiez' ), '<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>&nbsp;', '', $this->comment ); ?>
					</div>
				</footer>
				<div class="comment-content">
					<?php comment_text( $this->comment ); ?>
				</div>
			</article>
		</li>
		<?php
		return ob_get_clean();
	}

	/**
	 * Register.
	 *
	 * @return callable
	 */
	public static function register(): callable {
		return static function ( $comment, $args, $depth ) {
			$display = new self( $comment, $args, $depth );
			$display->display();
		};
	}
}
