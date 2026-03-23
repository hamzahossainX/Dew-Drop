<?php
/**
 * content-single-product.php — AMIRA Single Product Part
 * Minimal · Luxury · Elegant
 *
 * @package Antigravity
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

/**
 * Hook: woocommerce_before_single_product.
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

/* ── Gather product data ───────────────────────────── */
$product_id = $product->get_id();
$product_name = $product->get_name();
$product_price = $product->get_price_html();
$product_sku = $product->get_sku();
$short_desc = $product->get_short_description();
$stock_status = $product->get_stock_status();      // 'instock' | 'outofstock' | 'onbackorder'
$stock_qty = $product->get_stock_quantity();
$manage_stock = $product->get_manage_stock();
$is_in_stock = $product->is_in_stock();
$rating_count = $product->get_rating_count();
$average_rating = $product->get_average_rating();
$categories = wc_get_product_terms($product_id, 'product_cat', ['fields' => 'all']);
$tags = wc_get_product_terms($product_id, 'product_tag', ['fields' => 'names']);
$gallery_ids = $product->get_gallery_image_ids();
$main_image_id = $product->get_image_id();
$my_account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');

/* All image IDs for gallery (main + gallery) */
$all_image_ids = $main_image_id ? array_merge([$main_image_id], $gallery_ids) : $gallery_ids;
?>

