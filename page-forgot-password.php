<?php
/**
 * Template Name: Forgot Password Page
 *
 * Standalone auth page — no site header or footer.
 *
 * @package Antigravity
 */

// Redirect logged-in users
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
    <title>Reset Password &mdash; <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body class="auth-standalone auth-page-forgot-password">

    <main class="auth-page" id="auth-forgot-page">
        <div class="auth-card">

            <!-- Logo -->
            <div class="auth-logo-wrap">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="auth-logo">Dew Drop</a>
            </div>

            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle">Enter your email and we&rsquo;ll send a reset link</p>

            <!-- Forgot Password Form -->
            <form id="amira-forgot-form" class="auth-form" novalidate>
                <?php wp_nonce_field('amira_forgot_nonce', 'amira_forgot_nonce_field'); ?>

                <!-- Email -->
                <div class="auth-field-group">
                    <label class="auth-label" for="forgot-email">Email Address</label>
                    <input type="email" id="forgot-email" name="user_login" class="auth-input"
                        placeholder="you@example.com" autocomplete="email" required>
                    <span class="field-feedback" id="forgot-email-feedback"></span>
                </div>

                <!-- Message Area -->
                <div class="auth-message" id="forgot-message" aria-live="polite"></div>

                <!-- Submit -->
                <button type="submit" class="auth-button" id="forgot-submit-btn">
                    <span class="btn-text">Send Reset Link</span>
                    <span class="btn-spinner" aria-hidden="true"></span>
                </button>
            </form>

            <!-- Back to Login -->
            <p class="auth-footer-link">
                Remember your password?
                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="auth-link">Sign in</a>
            </p>

        </div><!-- .auth-card -->
    </main>

    <?php wp_footer(); ?>
</body>

</html>