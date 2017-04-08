<?php
/**
 * The template for displaying a single page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */

get_header();

while ( have_posts() ) : the_post();

  get_template_part( 'templates/content', 'page' );

endwhile;

get_footer();