<div class="amira-single-product">

    <!-- ═══════════════════════════════════════════════
             BREADCRUMB
        ════════════════════════════════════════════════ -->
    <div class="asp-breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span class="asp-bc-sep">›</span>
        <a href="<?php echo esc_url($shop_url); ?>">Shop</a>
        <?php if (!empty($categories)):
            $cat = $categories[0]; ?>
            <span class="asp-bc-sep">›</span>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
        <?php endif; ?>
        <span class="asp-bc-sep">›</span>
        <span class="asp-bc-current">
            <?php echo esc_html($product_name); ?>
        </span>
    </div>

    <!-- ═══════════════════════════════════════════════
             MAIN 2-COLUMN WRAPPER
        ════════════════════════════════════════════════ -->
    <div class="asp-main-wrapper">

        <!-- ╔══════════════════════════════════════════
                 LEFT — IMAGE GALLERY
            ═══════════════════════════════════════════╗ -->
        <div class="asp-gallery-section">

            <!-- Main image -->
            <div class="asp-main-image" id="aspMainImage">
                <?php if ($main_image_id): ?>
                    <img src="<?php echo esc_url(wp_get_attachment_image_url($main_image_id, 'woocommerce_single')); ?>"
                        alt="<?php echo esc_attr($product_name); ?>" id="aspMainImg" class="asp-main-img">
                <?php else: ?>
                    <img src="<?php echo esc_url(wc_placeholder_img_src('woocommerce_single')); ?>"
                        alt="<?php echo esc_attr($product_name); ?>" id="aspMainImg" class="asp-main-img">
                <?php endif; ?>
            </div>

            <!-- Thumbnail strip -->
            <?php if (count($all_image_ids) > 1): ?>
                <div class="asp-thumbnails" id="aspThumbs">
                    <?php foreach ($all_image_ids as $img_id):
                        $full = wp_get_attachment_image_url($img_id, 'woocommerce_single');
                        $thumb = wp_get_attachment_image_url($img_id, 'woocommerce_thumbnail');
                        ?>
                        <button class="asp-thumb <?php echo ($img_id === $main_image_id) ? 'asp-thumb--active' : ''; ?>"
                            data-full="<?php echo esc_url($full); ?>" aria-label="View image" type="button">
                            <img src="<?php echo esc_url($thumb); ?>" alt="">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div><!-- .asp-gallery-section -->

        <!-- ╔══════════════════════════════════════════
                 RIGHT — PRODUCT INFO
            ═══════════════════════════════════════════╗ -->
        <div class="asp-info-section">

            <!-- Category label -->
            <?php if (!empty($categories)): ?>
                <div class="asp-category-label">
                    <?php echo esc_html($categories[0]->name); ?>
                </div>
            <?php endif; ?>

            <!-- Product title -->
            <h1 class="asp-title">
                <?php echo esc_html($product_name); ?>
            </h1>

            <!-- Star rating -->
            <?php if ($rating_count > 0): ?>
                <div class="asp-rating">
                    <?php echo wc_get_rating_html($average_rating, $rating_count); ?>
                    <span class="asp-rating-count">(
                        <?php echo esc_html($rating_count); ?>
                        <?php echo _n('review', 'reviews', $rating_count); ?>)
                    </span>
                </div>
            <?php endif; ?>

            <!-- Price -->
            <div class="asp-price">
                <?php echo wp_kses_post($product_price); ?>
            </div>

            <!-- Short description -->
            <?php if ($short_desc): ?>
                <div class="asp-short-desc">
                    <?php echo wp_kses_post($short_desc); ?>
                </div>
            <?php endif; ?>

            <!-- Stock status -->
            <div class="asp-stock">
                <?php if ($is_in_stock): ?>
                    <span class="asp-stock--in">✓ In Stock</span>
                    <?php if ($manage_stock && $stock_qty !== null && $stock_qty < 5): ?>
                        <span class="asp-stock--low">Only
                            <?php echo esc_html($stock_qty); ?> left!
                        </span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="asp-stock--out">✗ Out of Stock</span>
                <?php endif; ?>
            </div>

            <!-- ── Add to Cart form ───────────────── -->
            <?php if ($is_in_stock): ?>
                <form class="asp-atc-form cart"
                    action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
                    method="post" enctype="multipart/form-data">

                    <!-- Quantity selector -->
                    <div class="asp-qty-wrap quantity">
                        <button type="button" class="asp-qty-btn qty-minus" aria-label="Decrease quantity">−</button>
                        <input type="number" id="quantity_<?php echo esc_attr($product_id); ?>"
                            class="asp-qty-input input-text qty text" name="quantity" value="1" min="1"
                            max="<?php echo esc_attr($manage_stock ? $stock_qty : ''); ?>" step="1"
                            aria-label="Product quantity">
                        <button type="button" class="asp-qty-btn qty-plus" aria-label="Increase quantity">+</button>
                    </div>

                    <!-- Add to Cart + Wishlist row -->
                    <div class="asp-action-row">
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>"
                            class="asp-atc-btn single_add_to_cart_button button alt">
                            Add to Cart
                        </button>

                        <button type="button" class="asp-wishlist-btn" aria-label="Add to wishlist">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                aria-hidden="true">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Buy Now -->
                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>"
                        class="asp-buy-now-btn" formaction="<?php echo esc_url(wc_get_checkout_url()); ?>">
                        Buy Now
                    </button>

                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                </form>
            <?php else: ?>
                <div class="asp-out-of-stock-msg">
                    <p>This product is currently out of stock. <a href="<?php echo esc_url($shop_url); ?>">Browse other
                            products →</a></p>
                </div>
            <?php endif; ?>

            <!-- ── Product meta ───────────────────── -->
            <div class="asp-meta">
                <?php if ($product_sku): ?>
                    <div class="asp-meta-row">
                        <span class="asp-meta-label">SKU:</span>
                        <span class="asp-meta-value">
                            <?php echo esc_html($product_sku); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($categories)): ?>
                    <div class="asp-meta-row">
                        <span class="asp-meta-label">Category:</span>
                        <span class="asp-meta-value">
                            <?php echo implode(', ', array_map(function ($cat) {
                                return '<a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a>';
                            }, $categories)); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tags)): ?>
                    <div class="asp-meta-row">
                        <span class="asp-meta-label">Tags:</span>
                        <span class="asp-meta-value">
                            <?php echo esc_html(implode(', ', $tags)); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ── Social share ───────────────────── -->
            <div class="asp-share">
                <span class="asp-share-label">Share:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                    target="_blank" rel="noopener" class="asp-share-btn" aria-label="Share on Facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode($product_name); ?>"
                    target="_blank" rel="noopener" class="asp-share-btn" aria-label="Share on Twitter">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path
                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                    </svg>
                </a>
            </div>

            <!-- ── Shipping & Returns blurb ──────── -->
            <div class="asp-reassurance">
                <div class="asp-reassurance-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                    <span>Free shipping on orders over $100</span>
                </div>
                <div class="asp-reassurance-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M9 14l6-6M15 14l-6-6" />
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                    <span>30-day easy returns</span>
                </div>
            </div>

        </div><!-- .asp-info-section -->
    </div><!-- .asp-main-wrapper -->

    <!-- ═══════════════════════════════════════════════
             ACCORDION TABS — Description / Info / Reviews
        ════════════════════════════════════════════════ -->
    <div class="asp-tabs-section">

        <!-- Description -->
        <?php $description = $product->get_description(); ?>
        <?php if ($description): ?>
            <div class="asp-accordion" id="aspTabDesc">
                <button class="asp-accordion-trigger asp-accordion-trigger--open" aria-expanded="true"
                    data-target="aspDescBody">
                    Description
                    <svg class="asp-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div class="asp-accordion-body" id="aspDescBody">
                    <div class="asp-accordion-content">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Additional Info (attributes) -->
        <?php $attributes = $product->get_attributes(); ?>
        <?php if (!empty($attributes)): ?>
            <div class="asp-accordion" id="aspTabInfo">
                <button class="asp-accordion-trigger" aria-expanded="false" data-target="aspInfoBody">
                    Additional Information
                    <svg class="asp-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div class="asp-accordion-body asp-accordion-body--closed" id="aspInfoBody">
                    <div class="asp-accordion-content">
                        <table class="asp-attr-table">
                            <?php foreach ($attributes as $attribute): ?>
                                <tr>
                                    <th>
                                        <?php echo esc_html(wc_attribute_label($attribute->get_name())); ?>
                                    </th>
                                    <td>
                                        <?php echo esc_html(implode(', ', $attribute->get_options())); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Reviews -->
        <?php if (comments_open()): ?>
            <div class="asp-accordion" id="aspTabReviews">
                <button class="asp-accordion-trigger" aria-expanded="false" data-target="aspReviewsBody">
                    Reviews (
                    <?php echo esc_html($rating_count); ?>)
                    <svg class="asp-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div class="asp-accordion-body asp-accordion-body--closed" id="aspReviewsBody">
                    <div class="asp-accordion-content">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div><!-- .asp-tabs-section -->

    <!-- ═══════════════════════════════════════════════
             RELATED PRODUCTS
        ════════════════════════════════════════════════ -->
    <?php
    $related_ids = wc_get_related_products($product_id, 4);
    if (!empty($related_ids)):
        ?>
        <div class="asp-related-section">
            <h2 class="asp-related-title">You May Also Like</h2>
            <div class="asp-related-grid">
                <?php foreach ($related_ids as $related_id):
                    $related = wc_get_product($related_id);
                    if (!$related)
                        continue;
                    ?>
                    <a href="<?php echo esc_url(get_permalink($related_id)); ?>" class="asp-related-card">
                        <div class="asp-related-img-wrap">
                            <?php echo $related->get_image('woocommerce_thumbnail'); ?>
                        </div>
                        <div class="asp-related-info">
                            <h3 class="asp-related-name">
                                <?php echo esc_html($related->get_name()); ?>
                            </h3>
                            <div class="asp-related-price">
                                <?php echo wp_kses_post($related->get_price_html()); ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div><!-- .amira-single-product -->

<?php do_action('woocommerce_after_single_product'); ?>