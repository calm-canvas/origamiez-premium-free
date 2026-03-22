<?php
/**
 * Sidebar Right
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'right', 'right' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<div id="origamiez-sidebar-right" class="origamiez-size-01 origamiez-size-02 pull-right">
		<aside class="sidebar-right-inner clearfix widget-area">
			<?php dynamic_sidebar( $sidebar ); ?>
		</aside>
	</div>
	<?php
endif;
