<?php
/**
 * Template Name: Test
 *
 * The template for testing different things.
 *
 * @package Fresh_Start
 */

get_header();

$args  = [
  'post_type' => 'post',
  'tax_query' => [
    [
      'taxonomy' => 'edge-case-2',
      'field'    => 'slug'
    ],
  ],
];
$query = new WP_Query($args);

if (have_posts()) : while (have_posts()) : the_post();
  debug($query);
endif;

  get_footer();
