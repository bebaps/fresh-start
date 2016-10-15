<?php
/**
 * Enqueue scripts and styles.
 */
function fresh_start_scripts() {
    wp_enqueue_style( 'fresh-start-style', get_stylesheet_uri() );

    wp_enqueue_script( 'fresh-start-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'fresh-start-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'fresh_start_scripts' );
