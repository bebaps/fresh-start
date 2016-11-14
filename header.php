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
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="theme-color" content="#000">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <a class="screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'fresh-start' ); ?></a>

    <?php wp_nav_menu( array(
        'theme_location'  => 'mobile',
        'container_class' => 'cm-panel',
        'container_id'    => 'mobile-nav'
    ) ); ?>

    <header class="site_header">
        <div class="site_branding">
            <?php if ( is_front_page() && is_home() ) : ?>
                <?php if ( has_custom_logo() ) : ?>
                    <h1 class="site_title">
                        <?php the_custom_logo(); ?>
                    </h1>
                <?php else : ?>
                    <h1 class="site_title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                    </h1>
                <?php endif; ?>
            <?php else : ?>
                <?php if ( has_custom_logo() ) : ?>
                    <p class="site_title">
                        <?php the_custom_logo(); ?>
                    </p>
                <?php else : ?>
                    <p class="site_title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                    </p>
                    <?php
                endif;
            endif;

            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p class="site_description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
            <?php endif; ?>
        </div>

        <?php wp_nav_menu( array(
            'theme_location'  => 'primary',
            'container'       => 'nav',
            'container_class' => 'main-navigation',
            'container_id'    => 'site_navigation',
            'menu_id'         => 'primary-menu'
        ) ); ?>

        <button class="cm-hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header><!-- .site_header -->
