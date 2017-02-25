<?php
/**
 * Enqueue scripts and styles.
 */
function fresh_start_scripts()
{
  wp_enqueue_style('fresh-start-styles', get_theme_file_uri('/assets/css/theme.min.css'));

  wp_enqueue_script('fresh-start-scripts', get_theme_file_uri('/assets/js/theme.min.js'), [], '', true);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}

add_action('wp_enqueue_scripts', 'fresh_start_scripts');

/**
 * Enqueue styles for custom login screen.
 */
function custom_login_stylesheet()
{
  wp_enqueue_style('custom-login', get_theme_file_uri('/assets/css/theme-login.min.css'));
}

add_action('login_enqueue_scripts', 'custom_login_stylesheet');

