<?php

use Timber\Site;

class FreshStart extends Site
{
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'theme_supports']);
    add_action('after_setup_theme', [$this, 'theme_image_sizes']);
    add_action('after_setup_theme', [$this, 'theme_menus']);
    add_action('wp_enqueue_scripts', [$this, 'theme_enqueue_assets']);
    add_filter('timber/context', [$this, 'add_to_context']);
    add_filter('timber/twig', [$this, 'add_to_twig']);
    add_action('init', [$this, 'register_post_types']);
    add_action('init', [$this, 'register_taxonomies']);
    add_action('theme_styles', [$this, 'theme_styles']);
    add_action('theme_scripts', [$this, 'theme_scripts']);

    parent::__construct();
  }

  /**
   * Register custom post types, if it makes sense for this theme.
   *
   * Usually, it is better to register custom post types in a custom plugin.
   */
  public function register_post_types()
  {
    //
  }

  /**
   * Register custom taxonomies, if it makes sense for this theme.
   *
   * Usually, it is better to register custom taxonomies in a custom plugin.
   */
  public function register_taxonomies()
  {
    //
  }

  /**
   * Define custom image sizes.
   */
  public function theme_image_sizes()
  {
    //
  }

  /**
   * Define custom menus.
   */
  public function theme_menus()
  {
    //
  }

  /**
   * Enqueue CSS/JS the WordPress way.
   *
   * Good for interacting with assets loaded by 3rd party plugins.
   */
  public function theme_enqueue_assets()
  {
    //
  }

  /**
   * Load CSS in your own way.
   *
   * Useful if you want to utilize things like critical CSS, async loading of CSS, etc.
   * WordPress does not handle any of this, and it is easier to add your CSS here instead of having
   * to write some verbose custom hook.
   */
  public function theme_styles()
  {
    //
  }

  /**
   * Load JS in your own way.
   *
   * Useful if you want to utilize things like async or deferred JS, custom crossorigins, etc.
   * WordPress does not handle any of this, and it is easier to add your JS here instead of having
   * to write some verbose custom hook.
   */
  public function theme_scripts()
  {
    //
  }

  /**
   * Define custom theme supports.
   */
  public function theme_supports()
  {
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
      'html5',
      [
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      ]
    );
    add_theme_support('menus');
  }

  /**
   * This is where you add some context.
   *
   * @param $context string context['this'] Being the Twig's {{ this }}.
   *
   * @return mixed
   */
  public function add_to_context($context)
  {
    $context['foo'] = 'bar';
    $context['stuff'] = 'I am a value set in your functions.php file';
    $context['notes'] = 'These values are available everytime you call Timber::context();';
    $context['menu'] = new Timber\Menu();
    $context['site'] = $this;

    return $context;
  }

  /**
   * This Would return 'foo bar!'.
   *
   * @param $text string Being 'foo', then returned 'foo bar!'.
   *
   * @return string
   */
  public function myfoo($text)
  {
    $text .= ' bar!';

    return $text;
  }

  /**
   * This is where you can add your own functions to twig.
   *
   * @param $twig string Get Twig extensions.
   *
   * @return mixed
   */
  public function add_to_twig($twig)
  {
    $twig->addExtension(new Twig\Extension\StringLoaderExtension());
    $twig->addFilter(new Twig\TwigFilter('myfoo', [$this, 'myfoo']));

    return $twig;
  }
}

new FreshStart();
