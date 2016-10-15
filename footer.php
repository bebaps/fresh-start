<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */
?>

<footer class="site_footer">
    <?php printf('&copy; Copyright %s. All Rights Reserved', date('Y')); ?>
	<span class="sep"> | </span>
	<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'fresh-start' ), 'fresh-start', '<a href="http://alexanderpersky.com" rel="designer">Alexander Persky</a>' ); ?>
</footer><!-- .site_footer -->

<?php wp_footer(); ?>
</body>
</html>
