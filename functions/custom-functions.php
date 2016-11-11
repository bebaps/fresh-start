<?php
// Debug some code
function debug( $code ) {
	printf( '<pre>%s</pre>', print_r( $code, true ) );
    die;
}

// Grab the URL of the Featured Image for the current page/post
function featured_image( $post_id = NULL, $size = 'Full' ) {
	if ( ! has_post_thumbnail( $post_id ) ) {
		return;
	}

	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	return $image[ 0 ];
}

// Force the site into a Maintenance Mode
// This is just ONE bare bones method of doing this, but honestly a plug-in would be better
$under_maintenance = false;

if ( $under_maintenance ) {
	function maintenance_mode() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_die( 'The site is currently undergoing scheduled maintenance and will return shortly.', 'We will be back soon!' );
		}
	}

	add_action( 'get_header', 'maintenance_mode' );
}
