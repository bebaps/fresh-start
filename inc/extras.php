<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fresh_Start
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fresh_start_body_classes( $classes ) {
	$classes[] = 'site_body';

    if ( is_home() ) {
        $classes[] = '-is-home';
    }

    if ( is_front_page() ) {
        $classes[] = '-is-homepage';
    }

    if ( is_front_page() && is_home() ) {
        $classes[] = '-is-blogroll';
    }

    if ( is_single() ) {
        $classes[] = '-is-single';
    }

    if ( comments_open() ) {
        $classes[] = '-has-comments';
    }

    if ( is_page() ) {
        $classes[] = '-is-page';
    }

    if ( is_archive() ) {
        $classes[] = '-is-archive';
    }

    if ( is_search() ) {
        $classes[] = '-is-search-results';
    }

    if ( is_404() ) {
        $classes[] = '-is-404';
    }

    if ( is_child_theme() ) {
        $classes[] = '-is-child';
    }

	return $classes;
}
add_filter( 'body_class', 'fresh_start_body_classes' );

// Remove all body classes except for those inside $whitelist
// function wps_body_class($wp_classes, $extra_classes) {
//     $whitelist = array('portfolio', 'home', 'error404', 'search');
//     $wp_classes = array_intersect($wp_classes, $whitelist);

//     return array_merge($wp_classes, (array) $extra_classes);
// }
// add_filter('body_class', 'wps_body_class', 10, 2);

// Add a pingback url auto-discovery header for singularly identifiable articles.
function fresh_start_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'fresh_start_pingback_header' );

// Grab the URL of the Featured Image for the current page/post
function featured_image($image_size = 'Full') {
    $imgage_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size);

    return $image_src[0];
}

// Force WordPress to use pretty permalinks
function set_pretty_permalinks(){
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
}
add_action('init', 'set_pretty_permalinks');

// Add custom image sizes for this theme
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'hero', 1500, 9999 ); // 1500 pixels wide and auto height
    add_image_size( 'extra-large', 2500, 2500, true );
}

// Remove the theme editor
function remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('_admin_menu', 'remove_editor_menu', 1);

// Set the HTML editor to be the default editor
add_filter( 'wp_default_editor', create_function('', 'return "html";') );

// Change the length of the excerpt
function custom_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'custom_excerpt_length');

// Add some custom footer text in the admin area
function custom_admin_footer () {
  echo 'This theme was developed by Alexander Persky.';
}
add_filter('admin_footer_text', 'custom_admin_footer');

// Update the default [...] with a custom link
function replace_excerpt($content) {
    return str_replace('[&hellip;]', '<a class="continue-reading" href="' . get_permalink() . '">Read More&hellip;</a>', $content);
}
add_filter('the_excerpt', 'replace_excerpt');

// Blacklist WordPress menu class names
// Review https://developer.wordpress.org/reference/functions/wp_nav_menu/#Menu_Item_CSS_Classes for a full class listing
add_filter( 'nav_menu_css_class', function ( array $classes, $item, $args, $depth ) {
    $disallowed_class_names = array(
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
    );

    foreach ( $classes as $class ) {
        if ( in_array( $class, $disallowed_class_names ) ) {
            $key = array_search( $class, $classes );

            if ( false !== $key ) {
                unset( $classes[ $key ] );
            }
        }
    }

    return $classes;
}, 10, 4 );

// Remove all the IDs from all menu items except for the ones listed.
function my_css_attributes_filter($var) {
    $whitelist = array();

    return is_array($var) ? array_intersect($var, $whitelist) : '';
}
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);

// Put the site into a Maintenance Mode.
// There are multiple ways to do this. This is just ONE bare bones method, but honestly a plug-in would be better
if ($under_maintenance) {
    function maintenance_mode() {
        if ( !current_user_can( 'administrator' ) ) {
            wp_die('The site is currently undergoing scheduled maintenance and will return shortly.', 'We will be back soon!');
        }
    }
    add_action('get_header', 'maintenance_mode');
}
