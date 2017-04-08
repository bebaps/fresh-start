<?php
/**
 * Template part for the theme footer content.
 *
 * @package Fresh_Start
 */
?>

<footer class="site-footer">
  <span><?php printf('Copyright &copy; %s %s.', date('Y'), get_bloginfo('name')); ?></span>
  <span><?php printf(esc_html__('Site by %s.', 'fresh-start'),
      '<a href="https://alexanderpersky.com" rel="designer">Alexander Persky</a>'); ?></span>
</footer>
