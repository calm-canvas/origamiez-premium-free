<?php
/**
 * Posts List Two Cols Widget
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets\Types;

use Origamiez\Engine\Widgets\AbstractPostsWidgetTypeC;
use WP_Query;

/**
 * Class PostsListTwoColsWidget
 */
class PostsListTwoColsWidget extends AbstractPostsWidgetTypeC {
	/**
	 * Register widget.
	 */
	public static function register(): void {
		register_widget( __CLASS__ );
	}

	/**
	 * PostsListTwoColsWidget constructor.
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'origamiez-widget-posts-two-cols',
			'description' => esc_attr__( 'Display posts list with layout two cols.', 'origamiez' ),
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto',
		);
		parent::__construct( 'origamiez-widget-posts-two-cols', esc_attr__( 'Origamiez Posts List Two Cols', 'origamiez' ), $widget_ops, $control_ops );
	}

	/**
	 * Render widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ): void {
		$before_widget = $args['before_widget'];
		$after_widget  = $args['after_widget'];
		$before_title  = $args['before_title'];
		$after_title   = $args['after_title'];

		$instance            = wp_parse_args( (array) $instance, $this->get_default() );
		$is_show_date        = $instance['is_show_date'];
		$is_show_comments    = $instance['is_show_comments'];
		$is_show_author      = $instance['is_show_author'];
		$excerpt_words_limit = $instance['excerpt_words_limit'];

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo wp_kses( $before_widget, origamiez_get_allowed_tags() );
		if ( ! empty( $title ) ) {
			echo wp_kses( $before_title . $title . $after_title, origamiez_get_allowed_tags() );
		}

		$query = $this->get_query( $instance );
		$posts = new WP_Query( $query );
		if ( $posts->have_posts() ) :
			?>
			<div class="row">
				<div class="article-col-left col-sm-6 col-xs-12">
					<?php
					$loop_index = 0;
					while ( $posts->have_posts() ) :
						$posts->the_post();
						$post_title   = get_the_title();
						$post_url     = get_permalink();
						$post_classes = "origamiez-post-{$loop_index} clearfix";
						if ( 0 === $loop_index ) :
							?>
							<article <?php post_class( $post_classes ); ?>>
								<?php if ( has_post_thumbnail() ) : ?>
									<a class="link-hover-effect origamiez-post-thumb" href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'origamiez-square-m', array( 'class' => 'image-effect img-responsive' ) ); ?>
									</a>
								<?php endif; ?>
								<?php parent::print_metadata( $is_show_date, $is_show_comments, $is_show_author, 'metadata clearfix' ); ?>
								<h3>
									<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>"
										title="<?php echo esc_attr( $post_title ); ?>">
										<?php echo esc_attr( $post_title ); ?>
									</a>
								</h3>
								<?php parent::print_excerpt( $excerpt_words_limit, 'entry-excerpt clearfix' ); ?>
							</article>
							<?php
							echo '</div>';
							echo '<div class="article-col-right col-sm-6 col-xs-12">';
						else :
							?>
							<article <?php post_class( $post_classes ); ?>>
								<?php parent::print_metadata( $is_show_date, $is_show_comments, $is_show_author, 'metadata clearfix' ); ?>
								<h4>
									<a class="entry-title" href="<?php echo esc_url( $post_url ); ?>"
										title="<?php echo esc_attr( $post_title ); ?>">
										<?php echo esc_attr( $post_title ); ?>
									</a>
								</h4>
							</article>
							<?php
						endif;
						++$loop_index;
					endwhile;
					?>
				</div>
			</div>
			<?php
		endif;
		wp_reset_postdata();
		echo wp_kses( $after_widget, origamiez_get_allowed_tags() );
	}
}
