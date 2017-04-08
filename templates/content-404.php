<?php
/**
 * Template part for the 404 page content.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article>
  <header>
    <h1 class="title"><?php esc_html_e('Oops! That page can&rsquo;t be found...', 'fresh-start'); ?></h1>
  </header>

  <section class="content">
    <p><?php esc_html_e('Sorry, but what you are looking for is not here. Maybe try one of the links below or a search?',
        'fresh-start'); ?></p>
    <p>Return to the <a href="<?php echo esc_url(home_url('/')); ?>">homepage</a>.</p>
  </section>
</article>
