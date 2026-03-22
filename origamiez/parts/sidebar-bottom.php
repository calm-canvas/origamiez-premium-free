<?php
/**
 * Sidebar Bottom
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'bottom', 'bottom' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-bottom" class="widget-area">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
