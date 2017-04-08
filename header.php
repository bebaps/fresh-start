<?php
/**
 * The theme header.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */

// Define a browsers toolbar color if supported
$theme_color = '#000';
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="theme-color" content="<?php echo $theme_color; ?>">
  <link rel="profile" href="http://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<a class="screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'fresh-start' ); ?></a>

<?php get_template_part('templates/content', 'header'); ?>

<main id="main" class="site-main">
