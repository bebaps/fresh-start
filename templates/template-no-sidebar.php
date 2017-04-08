<?php
/**
 * Template Name: Layout - No Sidebar
 * Template Post Type: post
 *
 * The template for displaying content with no sidebar.
 *
 * @package Fresh_Start
 */

get_header();

while (have_posts()) : the_post();

  get_template_part('templates/content', get_post_format());

  if (comments_open() || get_comments_number()) :

    comments_template();

  endif;

endwhile;

get_footer();
