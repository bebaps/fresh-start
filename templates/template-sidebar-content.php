<?php
/**
 * Template Name: Layout - Sidebar/Content
 * Template Post Type: page, post
 *
 * The template for displaying the sidebar on the left, and the content on the right.
 *
 * @package Fresh_Start
 */

get_header();
get_sidebar(); ?>


    <main id="main" class="site_main">

        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'templates/content/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile;
        ?>

    </main><!-- #main -->


<?php
get_footer();
