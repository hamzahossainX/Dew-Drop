<?php
/**
 * WooCommerce template override
 *
 * Including this file in the theme prevents WooCommerce from using
 * its own default layout and ensures get_header() / get_footer() are
 * always called from OUR theme header (with the AMIRA nav).
 *
 * @package Antigravity
 */

get_header();
?>

<main class="content-area woocommerce-content" id="primary">
    <div class="container">
        <?php woocommerce_content(); ?>
    </div>
</main>

<?php get_footer(); ?>