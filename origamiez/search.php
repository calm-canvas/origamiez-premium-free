<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package origamiez
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php ( new \Origamiez\Engine\Display\Breadcrumb\BreadcrumbGenerator() )->displayBreadcrumb(); ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if ( have_posts() ) : ?>
                        <header class="page-header clearfix">
                            <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'origamiez' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                        </header><!-- .page-header -->

                        <ul id="origamiez-blogposts">
                            <?php /* Start the Loop */ ?>
                            <?php while ( have_posts() ) : the_post(); ?>

                                <?php
                                /**
                                 * Run the loop for the search to output the results.
                                 * If you want to overload this in a child theme then include a file
                                 * called content-search.php and that will be used instead.
                                 */
                                get_template_part( 'content', 'search' );
                                ?>

                            <?php endwhile; ?>

                            <?php get_template_part( 'pagination' ); ?>
                        </ul>
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>
