<?php
/**
 * The template for displaying a single post.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Fresh_Start
 */

get_header();

while ( have_posts() ) : the_post();

  get_template_part( 'templates/content', get_post_format() );

  the_post_navigation();

  if ( comments_open() || get_comments_number() ) :

    comments_template();

  endif;

endwhile;

get_sidebar();

get_footer();
