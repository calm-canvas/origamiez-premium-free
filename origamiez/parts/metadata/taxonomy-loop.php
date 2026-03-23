<?php
/**
 * Metadata row for taxonomy/archive-style loops (author, date, comments, category).
 *
 * @package Origamiez
 */

?>
<p class="metadata">
	<?php
	$is_show_author = (int) get_theme_mod( 'is_show_taxonomy_author', 0 );
	if ( $is_show_author ) :
		?>
		<?php get_template_part( 'parts/metadata/author', 'blog' ); ?>
		<?php get_template_part( ORIGAMIEZ_PART_METADATA_DIVIDER_SLUG, 'blog' ); ?>
	<?php else : ?>
		<?php get_template_part( 'parts/metadata/author' ); ?>
	<?php endif; ?>
	<?php if ( 1 === (int) get_theme_mod( 'is_show_taxonomy_datetime', 1 ) ) : ?>
		<?php get_template_part( 'parts/metadata/date', 'blog' ); ?>
		<?php get_template_part( ORIGAMIEZ_PART_METADATA_DIVIDER_SLUG, 'blog' ); ?>
	<?php endif; ?>
	<?php if ( 1 === (int) get_theme_mod( 'is_show_taxonomy_comments', 1 ) ) : ?>
		<?php get_template_part( 'parts/metadata/comments', 'blog' ); ?>
		<?php get_template_part( ORIGAMIEZ_PART_METADATA_DIVIDER_SLUG, 'blog' ); ?>
	<?php endif; ?>
	<?php if ( 1 === (int) get_theme_mod( 'is_show_taxonomy_category', 1 ) && has_category() ) : ?>
		<?php get_template_part( 'parts/metadata/category', 'blog' ); ?>
	<?php endif; ?>
</p>
