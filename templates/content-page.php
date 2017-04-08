<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article>
  <header>
    <?php the_title('<h1>', '</h1>'); ?>
  </header>

  <div class="content">
    <?php
    the_content();

    wp_link_pages([
      'before' => '<div class="page-links">' . esc_html__('Pages:', 'fresh-start'),
      'after' => '</div>',
    ]);
    ?>
  </div>
</article>
