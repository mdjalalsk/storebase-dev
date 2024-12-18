<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package StoreBase
 */

 get_header();
 ?>
<section class="container py-4">
    <div class="row">
        <!-- Main Content Area -->
        <div class="col-12 col-md-8">
            <main id="primary" class="site-main">
                <?php if ( have_posts() ) : ?>
                    <header class="page-header mb-4">
                        <h1 class="page-title">
                            <?php
                            /* translators: %s: search query. */
                            printf( esc_html__( 'Search Results for: %s', 'storebase' ), '<span>' . get_search_query() . '</span>' );
                            ?>
                        </h1>
                    </header><!-- .page-header -->

                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();

                        get_template_part( 'template-parts/content', 'search' );

                    endwhile;

                    the_posts_navigation();

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;
                ?>
            </main><!-- #main -->
        </div><!-- /.col-md-8 -->

        <!-- Sidebar Area -->
        <div class="col-12 col-md-4 mt-4 mt-md-0">
            <?php get_sidebar(); ?>
        </div><!-- /.col-md-4 -->
    </div><!-- /.row -->
</section>

<?php
get_footer();

