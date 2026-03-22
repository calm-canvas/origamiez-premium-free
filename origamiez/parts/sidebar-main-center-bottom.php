<?php
/**
 * Sidebar Main Center Bottom
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'main-center-bottom', 'main-center-bottom' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-main-center-bottom" class="clearfix widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
