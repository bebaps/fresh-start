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
get_sidebar();

while (have_posts()) : the_post();
  get_template_part('templates/content', 'page');

  if (comments_open() || get_comments_number()) :
    comments_template();
  endif;
endwhile;

get_footer();
