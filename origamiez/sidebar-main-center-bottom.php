<?php
/**
 * The sidebar containing the main center bottom widget area.
 *
 * @package Origamiez
 */

if ( ! is_active_sidebar( 'main-center-bottom' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'main-center-bottom' ); ?>
</div><!-- #secondary -->
