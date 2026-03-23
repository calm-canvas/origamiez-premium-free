<?php
/**
 * Footer Shop
 *
 * @package Origamiez
 */

?>
</div>
</div>
<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'right' ); ?>
<div class="clearfix"></div>
<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'bottom' ); ?>
<div class="clearfix"></div>
</div> <!-- end #origamiez-body > container > #origamiez-boby-inner -->
</div> <!-- end #origamiez-body-->
<footer id="origamiez-footer" class="clearfix">
	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) ) : ?>
		<div id="origamiez-footer-sidebars" class="clearfix">
			<div id="origamiez-footer-sidebars-inner" class="<?php \Origamiez\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
				<div class="row clearfix">
					<aside id="origamiez-footer-right" class="col-md-8 col-sm-12 col-xs-12 widget-area">
						<div class="row clearfix">
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'footer-1' ); ?>
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'footer-2' ); ?>
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'footer-3' ); ?>
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'footer-4' ); ?>
						</div>
					</aside>
					<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'footer-5' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php get_template_part( 'parts/footer/footer-markup-end' ); ?>
