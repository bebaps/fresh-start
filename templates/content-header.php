<?php
/**
 * Template part for the theme header content.
 *
 * @package Fresh_Start
 */
?>

<header class="site-header">
  <?php if ( has_custom_logo() ) : ?>

    <h1 class="title"><?php the_custom_logo(); ?></h1>

  <?php else : ?>

    <h1 class="title">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </h1>

    <?php
  endif;

  $description = get_bloginfo( 'description', 'display' );

  if ( $description || is_customize_preview() ) : ?>

    <p class="description"><?php echo $description; ?></p>

    <?php
  endif;

  wp_nav_menu( [
    'theme_location' => 'primary',
    'container' => 'nav',
    'container_class' => 'site-navigation'
  ] );
  ?>
</header>
