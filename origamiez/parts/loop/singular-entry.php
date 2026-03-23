<?php
/**
 * Simple singular entry: title, content, page links, comments (page templates / blog index).
 *
 * @package Origamiez
 *
 * Query var `origamiez_hide_entry_title` (bool): set via set_query_var() before loading this part.
 */

$origamiez_hide_entry_title = (bool) get_query_var( 'origamiez_hide_entry_title', false );
?>
<article id="origamiez-post-wrap" <?php post_class( 'clearfix' ); ?>>
	<h1 class="entry-title"<?php echo $origamiez_hide_entry_title ? ' style="display: none;"' : ''; ?>><?php the_title(); ?></h1>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php origamiez_the_singular_wp_link_pages(); ?>
</article>
<?php comments_template(); ?>
