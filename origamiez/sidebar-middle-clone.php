<?php
/**
 * The sidebar containing the middle clone widget area.
 *
 * @package Origamiez
 */

if ( ! is_active_sidebar( 'middle-clone' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'middle-clone' ); ?>
</div><!-- #secondary -->
