<?php
/**
 * Template Name: Login Page
 *
 * Standalone auth page — no site header or footer.
 *
 * @package Antigravity
 */

// Redirect logged-in users to homepage
if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/'));
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Login &mdash; <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body class="auth-standalone auth-page-login">

    <main class="auth-page" id="auth-login-page">
        <div class="auth-card">

            <!-- Logo -->
            <div class="auth-logo-wrap">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="auth-logo">Dew Drop</a>
            </div>

            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your account</p>

            <!-- Login Form -->
            <form id="amira-login-form" class="auth-form" novalidate>
                <?php wp_nonce_field('amira_login_nonce', 'amira_login_nonce_field'); ?>

                <!-- Email / Username -->
                <div class="auth-field-group">
                    <label class="auth-label" for="login-email">Email or Username</label>
                    <input type="text" id="login-email" name="log" class="auth-input" placeholder="you@example.com"
                        autocomplete="username" required>
                </div>

                <!-- Password -->
                <div class="auth-field-group">
                    <label class="auth-label" for="login-password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="login-password" name="pwd" class="auth-input"
                            placeholder="Your password" autocomplete="current-password" required>
                        <button type="button" class="password-toggle" aria-label="Show/hide password"
                            data-target="login-password">
                            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="auth-remember-row">
                    <label class="auth-checkbox-label">
                        <input type="checkbox" id="rememberme" name="rememberme" value="forever">
                        <span class="auth-checkbox-custom"></span>
                        <span class="auth-checkbox-text">Remember me</span>
                    </label>
                    <a href="<?php echo esc_url(home_url('/forgot-password/')); ?>" class="auth-link-small">Forgot
                        password?</a>
                </div>

                <!-- Message Area -->
                <div class="auth-message" id="login-message" aria-live="polite"></div>

                <!-- Submit -->
                <button type="submit" class="auth-button" id="login-submit-btn">
                    <span class="btn-text">Sign In</span>
                    <span class="btn-spinner" aria-hidden="true"></span>
                </button>
            </form>

            <!-- Register Link -->
            <p class="auth-footer-link">
                Don&rsquo;t have an account?
                <a href="<?php echo esc_url(home_url('/register/')); ?>" class="auth-link">Create one</a>
            </p>

        </div><!-- .auth-card -->
    </main>

    <?php wp_footer(); ?>
</body>

</html>