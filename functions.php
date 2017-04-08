<?php
/**
 * Fresh Start functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fresh_Start
 */

// Set up the theme
require_once get_parent_theme_file_path( '/inc/theme-setup.php' );

// Enqueue CSS and JS
require_once get_parent_theme_file_path( '/inc/theme-enqueues.php' );

// Register any widgets
require_once get_parent_theme_file_path( '/inc/theme-widgets.php' );

// Custom Header implementation
require_once get_parent_theme_file_path( '/inc/theme-header.php' );

// Custom template tags for this theme
require_once get_parent_theme_file_path( '/inc/theme-tags.php' );

// Customizer implementation
require_once get_parent_theme_file_path( '/inc/theme-customizer.php' );

// WordPress tweaks specifically for this theme
require_once get_parent_theme_file_path( '/inc/theme-extras.php' );

// Custom functions that act independently of the theme templates
require_once get_parent_theme_file_path( '/inc/theme-functions.php' );
