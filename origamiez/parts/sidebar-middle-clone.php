<?php
/**
 * Sidebar Middle Clone
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'middle-clone', 'middle-clone' );
if ( is_active_sidebar( $sidebar ) ) :
	?>
	<aside id="sidebar-middle-clone" class="origamiez-size-02 pull-left hidden">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
