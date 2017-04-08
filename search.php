<?php
/**
 * The template for displaying search results.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Fresh_Start
 */

get_header();

if (have_posts()) :

  get_template_part('templates/part', 'header');

  while (have_posts()) : the_post();

    get_template_part('templates/content', 'search');

  endwhile;

  the_posts_pagination(['mid_size' => 3]);

else :

  get_template_part('templates/content', 'none');

endif;

get_sidebar();

get_footer();
