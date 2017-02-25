<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Fresh_Start
 */

get_header(); ?>

  <header>
    <h1 class="title"><?php esc_html_e('Oops! That page can&rsquo;t be found...', 'fresh-start'); ?></h1>
  </header>

  <section class="content">
    <p><?php esc_html_e('Sorry, but what you are looking for is not here. Maybe try one of the links below or a search?',
        'fresh-start'); ?></p>
    <p>Return to the <a href="<?php echo esc_url(home_url('/')); ?>">homepage</a>.</p>
  </section>

<?php
get_search_form();
get_footer();
