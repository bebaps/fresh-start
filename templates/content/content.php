<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article <?php post_class(); ?>>

    <header class="post_header">
        <?php
        if ( is_single() ) :
            the_title( '<h1 class="post_title">', '</h1>' );
        else :
            the_title( '<h2 class="post_title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        if ( 'post' === get_post_type() ) : ?>
            <div class="post_meta">
                <?php fresh_start_posted_on(); ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="post_content">
        <?php
        the_content( sprintf( /* translators: %s: Name of current post. */
            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'fresh-start' ), array( 'span' => array( 'class' => array() ) ) ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ) );

        wp_link_pages( array(
            'before' => '<div class="page_links">' . esc_html__( 'Pages:', 'fresh-start' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <footer class="post_footer">
        <?php fresh_start_entry_footer(); ?>
    </footer>

</article><!-- .post -->
