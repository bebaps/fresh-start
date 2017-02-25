<?php
if (!function_exists('fresh_start_setup')) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function fresh_start_setup()
  {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Fresh Start, use a find and replace
     * to change 'fresh-start' to the name of your theme in all the template files.
     */
    load_theme_textdomain('fresh-start', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // Register the navigational menus.
    register_nav_menus([
      'menu-1' => esc_html__('Primary Menu', 'fresh-start'),
      'menu-2' => esc_html__('Footer Menu', 'fresh-start'),
      'menu-3' => esc_html__('Social Menu', 'fresh-start')
    ]);

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', [
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    ]);

    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('fresh_start_custom_background_args', [
      'default-color' => 'ffffff',
      'default-image' => ''
    ]));

    // Add support for the WordPress custom logo feature.
    add_theme_support('custom-logo', [
      'width' => 100,
      'height' => 100,
      'flex-width' => false,
      'flex-height' => false,
    ]);

    /**
     * Set the content width in pixels, based on the theme's design and stylesheet.
     */
    function fresh_start_content_width()
    {
      $content_width = 1200;
      $GLOBALS['content_width'] = apply_filters('fresh_start_content_width', $content_width);
    }

    add_action('after_setup_theme', 'fresh_start_content_width', 0);
  }
endif;
add_action('after_setup_theme', 'fresh_start_setup');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function fresh_start_body_classes($classes)
{
  $classes[] = 'site';

  return $classes;
}

add_filter('body_class', 'fresh_start_body_classes');

/**
 * Add custom image sizes for this theme.
 */
if (function_exists('add_image_size')) {
  add_image_size('extra-large', 2500, 9999, true);
}

/**
 * Change the length of the excerpt.
 *
 * @return int The length you want to set for your excerpts.
 */
function custom_excerpt_length()
{
  return 25;
}

add_filter('excerpt_length', 'custom_excerpt_length');

/**
 * Restrict admin access to Administrators only
 */
function restrict_admin_access()
{
  global $current_user;

  wp_get_current_user();

  if (!array_key_exists('administrator', $current_user->caps)) {
    wp_redirect(get_bloginfo('url'));
    exit;
  }

}

add_action('admin_init', 'restrict_admin_access', 1);
