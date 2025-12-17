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
class CommentDisplay {

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
		$GLOBALS['comment'] = $this->comment;

		ob_start();
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<article class="comment-body clearfix" id="div-comment-23">
				<span class="comment-avatar pull-left">
					<?php echo wp_kses_post( get_avatar( $this->comment->comment_author_email, $this->args['avatar_size'] ?? 50 ) ); ?>
				</span>
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<span class="fn"><?php comment_author_link(); ?></span>
					</div>
					<div class="comment-metadata">
						<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>
						<a href="#">
							<?php comment_time( get_option( 'date_format' ) . ' - ' . get_option( 'time_format' ) ); ?>
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
							)
						);
						?>
						<?php edit_comment_link( esc_attr__( 'Edit', 'origamiez' ), '<span class="metadata-divider"><?php origamiez_get_metadata_prefix(); ?></span>&nbsp;', '' ); ?>
					</div>
				</footer>
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
			</article>
		</li>
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
