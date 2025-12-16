<?php

namespace Origamiez\Engine\Display;

use Origamiez\Engine\Config\AllowedTagsConfig;

class CommentFormBuilder {

	private int $postId;

	private array $customArgs;

	public function __construct( int $postId = 0, array $customArgs = array() ) {
		$this->postId     = $postId ?: get_the_ID();
		$this->customArgs = $customArgs;
	}

	private function getCommentFormFields(): array {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = $this->isHtml5Format();

		$fields = array();

		$fields['author']  = '<div class="comment-form-info row clearfix">';
		$fields['author'] .= '<div class="comment-form-field col-sm-4">';
		$fields['author'] .= '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />';
		$fields['author'] .= '<span class="comment-icon fa fa-user"></span>';
		$fields['author'] .= '</div>';

		$fields['email']  = '<div class="comment-form-field col-sm-4">';
		$fields['email'] .= '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />';
		$fields['email'] .= '<span class="comment-icon fa fa-envelope"></span>';
		$fields['email'] .= '</div>';

		$fields['url']  = '<div class="comment-form-field col-sm-4">';
		$fields['url'] .= '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />';
		$fields['url'] .= '<span class="comment-icon fa fa-link"></span>';
		$fields['url'] .= '</div>';
		$fields['url'] .= '</div>';

		return apply_filters( 'comment_form_default_fields', $fields );
	}

	private function getCommentField(): string {
		$comment_field  = '<p class="comment-form-comment">';
		$comment_field .= '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>';
		$comment_field .= '</p>';
		return apply_filters( 'comment_form_field_comment', $comment_field );
	}

	private function getDefaults(): array {
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';
		$commenter     = wp_get_current_commenter();
		$permalink     = apply_filters( 'the_permalink', get_permalink( $this->postId ) );

		return array(
			'fields'               => $this->getCommentFormFields(),
			'comment_field'        => $this->getCommentField(),
			'must_log_in'          => '<p class="must-log-in">' . sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a comment.', 'origamiez' ), wp_login_url( $permalink ) ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( esc_html__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'origamiez' ), get_edit_user_link(), $user_identity, wp_logout_url( $permalink ) ) . '</p>',
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => esc_attr__( 'Leave a Reply', 'origamiez' ),
			'title_reply_to'       => esc_attr__( 'Leave a Reply to %s', 'origamiez' ),
			'cancel_reply_link'    => esc_attr__( 'Cancel reply', 'origamiez' ),
			'label_submit'         => esc_attr__( 'Post Comment', 'origamiez' ),
			'format'               => current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml',
		);
	}

	private function isHtml5Format(): bool {
		$args = wp_parse_args( $this->customArgs );
		return ! isset( $args['format'] ) || 'html5' === $args['format'];
	}

	public function build(): array {
		$defaults = $this->getDefaults();
		return wp_parse_args( $this->customArgs, apply_filters( 'comment_form_defaults', $defaults ) );
	}

	public function render(): string {
		$args = $this->build();

		ob_start();

		if ( comments_open( $this->postId ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div class="comment-respond" id="respond">
				<h2 id="reply-title" class="comment-reply-title widget-title clearfix">
					<?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?>
					<small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small>
				</h2>
				<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
					<?php echo wp_kses( htmlspecialchars_decode( $args['must_log_in'] ), origamiez_get_allowed_tags() ); ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo esc_url( home_url( '/wp-comments-post.php' ) ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form origamiez-widget-content clearfix" <?php echo $this->isHtml5Format() ? ' novalidate' : ''; ?>>
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php
							$logged_in = wp_get_current_user();
							echo wp_kses( htmlspecialchars_decode( apply_filters( 'comment_form_logged_in', $args['logged_in_as'], wp_get_current_commenter(), $logged_in->display_name ) ), origamiez_get_allowed_tags() );
							do_action( 'comment_form_logged_in_after', wp_get_current_commenter(), $logged_in->display_name );
							?>
						<?php else : ?>
							<?php echo wp_kses( $args['comment_notes_before'], origamiez_get_allowed_tags() ); ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo wp_kses( apply_filters( "comment_form_field_{$name}", $field ), origamiez_get_allowed_tags() );
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo wp_kses( $args['comment_field'], origamiez_get_allowed_tags() ); ?>
						<?php echo wp_kses( $args['comment_notes_after'], origamiez_get_allowed_tags() ); ?>
						<p class="form-submit">
							<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>"/>
							<?php comment_id_fields( $this->postId ); ?>
						</p>
						<?php do_action( 'comment_form', $this->postId ); ?>
					</form>
				<?php endif; ?>
			</div>
			<?php
			do_action( 'comment_form_after' );
		else :
			do_action( 'comment_form_comments_closed' );
		endif;

		return ob_get_clean();
	}

	public function display(): void {
		echo $this->render();
	}
}
