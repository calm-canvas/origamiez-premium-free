<?php
/**
 * Sidebar Main Center Top
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'main-center-top', 'main-center-top' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-main-center-top" class="clearfix widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
