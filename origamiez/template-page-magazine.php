<?php
/**
 * Template Page Magazine
 *
 * @package Origamiez
 */

/*
 * Template Name: Page Magazine
 */
get_header();
?>
	<div class="d-flex">
		<div id="sidebar-center" class="pull-left origamiez-size-01">
			<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'main-top' ); ?>
			<div id="main-center-outer" class="row clearfix">
				<div class="origamiez-right origamiez-size-03 col-sm-9 col-xs-12 pull-right">
					<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'main-center-top' ); ?>
					<div id="main-center-inner" id="main-center" class="row clearfix">
						<div class="origamiez-left origamiez-size-04 col-sm-6 col-xs-12">
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'main-center-left' ); ?>
						</div>
						<div class="origamiez-right origamiez-size-04 col-sm-6 col-xs-12">
							<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'main-center-right' ); ?>
						</div>
					</div>
					<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'main-center-bottom' ); ?>
				</div>
				<div class="origamiez-left origamiez-size-03  origamiez-size-03 col-sm-3 col-xs-12 pull-left">
					<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'left' ); ?>
				</div>
			</div>
			<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'main-bottom' ); ?>
		</div>
		<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'right' ); ?>
	</div>
	<div class="clearfix"></div>
<?php get_template_part( ORIGAMIEZ_PART_SIDEBAR_SLUG, 'bottom' ); ?>
	<div class="clearfix"></div>
<?php

get_footer();
