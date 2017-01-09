<?php
/**
 * The template for displaying search results pages.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Fresh_Start
 */

get_header(); ?>

  <main id="main" class="site_main">

    <?php
    if (have_posts()) : ?>

      <header class="page_header">
        <h1 class="page_title"><?php printf(esc_html__('Search Results for: %s', 'fresh-start'), '<span>' . get_search_query() . '</span>'); ?></h1>
      </header>

      <?php
      while (have_posts()) : the_post();

        get_template_part('templates/content/content', 'search');

      endwhile;

      the_posts_pagination(['mid_size' => 3]);

    else :

      get_template_part('templates/content/content', 'none');

    endif; ?>

  </main><!-- #main -->

<?php
get_sidebar();
get_footer();
