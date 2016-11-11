<?php
/**
 * Enqueue scripts and styles.
 */
function fresh_start_scripts() {
	wp_enqueue_style( 'fresh-start-styles', get_template_directory_uri() . '/assets/css/fresh-start.css' );

	wp_enqueue_script( 'fresh-start-scripts', get_template_directory_uri() . '/assets/js/fresh-start.js', array(), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'fresh_start_scripts' );

// Enqueue styles for custom login screen
function custom_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/wp-login.css' );
}

add_action( 'login_enqueue_scripts', 'custom_login_stylesheet' );

