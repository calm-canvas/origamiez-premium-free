<?php
/**
 * Sidebar Middle
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'middle', 'middle' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-middle" class="origamiez-size-01 pull-left">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
