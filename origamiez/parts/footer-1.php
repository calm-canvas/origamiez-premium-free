<?php
/**
 * Footer 1
 *
 * @package Origamiez
 */

?>
</div> <!-- end #origamiez-body > container > #origamiez-boby-inner -->
</div> <!-- end #origamiez-body-->
<footer id="origamiez-footer" class="clearfix">
	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) ) : ?>
		<div id="origamiez-footer-sidebars" class="clearfix">
			<div id="origamiez-footer-sidebars-inner" class="<?php \Origamiez\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
				<div class="row clearfix">
					<aside id="origamiez-footer-right" class="col-md-12 col-sm-12 col-xs-12 widget-area">
						<div class="row clearfix">
							<?php add_filter( 'origamiez_get_footer_classes', 'origamiez_set_classes_for_footer_one_cols' ); ?>
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'footer-1' ); ?>
							<?php remove_filter( 'origamiez_get_footer_classes', 'origamiez_set_classes_for_footer_one_cols' ); ?>
						</div>
					</aside>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php get_template_part( 'parts/footer/footer-markup-end' ); ?>
