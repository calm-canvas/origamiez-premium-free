<?php
/**
 * Sidebar Main Center Left
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'main-center-left', 'main-center-left' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-main-center-left" class="clearfix widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
