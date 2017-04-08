<?php
/**
 * The main sidebar containing widget areas.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */

// Which sidebar do you want to grab?
$sidebar = 1;

if ( !is_active_sidebar( $sidebar ) ) {
  return;
} ?>

<aside class="site-sidebar">
  <?php dynamic_sidebar( $sidebar ); ?>
</aside>
