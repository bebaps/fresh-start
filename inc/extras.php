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

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function fresh_start_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'fresh_start_pingback_header' );
