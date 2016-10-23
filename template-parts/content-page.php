<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<article class="page_main-content">
    <header class="post_header">
        <?php the_title( '<h1 class="post_title">', '</h1>' ); ?>
    </header>

    <div class="post_content">
        <?php
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page_links">' . esc_html__( 'Pages:', 'fresh-start' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <?php if ( get_edit_post_link() ) : ?>
        <footer class="post_footer">
            <?php
            edit_post_link( sprintf( /* translators: %s: Name of current post */
                esc_html__( 'Edit %s', 'fresh-start' ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ), '<span class="edit-link">', '</span>' );
            ?>
        </footer>
    <?php endif; ?>
</article><!-- .page_main-content -->
