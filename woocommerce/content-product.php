<?php
/**
 * content-product.php — AMIRA Product Card
 *
 * @package Antigravity
 */

defined('ABSPATH') || exit;

global $product;

if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}
if (!$product) {
    return;
}
?>

<div class="amira-card">

    <?php /* Image */ ?>
    <a href="<?php echo esc_url(get_permalink()); ?>" class="amira-card__image-link">
        <?php echo $product->get_image('woocommerce_single'); ?>
    </a>

    <?php /* Info */ ?>
    <div class="amira-card__info">

        <h2 class="amira-card__title">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <?php echo esc_html($product->get_name()); ?>
            </a>
        </h2>

        <div class="amira-card__price">
            <?php echo wp_kses_post($product->get_price_html()); ?>
        </div>

        <?php if ($product->is_type('simple') && $product->is_in_stock()): ?>
            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                class="amira-card__btn button add_to_cart_button"
                data-product_id="<?php echo esc_attr($product->get_id()); ?>">
                <?php esc_html_e('Add to Cart', 'antigravity'); ?>
            </a>
        <?php else: ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="amira-card__btn button">
                <?php esc_html_e('View Product', 'antigravity'); ?>
            </a>
        <?php endif; ?>

    </div>

</div>