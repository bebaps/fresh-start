<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
  return;
}
?>

<section class="comments">
  <?php if (have_comments()) : ?>
    <h2>
      <?php
      printf(
        esc_html(_nx('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(),
          'comments title', 'fresh-start')), number_format_i18n(get_comments_number()),
        '<span>' . get_the_title() . '</span>');
      ?>
    </h2>

    <ol>
      <?php wp_list_comments(['style' => 'ol', 'type' => 'comment']); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>
      <nav class="comments-navigation">
        <h2 class="screen-reader-text"><?php esc_html_e('Comments navigation', 'fresh-start'); ?></h2>
        <?php paginate_comments_links([
          'prev_text' => 'Older Comments',
          'next_text' => 'Newer Comments'
        ]); ?>
      </nav>
    <?php endif; ?>
  <?php endif;

  // If comments are closed and there are comments, let's leave a little note, shall we?
  if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p><?php esc_html_e('Sorry, comments are closed.', 'fresh-start'); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>
</section>
