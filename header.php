<?php
/**
 * AMIRA Theme Header
 * 3-column flexbox: [Nav] [AMIRA Logo] [User Tools]
 *
 * @package Antigravity
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header" id="site-header">
        <div class="header-container">

            <!-- Left Section: Navigation Menu -->
            <div class="header-left">
                <nav class="header-nav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'menu_class' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>

                    <?php /* Mobile-only account section — hidden on desktop via CSS */ ?>
                    <ul class="mobile-account-menu">
                        <?php if (is_user_logged_in()):
                            $current_user = wp_get_current_user();
                            $first_name = !empty($current_user->first_name) ? $current_user->first_name : $current_user->display_name;
                            $my_account = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
                            $orders_url = $my_account . 'orders/';
                            ?>
                            <li class="mobile-account-item mobile-account-item--name">
                                <span class="dashicons dashicons-admin-users"></span>
                                <?php echo esc_html($first_name); ?>
                            </li>
                            <li class="mobile-account-item">
                                <a href="<?php echo esc_url($my_account); ?>">My Account</a>
                            </li>
                            <li class="mobile-account-item">
                                <a href="<?php echo esc_url($orders_url); ?>">My Orders</a>
                            </li>
                            <li class="mobile-account-item">
                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Logout</a>
                            </li>
                        <?php else:
                            $login_page = get_page_by_path('login');
                            $login_url = $login_page ? get_permalink($login_page->ID) : wp_login_url();
                            ?>
                            <li class="mobile-account-item mobile-login-item">
                                <a href="<?php echo esc_url($login_url); ?>">Login / Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <!-- Center Section: Brand Logo (Perfectly Centered) -->
            <div class="header-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                    <span class="logo-text">Dew Drop</span>
                </a>
            </div>

            <!-- Right Section: User Tools -->
            <div class="header-right">
                <div class="header-tools">

                    <!-- Account Section — Dynamic: Dropdown (logged in) OR Link (logged out) -->
                    <div class="header-account">
                        <?php if (is_user_logged_in()):
                            $current_user = wp_get_current_user();
                            $first_name = !empty($current_user->first_name) ? $current_user->first_name : $current_user->display_name;
                            $my_account = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
                            $orders_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') . 'orders/' : home_url('/my-account/orders/');
                            ?>
                            <!-- User Account Trigger -->
                            <button class="user-account-trigger" id="user-account-trigger" aria-label="Account menu"
                                aria-expanded="false" aria-haspopup="true">
                                <span class="dashicons dashicons-admin-users"></span>
                                <span class="user-first-name"><?php echo esc_html($first_name); ?></span>
                                <svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" aria-hidden="true">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            <!-- Dropdown Panel -->
                            <div class="user-dropdown" id="user-dropdown" role="menu">
                                <a href="<?php echo esc_url($my_account); ?>" class="dropdown-item" role="menuitem">
                                    <span class="dashicons dashicons-admin-users" aria-hidden="true"></span>
                                    My Account
                                </a>
                                <a href="<?php echo esc_url($orders_url); ?>" class="dropdown-item" role="menuitem">
                                    <span class="dashicons dashicons-list-view" aria-hidden="true"></span>
                                    My Orders
                                </a>
                                <button class="dropdown-item dropdown-logout" id="amira-logout-btn" role="menuitem">
                                    <span class="dashicons dashicons-exit" aria-hidden="true"></span>
                                    Logout
                                </button>
                            </div>

                        <?php else: ?>
                            <!-- Not Logged In: Login / Register link -->
                            <a href="<?php
                            $login_page = get_page_by_path('login');
                            echo esc_url($login_page ? get_permalink($login_page->ID) : wp_login_url());
                            ?>" class="login-link tool-link">
                                <span class="dashicons dashicons-admin-users" aria-hidden="true"></span>
                                <span class="login-link-text">Login / Register</span>
                            </a>
                        <?php endif; ?>
                    </div><!-- .header-account -->

                    <!-- Search Icon -->
                    <a href="#" class="tool-link search-link" aria-label="Search">
                        <span class="dashicons dashicons-search"></span>
                    </a>

                    <!-- Wishlist Icon -->
                    <a href="#" class="tool-link wishlist-link" aria-label="Wishlist">
                        <span class="dashicons dashicons-heart"></span>
                    </a>

                    <!-- Cart Icon with Price -->
                    <a href="#" class="tool-link cart-link" aria-label="Shopping Cart">
                        <span class="dashicons dashicons-cart"></span>
                        <span class="cart-price">$0.00</span>
                    </a>

                </div><!-- .header-tools -->
            </div><!-- .header-right -->

            <!-- Mobile Menu Toggle (Hamburger Icon) -->
            <button class="mobile-menu-toggle" aria-label="Toggle mobile menu" aria-expanded="false"
                aria-controls="primary-menu">
                ☰
            </button>

        </div><!-- .header-container -->
    </header><!-- .site-header -->