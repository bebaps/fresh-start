<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fresh_Start
 */
?>

<section class="no-results">

    <header class="page_header">
        <h1 class="page_title"><?php esc_html_e( 'Nothing Found', 'fresh-start' ); ?></h1>
    </header>

    <div class="page_content">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'fresh-start' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

        <?php elseif ( is_search() ) : ?>

            <p><?php esc_html_e( 'Sorry, but nothing matched your search. Please try again.', 'fresh-start' ); ?></p>
            <?php get_search_form(); ?>

        <?php else : ?>

            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fresh-start' ); ?></p>
            <?php get_search_form(); ?>

        <?php endif; ?>
    </div>

</section><!-- .no-results -->
