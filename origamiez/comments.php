<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both the current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to origamiez_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package origamiez
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area origamiez-widget-content clearfix">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title widget-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( esc_html( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'origamiez' ) ), '<span>' . esc_html( get_the_title() ) . '</span>' );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					esc_html(
						_nx(
							'%1$s thought on &ldquo;%2$s&rdquo;',
							'%1$s thoughts on &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'origamiez'
						)
					),
					esc_html( number_format_i18n( $comments_number ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'origamiez' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'origamiez' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'origamiez' ) ); ?></div>
			</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'callback'    => \Origamiez\Engine\Display\CommentDisplay::register(),
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 34,
				)
			);
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'origamiez' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'origamiez' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'origamiez' ) ); ?></div>
			</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	if ( ! comments_open() && 0 !== get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'origamiez' ); ?></p>
	<?php endif; ?>

	<?php ( new \Origamiez\Engine\Display\CommentFormBuilder() )->display(); ?>

</div>
