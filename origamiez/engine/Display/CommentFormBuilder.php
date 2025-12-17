<?php
/**
 * Comment Form Builder
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Display;

use Origamiez\Engine\Config\AllowedTagsConfig;

/**
 * Class CommentFormBuilder
 *
 * @package Origamiez\Engine\Display
 */
class CommentFormBuilder {

	/**
	 * Post id.
	 *
	 * @var int
	 */
	private int $post_id;

	/**
	 * Custom args.
	 *
	 * @var array
	 */
	private array $custom_args;

	/**
	 * CommentFormBuilder constructor.
	 *
	 * @param integer $post_id The post id.
	 * @param array   $custom_args The custom args.
	 */
	public function __construct( int $post_id = 0, array $custom_args = array() ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		$this->post_id     = $post_id;
		$this->custom_args = $custom_args;
	}

	/**
	 * Get comment form fields.
	 *
	 * @return array
	 */
	private function get_comment_form_fields(): array {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = $this->is_html5_format();

		$fields = array(
			'author' => '<div class="comment-form-info row clearfix">' .
						'<div class="comment-form-field col-sm-4">' .
						'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
						'<span class="comment-icon fa fa-user"></span>' .
						'</div>',
			'email'  => '<div class="comment-form-field col-sm-4">' .
						'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
						'<span class="comment-icon fa fa-envelope"></span>' .
						'</div>',
			'url'    => '<div class="comment-form-field col-sm-4">' .
						'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />' .
						'<span class="comment-icon fa fa-link"></span>' .
						'</div>' .
						'</div>',
		);

		return apply_filters( 'comment_form_default_fields', $fields );
	}

	/**
	 * Get comment field.
	 *
	 * @return string
	 */
	private function get_comment_field(): string {
		$comment_field = '<p class="comment-form-comment">' .
						'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
						'</p>';
		return apply_filters( 'comment_form_field_comment', $comment_field );
	}

	/**
	 * Get defaults.
	 *
	 * @return array
	 */
	private function get_defaults(): array {
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';
		$permalink     = apply_filters( 'the_permalink', get_permalink( $this->post_id ) );

		return array(
			'fields'               => $this->get_comment_form_fields(),
			'comment_field'        => $this->get_comment_field(),
			// translators: %s is the login URL.
			'must_log_in'          => '<p class="must-log-in">' . sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a comment.', 'origamiez' ), wp_login_url( $permalink ) ) . '</p>',
			// translators: %1$s is the user profile link, %2$s is the user display name, %3$s is the logout URL.
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( esc_html__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'origamiez' ), get_edit_user_link(), $user_identity, wp_logout_url( $permalink ) ) . '</p>',
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => esc_attr__( 'Leave a Reply', 'origamiez' ),
			// translators: %s is the author name.
			'title_reply_to'       => esc_attr__( 'Leave a Reply to %s', 'origamiez' ),
			'cancel_reply_link'    => esc_attr__( 'Cancel reply', 'origamiez' ),
			'label_submit'         => esc_attr__( 'Post Comment', 'origamiez' ),
			'format'               => current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml',
		);
	}

	/**
	 * Is html5 format.
	 *
	 * @return boolean
	 */
	private function is_html5_format(): bool {
		$args = wp_parse_args( $this->custom_args );
		return ! isset( $args['format'] ) || 'html5' === $args['format'];
	}

	/**
	 * Build.
	 *
	 * @return array
	 */
	public function build(): array {
		$defaults = $this->get_defaults();
		return wp_parse_args( $this->custom_args, apply_filters( 'comment_form_defaults', $defaults ) );
	}

	/**
	 * Render the comment form title.
	 *
	 * @param array $args The comment form arguments.
	 */
	private function render_comment_form_title( array $args ): void {
		?>
		<h2 id="reply-title" class="comment-reply-title widget-title clearfix">
			<?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?>
			<small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small>
		</h2>
		<?php
	}

	/**
	 * Render the comment form fields.
	 *
	 * @param array $args The comment form arguments.
	 */
	private function render_comment_form_fields( array $args ): void {
		do_action( 'comment_form_before_fields' );
		foreach ( (array) $args['fields'] as $name => $field ) {
			echo wp_kses( apply_filters( "comment_form_field_{$name}", $field ), AllowedTagsConfig::get_allowed_tags() );
		}
		do_action( 'comment_form_after_fields' );
	}

	/**
	 * Render the comment form body.
	 *
	 * @param array $args The comment form arguments.
	 */
	private function render_comment_form_body( array $args ): void {
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
			echo wp_kses( $args['must_log_in'], AllowedTagsConfig::get_allowed_tags() );
			do_action( 'comment_form_must_log_in_after' );
		} else {
			?>
			<form action="<?php echo esc_url( home_url( '/wp-comments-post.php' ) ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form origamiez-widget-content clearfix" <?php echo $this->is_html5_format() ? ' novalidate' : ''; ?>>
				<?php
				do_action( 'comment_form_top' );
				if ( is_user_logged_in() ) {
					$logged_in = wp_get_current_user();
					echo wp_kses( apply_filters( 'comment_form_logged_in', $args['logged_in_as'], wp_get_current_commenter(), $logged_in->display_name ), AllowedTagsConfig::get_allowed_tags() );
					do_action( 'comment_form_logged_in_after', wp_get_current_commenter(), $logged_in->display_name );
				} else {
					echo wp_kses( $args['comment_notes_before'], AllowedTagsConfig::get_allowed_tags() );
					$this->render_comment_form_fields( $args );
				}
				echo wp_kses( $args['comment_field'], AllowedTagsConfig::get_allowed_tags() );
				echo wp_kses( $args['comment_notes_after'], AllowedTags_config::get_allowed_tags() );
				?>
				<p class="form-submit">
					<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>"/>
					<?php comment_id_fields( $this->post_id ); ?>
				</p>
				<?php do_action( 'comment_form', $this->post_id ); ?>
			</form>
			<?php
		}
	}

	/**
	 * Render.
	 *
	 * @return string
	 */
	public function render(): string {
		$args = $this->build();

		ob_start();

		if ( comments_open( $this->post_id ) ) {
			do_action( 'comment_form_before' );
			?>
			<div class="comment-respond" id="respond">
				<?php
				$this->render_comment_form_title( $args );
				$this->render_comment_form_body( $args );
				?>
			</div>
			<?php
			do_action( 'comment_form_after' );
		} else {
			do_action( 'comment_form_comments_closed' );
		}

		return ob_get_clean();
	}

	/**
	 * Display.
	 *
	 * @return void
	 */
	public function display(): void {
		wp_kses_post( $this->render() );
	}
}
