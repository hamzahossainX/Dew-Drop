<?php
/**
 * The template for displaying all pages
 *
 * @package Antigravity
 */

get_header();
?>

<main class="content-area page-content" id="primary">
    <div class="container">
        <?php
        while (have_posts()):
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php if (get_the_title()): ?>
                    <header class="entry-header">
                        <h1 class="entry-title">
                            <?php the_title(); ?>
                        </h1>
                    </header>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'antigravity'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>

            </article>
        <?php endwhile; ?>
    </div>
</main><!-- #primary -->

<?php get_footer(); ?>