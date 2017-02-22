<?php
/**
 * Fresh Start functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fresh_Start
 */

// Set up the theme
require_once get_parent_theme_file_path('/functions/setup.php');

// Enqueue CSS and JS
require_once get_parent_theme_file_path('/functions/enqueues.php');

// Register any widgets
require_once get_parent_theme_file_path('/functions/widgets.php');

// Custom Header implementation
require_once get_parent_theme_file_path('/functions/custom-header.php');

// Custom template tags for this theme
require_once get_parent_theme_file_path('/functions/template-tags.php');

// Customizer implementation
require_once get_parent_theme_file_path('/functions/customizer.php');

// WordPress tweaks specifically for this theme
require_once get_parent_theme_file_path('/functions/extras.php');

// Custom functions that act independently of the theme templates
require_once get_parent_theme_file_path('/functions/custom-functions.php');
