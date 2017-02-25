<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */

get_header();

if (have_posts()) : ?>
  <header>
    <?php the_archive_title('<h1 class="title">', '</h1>'); ?>
    <?php the_archive_description('<div>', '</div>'); ?>
  </header>

  <?php
  while (have_posts()) : the_post();
    get_template_part('templates/content', get_post_format());
  endwhile;
  the_posts_pagination(['mid_size' => 3]);
else :
  get_template_part('templates/content', 'none');
endif;

get_sidebar();
get_footer();
