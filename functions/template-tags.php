<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fresh_Start
 */

if ( !function_exists('fresh_start_posted_on')) :

  // Prints HTML with meta information for the current post-date/time and author.
  function fresh_start_posted_on()
  {
    $time_string = '<time class="post_date" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
      $time_string = '<time class="post_date" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()),
      esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date()));

    $posted_on = sprintf(esc_html_x('Posted on %s', 'post date', 'fresh-start'),
      '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>');

    $post_author = sprintf(esc_html_x('by %s', 'post author', 'fresh-start'),
      '<span class="post_author"><a class="author-url" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>');

    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $post_author . '</span>'; // WPCS: XSS OK.

  }
endif;

if ( !function_exists('fresh_start_entry_footer')) :

  // Prints HTML with meta information for the categories, tags and comments.
  function fresh_start_entry_footer()
  {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
      /* translators: used between list items, there is a space after the comma */
      $categories_list = get_the_category_list(esc_html__(', ', 'fresh-start'));
      if ($categories_list && fresh_start_categorized_blog()) {
        printf('<span class="category-links">' . esc_html__('Posted in %1$s', 'fresh-start') . '</span>',
          $categories_list); // WPCS: XSS OK.
      }

      /* translators: used between list items, there is a space after the comma */
      $tags_list = get_the_tag_list('', esc_html__(', ', 'fresh-start'));
      if ($tags_list) {
        printf('<span class="tag-links">' . esc_html__('Tagged %1$s', 'fresh-start') . '</span>',
          $tags_list); // WPCS: XSS OK.
      }
    }

    if ( !is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
      echo '<span class="comment-link">';
      /* translators: %s: post title */
      comments_popup_link(sprintf(wp_kses(__('Leave a Comment<span class="screen-reader-text"> on %s</span>',
        'fresh-start'), ['span' => ['class' => []]]), get_the_title()));
      echo '</span>';
    }

    edit_post_link(sprintf( /* translators: %s: Name of current post */
      esc_html__('Edit %s', 'fresh-start'), the_title('<span class="screen-reader-text">"', '"</span>', false)),
      '<span class="edit-link">', '</span>');
  }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function fresh_start_categorized_blog()
{
  if (false === ($all_the_cool_cats = get_transient('fresh_start_categories'))) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories([
      'fields'     => 'ids',
      'hide_empty' => 1,
      // We only need to know if there is more than one category.
      'number'     => 2,
    ]);

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count($all_the_cool_cats);

    set_transient('fresh_start_categories', $all_the_cool_cats);
  }

  if ($all_the_cool_cats > 1) {
    // This blog has more than 1 category so fresh_start_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so fresh_start_categorized_blog should return false.
    return false;
  }
}

/**
 * Flush out the transients used in fresh_start_categorized_blog.
 */
function fresh_start_category_transient_flusher()
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  // Like, beat it. Dig?
  delete_transient('fresh_start_categories');
}

add_action('edit_category', 'fresh_start_category_transient_flusher');
add_action('save_post', 'fresh_start_category_transient_flusher');
