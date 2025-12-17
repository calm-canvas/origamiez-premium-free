<?php
/**
 * The sidebar containing the right widget area.
 *
 * @package Origamiez
 */

if ( ! is_active_sidebar( 'right' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'right' ); ?>
</div><!-- #secondary -->
