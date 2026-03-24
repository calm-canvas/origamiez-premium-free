<?php
/**
 * Posts List Media Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Widgets\Types;

use Origamiez\Widgets\AbstractPostsListTypeCWidget;
use WP_Query;

/**
 * Class PostsListMediaWidget
 */
class PostsListMediaWidget extends AbstractPostsListTypeCWidget {

	/**
	 * Widget id, labels, and body class for WP_Widget.
	 *
	 * @return array{id_base: string, title: string, classname: string, description: string}
	 */
	protected static function widget_registration_config(): array {
		return static::make_widget_registration(
			'origamiez-widget-post-list-media',
			esc_attr__( 'Origamiez Posts List With Format Icon', 'origamiez' ),
			'origamiez-widget-posts-with-format-icon',
			esc_attr__( 'Display posts list with icon of post-format.', 'origamiez' )
		);
	}

	/**
	 * Print the posts markup for this widget layout.
	 *
	 * @param WP_Query $posts    Posts query.
	 * @param array    $instance Parsed instance.
	 */
	protected function render_posts_list_markup( WP_Query $posts, array $instance ): void {
		$d = $this->get_post_list_display_vars( $instance );

		$is_true = true;
		while ( $posts->have_posts() ) :
			$posts->the_post();
			$post_id     = get_the_ID();
			$post_title  = get_the_title();
			$post_url    = get_permalink();
			$post_format = get_post_format();
			$classes     = array( 'origamiez-w-m-post', 'clearfix' );
			if ( $is_true ) {
				$classes[] = 'origamiez-w-m-post-first';
				$is_true   = false;
			}
			?>
			<div <?php post_class( $classes ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<?php
					$lightbox_markup = apply_filters(
						'origamiez_get_lightbox_markup',
						array(
							'before' => '',
							'after'  => '',
							'url'    => $post_url,
							'atts'   => array(),
						),
						$post_id
					);
					echo wp_kses( $lightbox_markup['before'], origamiez_get_allowed_tags() );
					?>
					<a href="<?php echo esc_url( $lightbox_markup['url'] ); ?>"
						title="<?php echo esc_attr( $post_title ); ?>"
						class="link-hover-effect origamiez-w-m-post-thumb clearfix" <?php echo esc_attr( implode( ' ', $lightbox_markup['atts'] ) ); ?>>
						<?php the_post_thumbnail( 'origamiez-square-md', array( 'class' => 'image-effect img-responsive' ) ); ?>
						<span><span class="metadata-post-format metadata-circle-icon"><span
										class="<?php echo esc_attr( origamiez_get_format_icon( $post_format ) ); ?>"></span></span></span>
					</a>
					<?php echo wp_kses( $lightbox_markup['after'], origamiez_get_allowed_tags() ); ?>
				<?php endif; ?>
				<h4 class="entry-title"><a href="<?php echo esc_url( $post_url ); ?>"
											title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_html( $post_title ); ?></a>
				</h4>
				<?php $this->print_metadata( $d['is_show_date'], $d['is_show_comments'], $d['is_show_author'], 'metadata' ); ?>
				<?php $this->print_excerpt( $d['excerpt_words_limit'], 'entry-excerpt clearfix' ); ?>
			</div>
			<?php
		endwhile;
	}
}
