<?php
/**
 * Template Name: Register Page
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
    <title>Create Account &mdash; <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body class="auth-standalone auth-page-register">

    <main class="auth-page" id="auth-register-page">
        <div class="auth-card">

            <!-- Logo -->
            <div class="auth-logo-wrap">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="auth-logo">Dew Drop</a>
            </div>

            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join the Dew Drop family</p>

            <!-- Register Form -->
            <form id="amira-register-form" class="auth-form" novalidate>
                <?php wp_nonce_field('amira_register_nonce', 'amira_register_nonce_field'); ?>

                <!-- Full Name -->
                <div class="auth-field-group">
                    <label class="auth-label" for="reg-fullname">Full Name</label>
                    <input type="text" id="reg-fullname" name="fullname" class="auth-input" placeholder="Jane Doe"
                        autocomplete="name" required>
                    <span class="field-feedback" id="reg-fullname-feedback"></span>
                </div>

                <!-- Email -->
                <div class="auth-field-group">
                    <label class="auth-label" for="reg-email">Email Address</label>
                    <input type="email" id="reg-email" name="email" class="auth-input" placeholder="you@example.com"
                        autocomplete="email" required>
                    <span class="field-feedback" id="reg-email-feedback"></span>
                </div>

                <!-- Password -->
                <div class="auth-field-group">
                    <label class="auth-label" for="reg-password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="reg-password" name="password" class="auth-input"
                            placeholder="Min. 8 characters" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" aria-label="Show/hide password"
                            data-target="reg-password">
                            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    <!-- Password Strength Bar -->
                    <div class="strength-bar-wrap" id="strength-bar-wrap">
                        <div class="strength-bar" id="password-strength-bar"></div>
                    </div>
                    <span class="strength-label" id="strength-label"></span>
                    <span class="field-feedback" id="reg-password-feedback"></span>
                </div>

                <!-- Confirm Password -->
                <div class="auth-field-group">
                    <label class="auth-label" for="reg-confirm-password">Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="reg-confirm-password" name="confirm_password" class="auth-input"
                            placeholder="Repeat your password" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" aria-label="Show/hide password"
                            data-target="reg-confirm-password">
                            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    <span class="field-feedback" id="reg-confirm-feedback"></span>
                </div>

                <!-- Message Area -->
                <div class="auth-message" id="register-message" aria-live="polite"></div>

                <!-- Submit -->
                <button type="submit" class="auth-button" id="register-submit-btn">
                    <span class="btn-text">Create Account</span>
                    <span class="btn-spinner" aria-hidden="true"></span>
                </button>
            </form>

            <!-- Login Link -->
            <p class="auth-footer-link">
                Already have an account?
                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="auth-link">Sign in</a>
            </p>

        </div><!-- .auth-card -->
    </main>

    <?php wp_footer(); ?>
</body>

</html>