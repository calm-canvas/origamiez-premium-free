<?php
/**
 * Header branding: logo and optional top banner.
 *
 * @package Origamiez
 *
 * @var array $args {
 *     Optional. Layout classes.
 *
 *     @type string $header_top_class     Class for #origamiez-header-top.
 *     @type string $logo_wrapper_class   Class for #origamiez-logo.
 *     @type string $banner_wrapper_class Class for #origamiez-top-banner.
 * }
 */

$defaults = array(
	'header_top_class'     => 'origamiez-header-left-right',
	'logo_wrapper_class'   => 'pull-left',
	'banner_wrapper_class' => 'pull-right',
);
$args     = wp_parse_args( isset( $args ) ? $args : array(), $defaults );
?>
<div id="origamiez-header-top" class="<?php echo esc_attr( $args['header_top_class'] ); ?>">
	<div class="<?php \Origamiez\Helpers\LayoutHelper::get_wrap_classes(); ?> clearfix">
		<?php $logo = get_theme_mod( 'logo', false ); ?>
		<div id="origamiez-logo" class="<?php echo esc_attr( $args['logo_wrapper_class'] ); ?>">
			<a id="site-home-link" href="<?php echo esc_url( home_url() ); ?>"
				title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>">
				<?php if ( $logo ) : ?>
					<img id="site-logo" class="img-responsive" src="<?php echo esc_url( $logo ); ?>"
						alt="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>">
				<?php else : ?>
					<?php if ( is_front_page() || is_home() ) : ?>
						<h1 id="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
					<?php else : ?>
						<p class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
					<?php endif; ?>
					<p id="site-desc">
						<?php echo esc_textarea( get_bloginfo( 'description' ) ); ?>
					</p>
				<?php endif; ?>
			</a>
		</div> <!-- end: logo -->
		<?php
		$top_banner_image  = get_header_image();
		$top_banner_custom = get_theme_mod( 'top_banner_custom', false );
		if ( $top_banner_image || $top_banner_custom ) :
			$target = ( 1 === (int) get_theme_mod( 'top_banner_target', 0 ) ) ? 'target="_blank"' : '';
			?>
			<div id="origamiez-top-banner" class="<?php echo esc_attr( $args['banner_wrapper_class'] ); ?>">
				<?php
				if ( $top_banner_custom ) :
					echo wp_kses( $top_banner_custom, origamiez_get_allowed_tags() );
				else :
					?>
					<a href="<?php echo esc_url( get_theme_mod( 'top_banner_url', false ) ); ?>"
						title="<?php echo esc_attr( get_theme_mod( 'top_banner_title', false ) ); ?>"
						<?php echo esc_attr( $target ); ?> rel="nofollow">
						<img width="<?php echo esc_attr( get_custom_header()->width ); ?>"
							height="<?php echo esc_attr( get_custom_header()->height ); ?>"
							src="<?php echo esc_url( $top_banner_image ); ?>"
							alt="<?php echo esc_attr( get_theme_mod( 'top_banner_title', false ) ); ?>">
					</a>
				<?php endif; ?>
			</div> <!-- end: top-banner -->
		<?php endif; ?>
	</div>
</div>
