<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */

get_header(); ?>


<main id="main" class="site_main">

    <?php if ( have_posts() ) : ?>

        <header class="page_header">
            <?php the_archive_title( '<h1 class="page_title">', '</h1>' ); ?>
            <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
        </header>

        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/content', get_post_format() );

        endwhile;

        the_posts_pagination();

        else :

            get_template_part( 'template-parts/content', 'none' );

    endif; ?>

</main><!-- #main -->


<?php
get_sidebar();
get_footer();
