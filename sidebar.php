<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */

// Which sidebar do you want to grab?
$sidebar = 1;

if (!is_active_sidebar($sidebar)) {
  return;
}
?>

<aside class="site_sidebar">
  <?php dynamic_sidebar($sidebar); ?>
</aside>
