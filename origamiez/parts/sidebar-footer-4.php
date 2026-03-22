<?php
/**
 * Sidebar Footer 4
 *
 * @package Origamiez
 */

$sidebar = apply_filters( 'origamiez_get_current_sidebar', 'footer-4', 'footer-4' );
if ( is_active_sidebar( $sidebar ) ) :
	$classes = apply_filters(
		'origamiez_get_footer_classes',
		array(
			'col-xs-12',
			'col-sm-6',
			'col-md-3',
		),
		'footer-3'
	);
	?>
	<aside id="origamiez-footer-4" class="widget-area <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside>
	<?php
endif;
