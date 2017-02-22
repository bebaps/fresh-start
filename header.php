<?php
/**
 * The header for our theme.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Start
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="theme-color" content="#000">
  <link rel="profile" href="http://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <a class="screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'fresh-start'); ?></a>

  <header class="site_header">
    <?php if (has_custom_logo()) : ?>
      <h1 class="title">
        <?php the_custom_logo(); ?>
      </h1>
    <?php else : ?>
      <h1 class="title">
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
      </h1>
    <?php
    endif;

    $description = get_bloginfo('description', 'display');
    if ($description || is_customize_preview()) : ?>
      <p class="description"><?php echo $description; ?></p>
    <?php endif; ?>

    <?php wp_nav_menu([
      'theme_location'  => 'menu-1',
      'container'       => 'nav',
      'container_class' => 'site_navigation',
      'menu_id'         => 'menu-1'
    ]); ?>
  </header>

  <main id="main" class="site_main">
