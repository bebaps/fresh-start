<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */

// which sidebar do you want to grab?
$sidebar = 1;

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}
?>

<aside class="sidebar">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- .sidebar -->