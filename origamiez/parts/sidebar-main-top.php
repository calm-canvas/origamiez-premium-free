<?php
/**
 * Sidebar Main Top
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'main-top', 'main-top' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-main-top" class="clearfix widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
