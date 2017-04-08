<?php
/**
 * The template for displaying the footer.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */
?>

</main><?php // Close #main ?>

<footer class="site-footer">
  <span><?php printf('Copyright &copy; %s %s.', date('Y'), get_bloginfo('name')); ?></span>
  <span><?php printf(esc_html__('Site by %s.', 'fresh-start'),
      '<a href="https://alexanderpersky.com" rel="designer">Alexander Persky</a>'); ?></span>
</footer>

<?php wp_footer(); ?>
</body>
</html>
