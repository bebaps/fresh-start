<?php
/**
 * Enqueue scripts and styles.
 */
function fresh_start_scripts()
{
  wp_enqueue_style('theme-styles', get_theme_file_uri('/assets/css/theme.min.css'), [], '1.0.0');

  wp_enqueue_script('theme-scripts', get_theme_file_uri('/assets/js/theme.min.js'), ['jquery'], '1.0.0', true);

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
  wp_enqueue_style('login', get_theme_file_uri('/assets/css/theme-login.min.css'), [], '1.0.0');
}

add_action('login_enqueue_scripts', 'custom_login_stylesheet');
