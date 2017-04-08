<?php
/**
 * Debug some piece of code.
 *
 * @param $code The code that you want to check.
 */
function debug( $code )
{
  printf( '<pre>%s</pre>', print_r( $code, true ) );
  die;
}

/**
 * Grab the URL of the Featured Image for the current page/post.
 *
 * @param null   $post_id The ID of the page/post to check for a Featured Image.
 * @param string $size    The defined image size to return.
 *
 * @return bool | URL Return false if there is no Featured Image, or the URL if there is one.
 */
function get_featured_image( $size = 'hero', $post_id = null )
{
  if ( !has_post_thumbnail( $post_id ) ) {
    return false;
  }

  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

  return $image[0];
}

/**
 * Force the site into a basic Maintenance Mode.
 * This is just ONE bare bones method of doing this, but honestly a plug-in would be better.
 */
$under_maintenance = false;

if ( $under_maintenance ) {
  function maintenance_mode()
  {
    if ( !current_user_can( 'administrator' ) ) {
      wp_die( 'The site is currently undergoing scheduled maintenance and will return shortly.',
        'We will be back soon!' );
    }
  }

  add_action( 'get_header', 'maintenance_mode' );
}
