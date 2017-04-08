<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
