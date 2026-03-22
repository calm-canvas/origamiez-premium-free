<?php
/**
 * Sidebar Left
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'left', 'left' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-left" class="clearfix">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
