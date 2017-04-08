<?php
/**
 * Template Name: Layout - No Sidebar
 * Template Post Type: post, page
 *
 * The template for displaying content with no sidebar.
 *
 * @package Fresh_Start
 */

get_header();

while (have_posts()) : the_post();

  get_template_part('templates/content', 'page');

  if (comments_open() || get_comments_number()) :

    comments_template();

  endif;

endwhile;

get_footer();
