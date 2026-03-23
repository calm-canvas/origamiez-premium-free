<?php
/**
 * Header Shop
 *
 * @package Origamiez
 */

get_template_part( 'parts/header/header', 'site-shell' );
?>
	<div id="origamiez-body"
		class="<?php \Origamiez\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
		<div id="origamiez-body-inner" class="clearfix">
			<div id="sidebar-center" class="pull-left">
				<?php get_template_part( 'parts/breadcrumb', 'woocommerce' ); ?>
				<div class="clearfix"></div>
				<div id="sidebar-center-bottom" class="clearfix">
