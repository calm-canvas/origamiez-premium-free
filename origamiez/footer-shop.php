<?php
/**
 * The template for displaying the footer for shop pages.
 *
 * @package Origamiez
 */

?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'origamiez' ) ); ?>">
				<?php
				/* translators: %s: CMS name. */
				printf( esc_html__( 'Proudly powered by %s', 'origamiez' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
			<?php
			/* translators: %1$s: Theme name, %2$s: Theme author. */
			printf( esc_html__( 'Theme: %1$s by %2$s.', 'origamiez' ), 'origamiez', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' );
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
