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

// Add custom image sizes for this theme
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'hero', 1500, 9999 ); // 1500 pixels wide and auto height
    add_image_size( 'extra-large', 2500, 2500, true );
}

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
