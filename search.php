<?php
/**
 * The template for displaying search results pages.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Fresh_Start
 */

get_header(); ?>


<main id="main" class="site_main">

    <?php
    if ( have_posts() ) : ?>

        <header class="page_header">
            <h1 class="page_title"><?php printf( esc_html__( 'Search Results for: %s', 'fresh-start' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        </header>

        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/content', 'search' );

        endwhile;

        the_posts_pagination( array( 'mid_size' => 3 ) );

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif; ?>

</main><!-- #main -->


<?php
get_sidebar();
get_footer();
