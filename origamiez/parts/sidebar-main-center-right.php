<?php
/**
 * Sidebar Main Center Right
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'main-center-right', 'main-center-right' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-main-center-right" class="clearfix widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
