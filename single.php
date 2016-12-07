<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Fresh_Start
 */

get_header(); ?>


    <main id="main" class="site_main" role="main">

        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'templates/content/content', get_post_format() );

            the_post_navigation();

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile;
        ?>

    </main><!-- #main -->


<?php
get_sidebar();
get_footer();
