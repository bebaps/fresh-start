<?php
/**
 * Template part for displaying individual search results.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article class="search-result">
  <header class="search-result-header">
    <?php the_title(sprintf('<h2><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

    <?php if ('post' === get_post_type()) : ?>

      <div class="search-result-meta">
        <?php fresh_start_posted_on(); ?>
      </div>

    <?php endif; ?>
  </header>

  <div class="post-summary">
    <?php the_excerpt(); ?>
  </div>

  <footer class="search-result-footer">
    <?php fresh_start_entry_footer(); ?>
  </footer>
</article>
