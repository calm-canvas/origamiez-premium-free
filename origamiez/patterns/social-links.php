<?php
/**
 * Title: Social Links
 * Slug: origamiez/social-links
 * Categories: origamiez, sidebar, footer
 * Description: Display social links based on theme customizer settings.
 *
 * @package Origamiez
 */

$socials = origamiez_get_socials();
?>
<div class="origamiez-social-links-pattern">
	<?php if ( ! empty( $socials ) ) : ?>
		<div class="social-link-inner clearfix">
			<?php
			foreach ( $socials as $social_slug => $social ) :
				$url   = get_theme_mod( "{$social_slug}_url", '' );
				$color = get_theme_mod( "{$social_slug}_color", $social['color'] );
				if ( $url ) :
					$style = '';
					if ( $color ) {
						$style = sprintf( 'color:#FFF; background-color:%1$s; border-color: %1$s;', $color );
					}
					if ( 'fa fa-rss' === $social['icon'] && empty( $url ) ) {
						$url = get_bloginfo( 'rss2_url' );
					}
					?>
					<a href="<?php echo esc_url( $url ); ?>"
						data-bs-placement="top"
						data-bs-toggle="tooltip"
						title="<?php echo esc_attr( $social['label'] ); ?>"
						rel="nofollow"
						target="_blank"
						class="social-link social-link-first" style="<?php echo esc_attr( $style ); ?>">
						<span class="<?php echo esc_attr( $social['icon'] ); ?>"></span>
					</a>
					<?php
				endif;
			endforeach;
			?>
		</div>
	<?php endif; ?>
</div>
