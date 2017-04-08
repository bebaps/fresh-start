<?php
/**
 * Template part for archive, search, or index page headers.
 *
 * @package Fresh_Start
 */

if (is_home() && !is_front_page()) : ?>

  <header class="page-header">
    <h1 class="screen-reader-text"><?php single_post_title(); ?></h1>
  </header>

<?php elseif (is_archive()) : ?>

  <header class="page-header">
    <?php the_archive_title('<h1 class="title">', '</h1>'); ?>
    <?php the_archive_description('<div>', '</div>'); ?>
  </header>

<?php elseif (is_search()) : ?>

  <header class="page-header">
    <h1 class="title">
      <?php printf(esc_html__('Search Results for: %s', 'fresh-start'), '<span>' . get_search_query() . '</span>'); ?>
    </h1>
  </header>

<?php endif;
