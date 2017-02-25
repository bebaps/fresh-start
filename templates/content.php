<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article <?php post_class(); ?>>
  <header>
    <?php
    if (is_single()) :
      the_title('<h1>', '</h1>');
    else :
      the_title('<h2><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
    endif;

    if ('post' === get_post_type()) : ?>
      <?php fresh_start_posted_on(); ?>
    <?php endif; ?>
  </header>

  <div class="content">
    <?php
    the_content(sprintf( /* translators: %s: Name of current post. */
      wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'fresh-start'),
        ['span' => ['class' => []]]), the_title('<span class="screen-reader-text">"', '"</span>', false)));

    wp_link_pages([
      'before' => '<div class="page-links">' . esc_html__('Pages:', 'fresh-start'),
      'after' => '</div>',
    ]);
    ?>
  </div>

  <footer>
    <?php fresh_start_entry_footer(); ?>
  </footer>
</article>
