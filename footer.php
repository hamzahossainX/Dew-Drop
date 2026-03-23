<?php
/**
 * Footer Template — AMIRA Theme
 */
?>

<!-- ===================================================
     SITE FOOTER
=================================================== -->
<footer class="site-footer" id="site-footer">

    <!-- Subtle top accent border is handled by CSS ::before -->

    <div class="footer-inner">

        <!-- ── 4-column main grid ── -->
        <div class="footer-grid">

            <!-- Column 1 · Brand -->
            <div class="footer-col footer-col--brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo"
                    aria-label="<?php bloginfo('name'); ?> home">
                    Dew Drop
                </a>
                <p class="footer-tagline">
                    Premium products crafted<br>
                    for modern living.
                </p>

                <!-- Social icons -->
                <div class="footer-social">
                    <a href="#" class="footer-social-link" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                        </svg>
                    </a>
                    <a href="#" class="footer-social-link" aria-label="Facebook" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                        </svg>
                    </a>
                    <a href="#" class="footer-social-link" aria-label="Twitter / X" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4l16 16M4 20 20 4" />
                        </svg>
                    </a>
                    <a href="#" class="footer-social-link" aria-label="Pinterest" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.03-2.83.19-.77 1.27-5.38 1.27-5.38s-.32-.65-.32-1.6c0-1.5.87-2.63 1.95-2.63.92 0 1.37.69 1.37 1.52 0 .93-.59 2.31-.9 3.59-.25 1.07.54 1.95 1.59 1.95 1.91 0 3.19-2.45 3.19-5.35 0-2.2-1.49-3.74-3.63-3.74-2.47 0-3.92 1.85-3.92 3.77 0 .75.29 1.55.64 1.99a.26.26 0 0 1 .06.24c-.07.27-.21.86-.24.98-.04.16-.13.19-.29.12-1.07-.5-1.74-2.07-1.74-3.33 0-2.71 1.97-5.2 5.68-5.2 2.98 0 5.3 2.12 5.3 4.96 0 2.96-1.87 5.34-4.46 5.34-.87 0-1.69-.45-1.97-1l-.54 2.01c-.19.74-.71 1.67-1.06 2.23.8.25 1.65.38 2.52.38 5.52 0 10-4.48 10-10S17.52 2 12 2z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Column 2 · Quick Links -->
            <div class="footer-col footer-col--links">
                <h3 class="footer-col-heading">Quick Links</h3>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="footer-nav-link">Home</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"
                            class="footer-nav-link">Shop</a></li>
                    <li><a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="footer-nav-link">Cart</a></li>
                    <li><a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="footer-nav-link">Checkout</a>
                    </li>
                    <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                            class="footer-nav-link">My Account</a></li>
                </ul>
            </div>

            <!-- Column 3 · Customer Care -->
            <div class="footer-col footer-col--care">
                <h3 class="footer-col-heading">Customer Care</h3>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/faq')); ?>" class="footer-nav-link">FAQ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>" class="footer-nav-link">Shipping
                            Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>" class="footer-nav-link">Return
                            Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="footer-nav-link">Privacy
                            Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="footer-nav-link">Contact Us</a>
                    </li>
                </ul>
            </div>

            <!-- Column 4 · Newsletter -->
            <div class="footer-col footer-col--newsletter">
                <h3 class="footer-col-heading">Stay Updated</h3>
                <p class="footer-newsletter-text">
                    Subscribe to get exclusive offers and new arrivals.
                </p>
                <form class="footer-newsletter-form" action="#" method="post">
                    <div class="footer-newsletter-fields">
                        <input type="email" name="footer_email" class="footer-newsletter-input"
                            placeholder="Your email address" required aria-label="Email address">
                        <button type="submit" class="footer-newsletter-btn">Subscribe</button>
                    </div>
                </form>
            </div>

        </div><!-- .footer-grid -->

        <!-- ── Bottom bar ── -->
        <div class="footer-bottom">
            <span class="footer-copyright">
                &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.
            </span>
            <span class="footer-made-with">
                Made with <span class="footer-heart" aria-label="love">&#9829;</span> in Bangladesh
            </span>
        </div>

    </div><!-- .footer-inner -->

</footer><!-- .site-footer -->


<!-- ===================================================
     SHOP PAGE OVERLAYS & MODALS
=================================================== -->
<!-- Quick View Modal Placeholder -->
<div class="amira-quick-view-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close" aria-label="Close modal">&times;</button>
        <div class="modal-body">
            <div class="amira-skeleton skeleton-img"></div>
            <div class="amira-skeleton skeleton-text"></div>
            <div class="amira-skeleton skeleton-text short"></div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button class="amira-back-to-top" aria-label="Back to top">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 15l-6-6-6 6" />
    </svg>
</button>

<?php wp_footer(); ?>
</body>

</html>

<!-- Theme Interactions Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ---- Mobile Menu Toggle ----
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const body = document.body;

        if (mobileToggle) {
            mobileToggle.addEventListener('click', function () {
                body.classList.toggle('menu-open');
            });

            const menuLinks = document.querySelectorAll('.primary-menu a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function () {
                    body.classList.remove('menu-open');
                });
            });
        }

        // ---- Scroll Reveal & Back To Top ----
        const backToTopBtn = document.querySelector('.amira-back-to-top');
        const reveals = document.querySelectorAll('.amira-reveal');

        function handleScroll() {
            // Reveal elements
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 50;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('visible');
                }
            }

            // Back to top button visibility (show after 400px)
            if (backToTopBtn) {
                if (window.scrollY > 400) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            }
        }

        window.addEventListener('scroll', handleScroll);
        // Trigger once on load
        handleScroll();

        // Back to top click behavior
        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // ---- Quick View Modal ----
        const quickViewBtns = document.querySelectorAll('.amira-quickview-btn');
        const modal = document.querySelector('.amira-quick-view-modal');
        const modalClose = document.querySelector('.modal-close');
        const modalOverlay = document.querySelector('.modal-overlay');

        if (modal && modalClose && modalOverlay) {
            quickViewBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    modal.classList.add('active');
                });
            });
            modalClose.addEventListener('click', () => modal.classList.remove('active'));
            modalOverlay.addEventListener('click', () => modal.classList.remove('active'));

            // Close on escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    modal.classList.remove('active');
                }
            });
        }
    });
</script>