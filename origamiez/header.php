<?php
/**
 * Header
 *
 * @package Origamiez
 */

get_template_part( 'parts/header/header', 'site-shell' );
?>
	<div id="origamiez-body" class="<?php \Origamiez\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
		<div id="origamiez-body-inner" class="clearfix">
<?php do_action( 'origamiez_after_body_inner_open' ); ?>
