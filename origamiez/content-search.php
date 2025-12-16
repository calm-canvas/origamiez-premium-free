<li <?php post_class( array( 'clearfix' ) ); ?>>
    <article class="entry-item clearfix">

		<?php if ( is_sticky( get_the_ID() ) ) : ?>
		<?php endif; ?>
        <div class=" row">
            <div class="entry-summary col-sm-12">
                <h3 class="clearfix">
                    <a class="entry-title" href="<?php the_permalink(); ?>"
                       class="entry-content"><?php the_title(); ?></a>
                </h3>
                <p class="metadata">
					<?php
					$is_show_author = (int) get_theme_mod( 'is_show_taxonomy_author', 0 );
					if ( $is_show_author ) :
						?>
						<?php get_template_part( 'parts/metadata/author', 'blog' ); ?>
						<?php get_template_part( 'parts/metadata/divider', 'blog' ); ?>
					<?php else : ?>
						<?php get_template_part( 'parts/metadata/author' ); ?>
					<?php endif; ?>
					<?php if ( 1 === (int) get_theme_mod( 'is_show_taxonomy_datetime', 1 ) ) : ?>
						<?php get_template_part( 'parts/metadata/date', 'blog' ); ?>
						<?php get_template_part( 'parts/metadata/divider', 'blog' ); ?>
					<?php endif; ?>
					<?php if ( 1 === (int) get_theme_mod( 'is_show_taxonomy_comments', 1 ) ) : ?>
						<?php get_template_part( 'parts/metadata/comments', 'blog' ); ?>
						<?php get_template_part( 'parts/metadata/divider', 'blog' ); ?>
					<?php endif; ?>
					<?php if ( 1 === (int) get_theme_mod( 'is_show_taxonomy_category', 1 ) && has_category() ) : ?>
						<?php get_template_part( 'parts/metadata/category', 'blog' ); ?>
					<?php endif; ?>
                </p>
                <div class="entry-content">
					<?php the_excerpt(); ?>
                </div>
				<?php if ( 1 === (int) get_theme_mod( 'is_show_readmore_button', 1 ) ) : ?>
					<?php get_template_part( 'parts/metadata/readmore', 'blog' ); ?>
				<?php endif; ?>
            </div>
        </div>
    </article>
</li>