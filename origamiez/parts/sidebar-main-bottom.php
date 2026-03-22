<?php
/**
 * Sidebar Main Bottom
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'main-bottom', 'main-bottom' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-main-bottom" class="clearfix widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
