<?php
/**
 * Antigravity Theme Functions
 * 
 * @package Antigravity
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 * Register theme support and features
 */
function antigravity_theme_setup()
{

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Enable HTML5 markup support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary-menu' => esc_html__('Primary Menu', 'antigravity'),
        'footer-menu' => esc_html__('Footer Menu', 'antigravity'),
    ));

    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height' => 50,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // WooCommerce Support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'antigravity_theme_setup');

/**
 * Temporary: Flush permalinks rules
 * Note: Remove this after verifying correct paths
 */
add_action('init', function() {
    flush_rewrite_rules();
});

/**
 * Enqueue Scripts and Styles
 */
function antigravity_enqueue_assets()
{

    // Enqueue main stylesheet
    wp_enqueue_style(
        'antigravity-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue Dashicons (for header icons)
    wp_enqueue_style('dashicons');

    // Enqueue Google Fonts - Cormorant Garamond (headings) + Inter (body)
    wp_enqueue_style(
        'antigravity-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Enqueue main JavaScript
    wp_enqueue_script(
        'antigravity-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'antigravity_enqueue_assets');

/**
 * Set Content Width
 */
if (!isset($content_width)) {
    $content_width = 1200;
}

/**
 * Custom Menu Walker (Optional - for future dropdown styling)
 * Uncomment and customize if needed for advanced menu features
 */
// class Antigravity_Walker_Nav_Menu extends Walker_Nav_Menu {
//     // Custom walker methods here
// }

/**
 * Load Core Functionality
 * Uncomment when inc/core.php is created
 */
// require_once get_template_directory() . '/inc/core.php';

/* ========================================
   CUSTOM POST TYPE: Hero Slides
======================================== */

/**
 * Register Hero Slide Custom Post Type
 */
function antigravity_register_hero_slides() {
    $labels = array(
        'name'               => 'Hero Slides',
        'singular_name'      => 'Hero Slide',
        'menu_name'          => 'Hero Slides',
        'add_new'            => 'Add New Slide',
        'add_new_item'       => 'Add New Hero Slide',
        'edit_item'          => 'Edit Hero Slide',
        'new_item'           => 'New Hero Slide',
        'view_item'          => 'View Hero Slide',
        'search_items'       => 'Search Hero Slides',
        'not_found'          => 'No hero slides found',
        'not_found_in_trash' => 'No hero slides found in Trash',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-images-alt2',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => false,
    );

    register_post_type( 'hero_slide', $args );
}
add_action( 'init', 'antigravity_register_hero_slides' );

/**
 * Add Meta Boxes for Hero Slides
 */
function antigravity_hero_slide_meta_boxes() {
    add_meta_box(
        'hero_slide_settings',
        'Slide Settings',
        'antigravity_hero_slide_settings_callback',
        'hero_slide',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'antigravity_hero_slide_meta_boxes' );

/**
 * Customize Featured Image Meta Box Label
 */
function antigravity_hero_slide_featured_image_label() {
    remove_meta_box( 'postimagediv', 'hero_slide', 'side' );
    add_meta_box(
        'postimagediv',
        'Hero Slide Background Image',
        'post_thumbnail_meta_box',
        'hero_slide',
        'side',
        'high'
    );
}
add_action( 'do_meta_boxes', 'antigravity_hero_slide_featured_image_label' );

/**
 * Meta Box Callback
 */
function antigravity_hero_slide_settings_callback( $post ) {
    wp_nonce_field( 'antigravity_hero_slide_meta', 'antigravity_hero_slide_nonce' );
    
    $button_text = get_post_meta( $post->ID, '_hero_button_text', true );
    $button_url  = get_post_meta( $post->ID, '_hero_button_url', true );
    $show_content = get_post_meta( $post->ID, '_hero_show_content', true );
    ?>
    
    <div style="background: #f0f6fc; border: 1px solid #c3e0ff; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        <p style="margin: 0; color: #0969da;">
            <strong>📸 Background Image:</strong> Use the "Hero Slide Background Image" box on the right sidebar to set the slide's background image.
        </p>
    </div>
    
    <table class="form-table">
        <tr>
            <th><label for="hero_button_text">Button Text</label></th>
            <td>
                <input type="text" 
                       id="hero_button_text" 
                       name="hero_button_text" 
                       value="<?php echo esc_attr( $button_text ); ?>" 
                       class="regular-text" 
                       placeholder="e.g., SHOP NOW">
                <p class="description">Leave empty to hide the button.</p>
            </td>
        </tr>
        <tr>
            <th><label for="hero_button_url">Button URL</label></th>
            <td>
                <input type="url" 
                       id="hero_button_url" 
                       name="hero_button_url" 
                       value="<?php echo esc_url( $button_url ); ?>" 
                       class="regular-text" 
                       placeholder="https://example.com/shop">
            </td>
        </tr>
        <tr>
            <th><label for="hero_show_content">Show Content?</label></th>
            <td>
                <label>
                    <input type="checkbox" 
                           id="hero_show_content" 
                           name="hero_show_content" 
                           value="1" 
                           <?php checked( $show_content, '1' ); ?>>
                    Display headline and text on this slide
                </label>
                <p class="description">Uncheck to show only the background image.</p>
            </td>
        </tr>
    </table>
    
    <?php
}

/**
 * Save Meta Box Data
 */
function antigravity_save_hero_slide_meta( $post_id ) {
    // Security checks
    if ( ! isset( $_POST['antigravity_hero_slide_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['antigravity_hero_slide_nonce'], 'antigravity_hero_slide_meta' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save Button Text
    if ( isset( $_POST['hero_button_text'] ) ) {
        update_post_meta( $post_id, '_hero_button_text', sanitize_text_field( $_POST['hero_button_text'] ) );
    }
    
    // Save Button URL
    if ( isset( $_POST['hero_button_url'] ) ) {
        update_post_meta( $post_id, '_hero_button_url', esc_url_raw( $_POST['hero_button_url'] ) );
    }
    
    // Save Show Content
    $show_content = isset( $_POST['hero_show_content'] ) ? '1' : '0';
    update_post_meta( $post_id, '_hero_show_content', $show_content );
}
add_action( 'save_post_hero_slide', 'antigravity_save_hero_slide_meta' );

/**
 * Enqueue Swiper.js for Hero Slider
 */
function antigravity_enqueue_swiper() {
    // Only load on front page
    if ( is_front_page() ) {
        // Swiper CSS
        wp_enqueue_style(
            'swiper-css',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11.0.0'
        );
        
        // Swiper JS
        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11.0.0',
            true
        );
        
        // Custom Swiper Initialization
        wp_add_inline_script(
            'swiper-js',
            "
            document.addEventListener('DOMContentLoaded', function() {
                const heroSwiper = new Swiper('.hero-swiper', {
                    loop: true,
                    effect: 'fade',
                    speed: 900,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                });
            });
            "
        );
    }
}
add_action( 'wp_enqueue_scripts', 'antigravity_enqueue_swiper', 20 );


/* ========================================
   CUSTOM POST TYPE: Category Banners
======================================== */

/**
 * Register Category Banner Custom Post Type
 */
function antigravity_register_category_banners() {
    $labels = array(
        'name'                  => _x('Category Banners', 'Post Type General Name', 'antigravity'),
        'singular_name'         => _x('Category Banner', 'Post Type Singular Name', 'antigravity'),
        'menu_name'             => __('Category Banners', 'antigravity'),
        'name_admin_bar'        => __('Category Banner', 'antigravity'),
        'archives'              => __('Category Banner Archives', 'antigravity'),
        'attributes'            => __('Category Banner Attributes', 'antigravity'),
        'parent_item_colon'     => __('Parent Category Banner:', 'antigravity'),
        'all_items'             => __('All Category Banners', 'antigravity'),
        'add_new_item'          => __('Add New Category Banner', 'antigravity'),
        'add_new'               => __('Add New', 'antigravity'),
        'new_item'              => __('New Category Banner', 'antigravity'),
        'edit_item'             => __('Edit Category Banner', 'antigravity'),
        'update_item'           => __('Update Category Banner', 'antigravity'),
        'view_item'             => __('View Category Banner', 'antigravity'),
        'view_items'            => __('View Category Banners', 'antigravity'),
        'search_items'          => __('Search Category Banner', 'antigravity'),
        'not_found'             => __('Not found', 'antigravity'),
        'not_found_in_trash'    => __('Not found in Trash', 'antigravity'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-grid-view',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => false,
    );

    register_post_type('category_banner', $args);
}
add_action('init', 'antigravity_register_category_banners');

/**
 * Add Meta Box for Category Banner Settings
 */
function antigravity_add_category_banner_meta_box() {
    add_meta_box(
        'category_banner_settings',
        __('Category Banner Settings', 'antigravity'),
        'antigravity_category_banner_settings_callback',
        'category_banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'antigravity_add_category_banner_meta_box');

/**
 * Meta Box Callback
 */
function antigravity_category_banner_settings_callback($post) {
    wp_nonce_field('antigravity_save_category_banner_meta', 'antigravity_category_banner_nonce');

    $button_link = get_post_meta($post->ID, '_category_button_link', true);
    $button_text = get_post_meta($post->ID, '_category_button_text', true);
    
    // Default button text
    if (empty($button_text)) {
        $button_text = 'READ MORE';
    }
    ?>

    <div style="background: #f0f6fc; border: 1px solid #c3e0ff; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        <p style="margin: 0; color: #0969da;">
            <strong>📸 Background Image:</strong> Use the "Featured Image" box on the right sidebar to set the banner's background image.
        </p>
    </div>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="category_button_link"><?php _e('Button Link (URL)', 'antigravity'); ?></label>
            </th>
            <td>
                <input type="url" 
                       id="category_button_link" 
                       name="category_button_link" 
                       value="<?php echo esc_url($button_link); ?>" 
                       class="regular-text"
                       placeholder="https://example.com/category">
                <p class="description"><?php _e('Enter the URL where the button should link to.', 'antigravity'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="category_button_text"><?php _e('Button Text', 'antigravity'); ?></label>
            </th>
            <td>
                <input type="text" 
                       id="category_button_text" 
                       name="category_button_text" 
                       value="<?php echo esc_attr($button_text); ?>" 
                       class="regular-text"
                       placeholder="READ MORE">
                <p class="description"><?php _e('Default: "READ MORE"', 'antigravity'); ?></p>
            </td>
        </tr>
    </table>

    <?php
}

/**
 * Save Meta Box Data
 */
function antigravity_save_category_banner_meta($post_id) {
    // Check nonce
    if (!isset($_POST['antigravity_category_banner_nonce']) || 
        !wp_verify_nonce($_POST['antigravity_category_banner_nonce'], 'antigravity_save_category_banner_meta')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Button Link
    if (isset($_POST['category_button_link'])) {
        update_post_meta($post_id, '_category_button_link', esc_url_raw($_POST['category_button_link']));
    }

    // Save Button Text
    if (isset($_POST['category_button_text'])) {
        update_post_meta($post_id, '_category_button_text', sanitize_text_field($_POST['category_button_text']));
    }
}
add_action('save_post', 'antigravity_save_category_banner_meta');

/**
 * Set Featured Image as "Category Banner Background"
 */
function antigravity_category_banner_featured_image_label($content) {
    global $post_type;
    if ($post_type === 'category_banner') {
        $content = str_replace('Set featured image', 'Set Category Banner Background', $content);
        $content = str_replace('Remove featured image', 'Remove Background Image', $content);
    }
    return $content;
}
add_filter('admin_post_thumbnail_html', 'antigravity_category_banner_featured_image_label');


/* ========================================
   WOOCOMMERCE — Disable Coming Soon Mode
   Disables the WC 'Something big is brewing' overlay
   that blocks the shop from showing products.
======================================== */
add_filter( 'woocommerce_coming_soon', '__return_false' );
// Also disable via option in case the filter is ignored by the WC version
add_action( 'init', function () {
    if ( get_option( 'woocommerce_coming_soon' ) === 'yes' ) {
        update_option( 'woocommerce_coming_soon', 'no' );
    }
} );


/* ========================================
   EXCLUDE AUTH PAGES FROM NAV MENUS

   Removes Login / Register / Forgot Password
   items from navigation menus at PHP level.
======================================== */
add_filter( 'wp_get_nav_menu_items', function ( $items ) {
    $auth_slugs = array( 'login', 'register', 'forgot-password' );

    foreach ( $items as $key => $item ) {
        // Match by object slug (page slug) or by URL fragment
        $item_slug = basename( rtrim( $item->url, '/' ) );

        if ( in_array( $item->post_name, $auth_slugs, true )
            || in_array( $item_slug,      $auth_slugs, true ) ) {
            unset( $items[ $key ] );
        }
    }

    return $items;
}, 10, 1 );


/* ========================================
   AUTO-CREATE AUTH PAGES
   Runs on: theme activation + every init (checks if missing)
======================================== */


/**
 * Programmatically create Login / Register / Forgot Password pages
 * if they do not already exist in the WordPress database.
 * Hooked to after_switch_theme AND init so existing installs also benefit.
 */
function antigravity_create_auth_pages() {
    $pages = array(
        array(
            'title'    => 'Login',
            'slug'     => 'login',
            'template' => 'page-login.php',
        ),
        array(
            'title'    => 'Register',
            'slug'     => 'register',
            'template' => 'page-register.php',
        ),
        array(
            'title'    => 'Forgot Password',
            'slug'     => 'forgot-password',
            'template' => 'page-forgot-password.php',
        ),
    );

    foreach ( $pages as $page_data ) {
        // Check if the page already exists by slug
        $existing = get_page_by_path( $page_data['slug'], OBJECT, 'page' );

        if ( ! $existing ) {
            $page_id = wp_insert_post( array(
                'post_title'    => $page_data['title'],
                'post_name'     => $page_data['slug'],
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_author'   => 1,
                'post_content'  => '',
                'comment_status'=> 'closed',
            ) );

            if ( $page_id && ! is_wp_error( $page_id ) ) {
                // Assign the page template
                update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
            }
        } else {
            // Page exists — make sure the correct template is assigned
            $current_template = get_post_meta( $existing->ID, '_wp_page_template', true );
            if ( $current_template !== $page_data['template'] ) {
                update_post_meta( $existing->ID, '_wp_page_template', $page_data['template'] );
            }
        }
    }

    // Flush rewrite rules so the new slugs resolve immediately
    flush_rewrite_rules();
}
// Run on theme activation
add_action( 'after_switch_theme', 'antigravity_create_auth_pages' );
// Also run once on init in case theme was already active (transient guard)
add_action( 'init', function () {
    if ( ! get_transient( 'amira_auth_pages_created_v2' ) ) {
        antigravity_create_auth_pages();
        set_transient( 'amira_auth_pages_created_v2', true, DAY_IN_SECONDS );
    }
} );


/* ========================================
   AUTH SYSTEM: Login / Register / Logout
======================================== */

/**
 * Localize AJAX data to main.js so JavaScript can call wp-admin/admin-ajax.php
 */

function antigravity_localize_auth_data() {
    wp_localize_script(
        'antigravity-main',
        'amiraAjax',
        array(
            'ajaxUrl'         => admin_url( 'admin-ajax.php' ),
            'loginNonce'      => wp_create_nonce( 'amira_login_nonce' ),
            'registerNonce'   => wp_create_nonce( 'amira_register_nonce' ),
            'logoutNonce'     => wp_create_nonce( 'amira_logout_nonce' ),
            'forgotNonce'     => wp_create_nonce( 'amira_forgot_nonce' ),
            'myAccountUrl'    => function_exists( 'wc_get_page_permalink' )
                                     ? wc_get_page_permalink( 'myaccount' )
                                     : home_url( '/my-account/' ),
            'homeUrl'         => home_url( '/' ),
            'loginPageUrl'    => get_permalink( get_page_by_path( 'login' ) ),
            'registerPageUrl' => get_permalink( get_page_by_path( 'register' ) ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'antigravity_localize_auth_data', 30 );


/**
 * Auto-redirect already-logged-in users away from auth pages
 */
function antigravity_redirect_logged_in_from_auth() {
    if ( ! is_user_logged_in() ) {
        return;
    }

    $auth_slugs = array( 'login', 'register', 'forgot-password' );
    $queried    = get_queried_object();

    if ( $queried instanceof WP_Post && in_array( $queried->post_name, $auth_slugs, true ) ) {
        $redirect = function_exists( 'wc_get_page_permalink' )
            ? wc_get_page_permalink( 'myaccount' )
            : home_url( '/' );
        wp_safe_redirect( $redirect );
        exit;
    }
}
add_action( 'template_redirect', 'antigravity_redirect_logged_in_from_auth' );


/* ------ Helpers ------ */

/**
 * Get the IP address of the visitor for rate limiting.
 *
 * @return string
 */
function antigravity_get_client_ip() {
    $ip = '';
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
    } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
        $ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
    }
    return preg_replace( '/[^0-9a-f:.,]/', '', $ip );
}

/**
 * Check and increment failed login attempts; returns true if locked out.
 *
 * @param string $identifier Username or email used.
 * @return bool True = locked out.
 */
function antigravity_check_rate_limit( $identifier ) {
    $ip          = antigravity_get_client_ip();
    $key         = 'amira_login_fail_' . md5( $ip . $identifier );
    $max_attempts = 5;
    $lockout_secs = 15 * MINUTE_IN_SECONDS;

    $attempts = (int) get_transient( $key );

    if ( $attempts >= $max_attempts ) {
        return true; // Locked out
    }

    return false;
}

/**
 * Increment failed login counter.
 *
 * @param string $identifier Username or email.
 */
function antigravity_increment_failed_login( $identifier ) {
    $ip          = antigravity_get_client_ip();
    $key         = 'amira_login_fail_' . md5( $ip . $identifier );
    $attempts    = (int) get_transient( $key );
    $lockout_secs = 15 * MINUTE_IN_SECONDS;

    set_transient( $key, $attempts + 1, $lockout_secs );
}

/**
 * Clear failed login counter on successful login.
 *
 * @param string $identifier Username or email.
 */
function antigravity_clear_failed_login( $identifier ) {
    $ip  = antigravity_get_client_ip();
    $key = 'amira_login_fail_' . md5( $ip . $identifier );
    delete_transient( $key );
}


/* ------ AJAX: Login ------ */

/**
 * Handle AJAX login for logged-out users.
 */
function antigravity_ajax_login() {
    // Nonce check
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'amira_login_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page.' ) );
    }

    $user_login = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
    $password   = isset( $_POST['pwd'] ) ? wp_unslash( $_POST['pwd'] ) : '';
    $rememberme = isset( $_POST['rememberme'] ) && $_POST['rememberme'] === 'forever';

    // Basic validation
    if ( empty( $user_login ) || empty( $password ) ) {
        wp_send_json_error( array( 'message' => 'Please enter your email/username and password.' ) );
    }

    // Rate limiting
    if ( antigravity_check_rate_limit( $user_login ) ) {
        wp_send_json_error( array(
            'message'  => 'Too many failed attempts. Your account is temporarily locked for 15 minutes.',
            'locked'   => true,
        ) );
    }

    // Attempt sign-on
    $creds = array(
        'user_login'    => $user_login,
        'user_password' => $password,
        'remember'      => $rememberme,
    );

    $user = wp_signon( $creds, is_ssl() );

    if ( is_wp_error( $user ) ) {
        antigravity_increment_failed_login( $user_login );

        $error_code = $user->get_error_code();

        if ( $error_code === 'invalid_username' || $error_code === 'invalid_email' ) {
            $message = 'No account found with that email or username.';
        } elseif ( $error_code === 'incorrect_password' ) {
            $message = 'Incorrect password. Please try again.';
        } else {
            $message = $user->get_error_message();
        }

        wp_send_json_error( array( 'message' => wp_strip_all_tags( $message ) ) );
    }

    // Success — redirect to homepage after login
    antigravity_clear_failed_login( $user_login );

    wp_send_json_success( array(
        'message'     => 'Login successful! Redirecting…',
        'redirectUrl' => home_url( '/' ),
    ) );
}
add_action( 'wp_ajax_nopriv_amira_ajax_login', 'antigravity_ajax_login' );
add_action( 'wp_ajax_amira_ajax_login',        'antigravity_ajax_login' ); // already-logged-in edge case

// WooCommerce login redirect → homepage (covers standard WC login form too)
add_filter( 'woocommerce_login_redirect', function( $redirect, $user ) {
    return home_url( '/' );
}, 10, 2 );


/* ------ AJAX: Register ------ */

/**
 * Handle AJAX registration.
 */
function antigravity_ajax_register() {
    // Nonce check
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'amira_register_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page.' ) );
    }

    // Check if registrations are open
    if ( ! get_option( 'users_can_register' ) ) {
        wp_send_json_error( array( 'message' => 'User registration is currently disabled.' ) );
    }

    $fullname        = isset( $_POST['fullname'] )         ? sanitize_text_field( wp_unslash( $_POST['fullname'] ) )  : '';
    $email           = isset( $_POST['email'] )            ? sanitize_email( wp_unslash( $_POST['email'] ) )          : '';
    $password        = isset( $_POST['password'] )         ? wp_unslash( $_POST['password'] )                         : '';
    $confirm_password = isset( $_POST['confirm_password'] ) ? wp_unslash( $_POST['confirm_password'] )                 : '';

    // Validation
    if ( empty( $fullname ) ) {
        wp_send_json_error( array( 'message' => 'Please enter your full name.', 'field' => 'fullname' ) );
    }

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.', 'field' => 'email' ) );
    }

    if ( email_exists( $email ) ) {
        wp_send_json_error( array( 'message' => 'This email address is already registered.', 'field' => 'email' ) );
    }

    if ( strlen( $password ) < 8 ) {
        wp_send_json_error( array( 'message' => 'Password must be at least 8 characters long.', 'field' => 'password' ) );
    }

    if ( $password !== $confirm_password ) {
        wp_send_json_error( array( 'message' => 'Passwords do not match.', 'field' => 'confirm_password' ) );
    }

    // Generate a unique username from email
    $username = sanitize_user( current( explode( '@', $email ) ), true );
    if ( username_exists( $username ) ) {
        $username = $username . '_' . wp_rand( 100, 999 );
    }

    // Create the user
    $user_id = wp_create_user( $username, $password, $email );

    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error( array( 'message' => wp_strip_all_tags( $user_id->get_error_message() ) ) );
    }

    // Set display name from full name
    $name_parts   = explode( ' ', $fullname, 2 );
    $first_name   = $name_parts[0];
    $last_name    = isset( $name_parts[1] ) ? $name_parts[1] : '';

    wp_update_user( array(
        'ID'           => $user_id,
        'display_name' => $fullname,
        'first_name'   => $first_name,
        'last_name'    => $last_name,
    ) );

    // WooCommerce: set customer role
    if ( class_exists( 'WooCommerce' ) ) {
        $user = new WP_User( $user_id );
        $user->set_role( 'customer' );
    }

    // Auto-login the new user
    wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id, true );
    do_action( 'wp_login', $username, get_user_by( 'id', $user_id ) );

    $redirect = function_exists( 'wc_get_page_permalink' )
        ? wc_get_page_permalink( 'myaccount' )
        : home_url( '/' );

    wp_send_json_success( array(
        'message'     => 'Account created! Welcome to AMIRA.',
        'redirectUrl' => $redirect,
    ) );
}
add_action( 'wp_ajax_nopriv_amira_ajax_register', 'antigravity_ajax_register' );
add_action( 'wp_ajax_amira_ajax_register',        'antigravity_ajax_register' );


/* ------ AJAX: Logout ------ */

/**
 * Handle AJAX logout for logged-in users.
 */
function antigravity_ajax_logout() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'amira_logout_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
    }

    wp_logout();

    wp_send_json_success( array(
        'message'     => 'Logged out successfully.',
        'redirectUrl' => home_url( '/' ),
    ) );
}
add_action( 'wp_ajax_amira_ajax_logout', 'antigravity_ajax_logout' );


/* ------ AJAX: Forgot Password ------ */

/**
 * Handle AJAX forgot password email.
 */
function antigravity_ajax_forgot_password() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'amira_forgot_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page.' ) );
    }

    $user_login = isset( $_POST['user_login'] ) ? sanitize_email( wp_unslash( $_POST['user_login'] ) ) : '';

    if ( empty( $user_login ) || ! is_email( $user_login ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ) );
    }

    $result = retrieve_password( $user_login );

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( array( 'message' => wp_strip_all_tags( $result->get_error_message() ) ) );
    }

    wp_send_json_success( array( 'message' => 'Reset link sent! Please check your email inbox.' ) );
}
add_action( 'wp_ajax_nopriv_amira_ajax_forgot_password', 'antigravity_ajax_forgot_password' );
add_action( 'wp_ajax_amira_ajax_forgot_password',        'antigravity_ajax_forgot_password' );

/* ============================================================
   SINGLE PRODUCT PAGE CUSTOMIZATION
============================================================ */

/**
 * 7. Add breadcrumbs config (already manually placed in single-product.php)
 * This hooks it in case WooCommerce default templates are ever used
 */
add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 5 );

/**
 * 8. Add stock warning — "Only X left!" if stock less than 5
 */
add_action('woocommerce_single_product_summary', function() {
    global $product;
    if ($product && $product->get_stock_quantity() < 5 && $product->get_stock_quantity() > 0) {
        echo '<p class="low-stock-warning" style="background:#fff3e0;color:#e65100;font-size:11px;font-weight:600;padding:2px 8px;border-radius:3px;display:inline-block;">Only ' . esc_html($product->get_stock_quantity()) . ' left!</p>';
    }
}, 25);

/**
 * 9. Remove default WooCommerce tabs
 * (Replaced with custom accordion in single-product.php)
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

/**
 * 10. Make sure related products show maximum 4 items
 */
add_filter( 'woocommerce_output_related_products_args', function( $args ) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
});
