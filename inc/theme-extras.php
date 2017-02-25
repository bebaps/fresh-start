<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fresh_Start
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function fresh_start_pingback_header()
{
  if (is_singular() && pings_open()) {
    echo '<link rel="pingback" href="', bloginfo('pingback_url'), '">';
  }
}

add_action('wp_head', 'fresh_start_pingback_header');

/**
 * Add some custom footer text in the admin area.
 */
function custom_admin_footer()
{
  echo 'Theme developed by <a href="https://alexanderpersky.com" rel="designer">Alexander Persky</a>';
}

add_filter('admin_footer_text', 'custom_admin_footer');

/**
 * Change the default [...] to utilize a custom link.
 *
 * @param $content The post content.
 *
 * @return mixed The new [...] with the custom link.
 */
function replace_excerpt($content)
{
  return str_replace('[&hellip;]', '<a class="continue-reading" href="' . get_permalink() . '">Read More&hellip;</a>',
    $content);
}

add_filter('the_excerpt', 'replace_excerpt');

/**
 * Prevent certain class names from appearing in the WordPress generated menus.
 * Review https://developer.wordpress.org/reference/functions/wp_nav_menu/#Menu_Item_CSS_Classes for a full list of
 * class names.
 */
add_filter('nav_menu_css_class', function (array $classes, $item, $args, $depth) {
  $disallowed_class_names = [
    "menu-item",
    "menu-item-{$item->ID}",
    "menu-item-type-{$item->type}",
    "menu-item-object-{$item->object}",
    "current-{$item->type}-item",
    "current-{$item->object}-item",
    "current-{$item->type}-parent",
    "current-{$item->object}-parent",
    "current-{$item->type}-ancestor",
    "current-{$item->object}-ancestor",
    'page_item',
    'page_item_has_children',
    "page-item-{$item->object_id}",
    'current_page_item',
    'current_page_parent',
    'current_page_ancestor'
  ];

  foreach ($classes as $class) {
    if (in_array($class, $disallowed_class_names)) {
      $key = array_search($class, $classes);

      if (false !== $key) {
        unset($classes[$key]);
      }
    }
  }

  return $classes;
}, 10, 4);

/**
 * Remove all the IDs from all menu items except for the ones listed.
 *
 * @param $var An array of the ID's that you wish to keep.
 *
 * @return array|string
 */
function my_css_attributes_filter($var)
{
  $whitelist = [];

  return is_array($var) ? array_intersect($var, $whitelist) : '';
}

add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);

/**
 * Remove any automatic formatting from the editor
 */
remove_filter('the_content', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');

/**
 * Ensure only admin users receive update notifications
 */
add_action('plugins_loaded', function () {
  if (!current_user_can('update_plugins')) {
    add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
    add_filter('pre_option_update_core', create_function('$a', 'return null;'));
  }
});

/**
 * Remove stupid widgets
 */
// Remove the Wlwmanifest
remove_action('wp_head', 'wlwmanifest_link');

// Remove the RSD link
remove_action('wp_head', 'rsd_link');

// Remove the Meta Generator
remove_action('wp_head', 'wp_generator');

// Remove some meta boxes
function remove_meta_boxes()
{
  // Removes meta from Posts
  remove_meta_box('postcustom', 'post', 'normal');
  remove_meta_box('trackbacksdiv', 'post', 'normal');
  remove_meta_box('commentstatusdiv', 'post', 'normal');
  remove_meta_box('commentsdiv', 'post', 'normal');
  remove_meta_box('authordiv', 'post', 'normal');
  // Removes meta from pages
  remove_meta_box('postcustom', 'page', 'normal');
  remove_meta_box('trackbacksdiv', 'page', 'normal');
  remove_meta_box('commentstatusdiv', 'page', 'normal');
  remove_meta_box('commentsdiv', 'page', 'normal');
  remove_meta_box('authordiv', 'page', 'normal');
}

add_action('admin_init', 'remove_meta_boxes');

// Remove all dashboard widgets
function wpdocs_remove_dashboard_widgets()
{
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
  remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
  remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
}

add_action('wp_dashboard_setup', 'wpdocs_remove_dashboard_widgets');

// Remove some standard widgets
function remove_widgets()
{
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
}

add_action('widgets_init', 'remove_widgets');

/**
 * Remove the emojis
 */
function disable_wp_emojicons()
{
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');

  // filter to remove TinyMCE emojis
  add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}

function disable_emojicons_tinymce($plugins)
{
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  } else {
    return array();
  }
}

add_action('init', 'disable_wp_emojicons');
