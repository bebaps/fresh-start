<?php
/**
 * Fresh Start Theme Customizer.
 *
 * @package Fresh_Start
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fresh_start_customize_register($wp_customize)
{
  $wp_customize->get_setting('blogname')->transport = 'postMessage';
  $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
  $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}

add_action('customize_register', 'fresh_start_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fresh_start_customize_preview_js()
{
  wp_enqueue_script('fresh_start_customizer', get_theme_file_uri('/assets/js/theme/customizer.js'),
    ['customize-preview'],
    '20170225', true);
}

add_action('customize_preview_init', 'fresh_start_customize_preview_js');