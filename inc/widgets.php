<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fresh_start_widgets_init() {
	// Register 2 sidebars
	register_sidebars( 2, array(
		'name'          => esc_html__( 'Sidebar %d', 'fresh-start' ),
		'description'   => esc_html__( 'Add widgets here.', 'fresh-start' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
}

add_action( 'widgets_init', 'fresh_start_widgets_init' );
