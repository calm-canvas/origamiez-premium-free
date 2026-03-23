<?php
/**
 * Bottom footer bar, closing footer/body wrappers, wp_footer, and closing body/html.
 *
 * Shared by footer-1 … footer-5 and footer-shop.
 *
 * @package Origamiez
 */

?>
	<div id="origamiez-footer-end" class="clearfix">
		<div class="<?php \Origamiez\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
			<?php get_template_part( 'parts/menu', 'bottom' ); ?>
			<?php get_template_part( 'parts/copyright' ); ?>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
<?php do_action( 'origamiez_before_body_close' ); ?>
</body>
</html>
