<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */

if ( ! is_active_sidebar( 'Sidebar 1' ) ) {
	return;
}
?>

<aside class="sidebar">
	<?php dynamic_sidebar( 'Sidebar 1' ); ?>
</aside><!-- .sidebar -->
