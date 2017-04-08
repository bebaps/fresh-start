<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */

get_header();

if (have_posts()) :

  get_template_part('templates/part', 'header');

  while (have_posts()) : the_post();

    get_template_part('templates/content', get_post_format());

  endwhile;

  the_posts_pagination(['mid_size' => 3]);

else :

  get_template_part('templates/content', 'none');

endif;

get_sidebar();

get_footer();
