<?php
// Debug some code
function debug($code) {
  printf('<pre>%s</pre>', print_r($code, true));
}

// Grab the URL of the Featured Image for the current page/post
function featured_image( $post_id = null, $size = 'Full' ) {
  if ( !has_post_thumbnail( $post_id ) ) {
    return;
  }

  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

  return $image[ 0 ];
}

// Put the site into a Maintenance Mode.
// There are multiple ways to do this. This is just ONE bare bones method, but honestly a plug-in would be better
if ($under_maintenance) {
    function maintenance_mode() {
        if ( !current_user_can( 'administrator' ) ) {
            wp_die('The site is currently undergoing scheduled maintenance and will return shortly.', 'We will be back soon!');
        }
    }
    add_action('get_header', 'maintenance_mode');
}
