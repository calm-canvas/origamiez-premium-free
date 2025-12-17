<?php
/**
 * The template part for displaying author info in single posts.
 *
 * @package Origamiez
 */

?>
<div class="author-info">
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
	</div>
	<div class="author-description">
		<h4 class="author-title">
			<?php
			/* translators: %s: Author name. */
			printf( esc_html__( 'About %s', 'origamiez' ), get_the_author() );
			?>
		</h4>
		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php
				/* translators: %s: Author name. */
				printf( esc_html__( 'View all posts by %s', 'origamiez' ), get_the_author() );
				?>
			</a>
		</p>
	</div>
</div>
