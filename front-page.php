<?php
/**
 * Front Page Template (Homepage)
 * 
 * Hero Slider with Full-Width Background Images
 * 
 * @package Antigravity
 * @since 1.0.0
 */

get_header(); ?>

<!-- Hero Slider Section -->
<section class="hero-slider-section">

    <!-- Dark gradient at top to ensure white header text is always readable -->
    <div class="hero-top-gradient" aria-hidden="true"></div>

    <!-- Floating NEW Badge -->
    <div class="hero-badge" aria-hidden="true">NEW</div>



    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">

            <?php
            // Query Hero Slides
            $hero_slides = new WP_Query(array(
                'post_type' => 'hero_slide',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ));

            if ($hero_slides->have_posts()):
                while ($hero_slides->have_posts()):
                    $hero_slides->the_post();

                    $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full');

                    if ($bg_image):
                        $button_text = get_post_meta(get_the_ID(), '_hero_button_text', true);
                        $button_url = get_post_meta(get_the_ID(), '_hero_button_url', true);

                        if (empty($button_text)) {
                            $button_text = 'SHOP NOW';
                        }
                        if (empty($button_url)) {
                            $button_url = home_url('/shop');
                        }
                        ?>

                        <div class="swiper-slide" style="background-image: url('<?php echo esc_url($bg_image); ?>');"></div>

                        <?php
                    endif;
                endwhile;
                wp_reset_postdata();
            else:
                ?>
                <div class="swiper-slide" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d4a2d 100%);"></div>
                <?php
            endif;
            ?>

        </div><!-- .swiper-wrapper -->

        <!-- Progress Bar Pagination -->
        <div class="hero-progress-bar" aria-hidden="true">
            <div class="hero-progress-fill"></div>
        </div>

    </div><!-- .swiper -->

    <!-- Scroll-Down Arrow -->
    <div class="hero-scroll-arrow" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 5v14M5 12l7 7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>

</section><!-- .hero-slider-section -->



<!-- Category Promo Grid Section -->
<section class="category-grid-section">
    <div class="container">
        <div class="category-grid">

            <?php
            // Query Category Banners
            $category_banners = new WP_Query(array(
                'post_type' => 'category_banner',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ));

            if ($category_banners->have_posts()):
                while ($category_banners->have_posts()):
                    $category_banners->the_post();

                    // Only display banners with featured images
                    if (has_post_thumbnail()):
                        $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $button_link = get_post_meta(get_the_ID(), '_category_button_link', true);
                        $button_text = get_post_meta(get_the_ID(), '_category_button_text', true);

                        // Default values
                        if (empty($button_text)) {
                            $button_text = 'READ MORE';
                        }
                        if (empty($button_link)) {
                            $button_link = '#';
                        }
                        ?>

                        <div class="category-banner-item" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
                            <div class="banner-overlay"></div>
                            <div class="banner-content">
                                <?php if (get_the_content()): ?>
                                    <p class="banner-subtitle"><?php echo wp_strip_all_tags(get_the_content()); ?></p>
                                <?php endif; ?>
                                <h3 class="banner-title"><?php the_title(); ?></h3>
                                <a href="<?php echo esc_url($button_link); ?>" class="banner-button">
                                    <?php echo esc_html($button_text); ?>
                                </a>
                            </div>
                        </div>

                        <?php
                    endif;
                endwhile;
                wp_reset_postdata();
            else:
                // Fallback: Show placeholder banners
                for ($i = 1; $i <= 3; $i++):
                    ?>
                    <div class="category-banner-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="banner-overlay"></div>
                        <div class="banner-content">
                            <p class="banner-subtitle">NEW COLLECTION</p>
                            <h3 class="banner-title">Category <?php echo $i; ?></h3>
                            <a href="<?php echo admin_url('post-new.php?post_type=category_banner'); ?>" class="banner-button">
                                CREATE BANNER
                            </a>
                        </div>
                    </div>
                    <?php
                endfor;
            endif;
            ?>

        </div><!-- .category-grid -->
    </div><!-- .container -->
</section><!-- .category-grid-section -->


<!-- Featured Products Section -->
<section class="featured-products-section">
    <div class="container">
        <h2 class="section-title featured-products-title">Featured Products</h2>

        <div class="product-grid">

            <?php
            // Query Featured Products (WooCommerce)
            $featured_products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 16,
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            if ($featured_products->have_posts()):
                while ($featured_products->have_posts()):
                    $featured_products->the_post();

                    // Get WooCommerce product object
                    global $product;

                    // Get product data
                    $product_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    $product_title = get_the_title();
                    $product_link = get_permalink();

                    // Get product categories
                    $categories = get_the_terms(get_the_ID(), 'product_cat');
                    $category_name = '';
                    if ($categories && !is_wp_error($categories)) {
                        $category_name = $categories[0]->name;
                    }

                    // Get product price
                    $price = $product ? $product->get_price_html() : '';
                    ?>

                    <div class="product-card" data-animate="fade-up">
                        <!-- Wishlist heart -->
                        <button class="product-wishlist" aria-label="Add to wishlist">&#9825;</button>

                        <a href="<?php echo esc_url($product_link); ?>" class="product-link">
                            <div class="product-image-wrapper">
                                <?php if ($product_image): ?>
                                    <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_title); ?>"
                                        class="product-image">
                                <?php else: ?>
                                    <div class="product-image-placeholder"></div>
                                <?php endif; ?>
                                <!-- Hover overlay -->
                                <div class="product-image-overlay"></div>
                                <!-- Slide-up Add to Cart -->
                                <div class="product-hover-action">
                                    <span class="product-add-to-cart-label">Add to Cart</span>
                                </div>
                            </div>

                            <div class="product-info">
                                <?php if ($category_name): ?>
                                    <p class="product-category"><?php echo esc_html($category_name); ?></p>
                                <?php endif; ?>

                                <h3 class="product-title"><?php echo esc_html($product_title); ?></h3>

                                <?php if ($price): ?>
                                    <div class="product-price"><?php echo $price; ?></div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>

                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                // Fallback: Show placeholder products
                for ($i = 1; $i <= 8; $i++):
                    ?>
                    <div class="product-card">
                        <a href="<?php echo admin_url('post-new.php?post_type=product'); ?>" class="product-link">
                            <div class="product-image-wrapper">
                                <div class="product-image-placeholder">
                                    <span style="color: #999; font-size: 12px;">No Image</span>
                                </div>
                            </div>

                            <div class="product-info">
                                <p class="product-category">Category</p>
                                <h3 class="product-title">Product <?php echo $i; ?></h3>
                                <div class="product-price"><span class="woocommerce-Price-amount amount">$0.00</span></div>
                            </div>
                        </a>
                    </div>
                    <?php
                endfor;
            endif;
            ?>

        </div><!-- .product-grid -->

        <!-- View All Products CTA -->
        <div class="view-all-wrapper">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="view-all-btn">View All
                Products</a>
        </div>

    </div><!-- .container -->
</section><!-- .featured-products-section -->

<?php get_footer(); ?>