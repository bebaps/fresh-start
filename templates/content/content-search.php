<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article class="post search-result">

  <header class="post_header">
    <?php the_title(sprintf('<h2 class="post_title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

    <?php if ('post' === get_post_type()) : ?>
      <div class="post_meta">
        <?php fresh_start_posted_on(); ?>
      </div>
    <?php endif; ?>
  </header>

  <div class="post_summary">
    <?php the_excerpt(); ?>
  </div>

  <footer class="post_footer">
    <?php fresh_start_entry_footer(); ?>
  </footer>

</article><!-- .search-result -->