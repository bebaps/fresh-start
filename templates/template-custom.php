<?php
/**
 * Template Name: Custom Page Template
 * Temple Post Type: page
 *
 * Example of using a custom page template in Timber.
 */

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(['custom.twig'], $context);
