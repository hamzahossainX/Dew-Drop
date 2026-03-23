<p align="center">
  <img src="https://img.shields.io/badge/WordPress-6.x-21759B?style=flat-square&logo=wordpress&logoColor=white" />
  <img src="https://img.shields.io/badge/WooCommerce-3.0+-96588A?style=flat-square&logo=woocommerce&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=flat-square&logo=javascript&logoColor=black" />
  <img src="https://img.shields.io/badge/CSS3-6500%2B_Lines-1572B6?style=flat-square&logo=css3&logoColor=white" />
  <img src="https://img.shields.io/badge/License-GPL_v2-blue?style=flat-square" />
</p>

<h1 align="center">🌿 Dew Drop — Custom WordPress E-Commerce Theme</h1>

<p align="center">
  <strong>A hand-crafted, premium WooCommerce theme built from scratch — no page builders, no shortcuts.</strong>
  <br/>
  <em>Minimal luxury aesthetic · AJAX-driven auth · Custom post types · Production-ready</em>
</p>

<p align="center">
 
  <a href="#architecture--design-decisions">📐 Architecture</a> ·
  <a href="#installation--setup">⚙️ Setup Guide</a> ·
  <a href="#features">✨ Features</a>
</p>

---

## 📌 Problem & Solution

**Problem:** Most WordPress e-commerce sites rely on heavy page builders (Elementor, Divi) that ship bloated bundles, limit customization control, and make the codebase unmaintainable for any developer who didn't build it.

**Solution:** Dew Drop is a **fully custom WordPress theme** (codenamed *Antigravity*) that delivers a premium shopping experience using only native WordPress APIs, WooCommerce hooks, and hand-written PHP/JS/CSS. Every component — from the transparent-to-solid navbar to the AJAX authentication system — is purpose-built, giving complete control over performance, security, and UX.

### Key Value Propositions

| | |
|---|---|
| **🎨 Zero Page Builders** | Pure PHP templates + CSS architecture — no Elementor/Divi overhead |
| **⚡ AJAX-First Auth** | Login, Register, Forgot Password, Logout — all asynchronous with zero page reloads |
| **🔒 Security by Default** | Nonce verification, input sanitization, IP-based rate limiting on every endpoint |
| **📱 Responsive Architecture** | Desktop-first design with mobile breakpoints at 1024px, 768px, and 480px |
| **🛒 Deep WooCommerce Integration** | Custom product cards, single product page, checkout styling, gallery thumbnails |

---

## ✨ Features

### Custom Post Types (CMS-Managed Content)

**Hero Slides** — Full-viewport hero slider powered by Swiper.js with:
- Admin meta boxes for button text, URL, and content visibility toggle
- Fade transition effect with 5-second autoplay and synced progress bar
- Dark gradient overlay with grain texture for premium aesthetics
- Staggered text animation on load via `IntersectionObserver`

**Category Banners** — Promotional grid section with:
- Dynamic background images via WordPress Featured Image API
- Configurable button text and link URL per banner
- Fallback gradient placeholders when no banners exist

### AJAX Authentication System

A complete, custom-built authentication flow — no plugins:

```
┌─────────────┐     POST /admin-ajax.php     ┌──────────────────┐
│  Login Form │ ──────────────────────────►   │  PHP Handler     │
│  (Vanilla JS)│  ◄──────────────────────────  │  (Nonce + Rate   │
│             │     JSON { success, redirect } │   Limiting)      │
└─────────────┘                               └──────────────────┘
```

- **Login:** Email/username + password with "Remember Me" support
- **Register:** Full name, email, password with real-time validation (strength meter, match check)
- **Forgot Password:** Email-based reset via `retrieve_password()` core function
- **Logout:** AJAX-driven with fallback to native WordPress logout
- **Rate Limiting:** IP + identifier hash, 5 attempts max, 15-minute lockout via transients
- **Auto-redirect:** Logged-in users are redirected away from auth pages at `template_redirect`

### WooCommerce Customizations

- **Custom product card template** (`content-product.php`) — clean card with Add to Cart / View Product logic
- **Full single product page** (`content-single-product.php`) — 2-column layout with:
  - Thumbnail gallery with click-to-swap
  - Quantity selector with +/- buttons
  - "Buy Now" direct-to-checkout button
  - Accordion tabs (Description, Additional Info, Reviews)
  - Social sharing (Facebook, Twitter)
  - Shipping & returns reassurance badges
  - "You May Also Like" related products grid
  - Low stock warning ("Only X left!")
- **Custom checkout page styling** — 60/40 split layout with gold accents
- **Flying cart animation** — product image animates to cart icon on add

### UI/UX Highlights

- **Transparent-to-solid header** — on homepage, header starts transparent over hero, solidifies on scroll (60px threshold). Inner pages always render solid white.
- **3-column flexbox header** — `flex: 1` on left/right sections mathematically centers the logo
- **Animated underline navigation** — `width: 0 → 100%` pseudo-element transition on hover
- **User dropdown menu** — click/hover/keyboard accessible with proper `aria-expanded` management
- **Back-to-top button** — appears after 400px scroll with smooth scroll behavior
- **Scroll reveal animations** — `IntersectionObserver`-driven staggered fade-in for product cards
- **Quick View modal** — AJAX-loaded product preview with skeleton loading states

---

## 📐 Architecture & Design Decisions

### System Architecture

```
wp-content/themes/antigravity/
│
├── style.css                    # 6500+ lines — complete design system
├── functions.php                # 974 lines — theme bootstrap + all backend logic
│
├── header.php                   # 3-column flexbox header with auth-aware UI
├── footer.php                   # 4-column footer + inline interaction scripts
├── front-page.php               # Homepage: hero slider + category grid + featured products
├── index.php                    # Blog/archive fallback template
├── page.php                     # Generic page template
│
├── page-login.php               # Standalone login (no header/footer)
├── page-register.php            # Standalone registration
├── page-forgot-password.php     # Standalone password reset
│
├── woocommerce/
│   ├── content-product.php      # Product card override (shop/archive)
│   └── content-single-product.php  # Full single product page (391 lines)
│
├── archive-product.php          # WooCommerce archive wrapper
├── single-product.php           # WooCommerce single wrapper
├── woocommerce.php              # WooCommerce page wrapper
│
└── assets/
    └── js/
        ├── main.js              # 934 lines — all client-side logic (auth, UI, shop)
        ├── mobile-menu.js       # Mobile hamburger menu handler
        └── admin-uploader.js    # WP admin media uploader helper
```

### Why No Page Builder?

| Concern | Page Builder | This Theme |
|---------|-------------|------------|
| **Bundle Size** | 200-500KB+ JS/CSS loaded on every page | Only what's needed per template |
| **Customization** | Limited to builder's component API | Full control via PHP hooks + CSS |
| **Maintainability** | Serialized JSON in `post_content` | Clean, readable template files |
| **Performance** | Multiple render-blocking requests | Single stylesheet + single JS bundle |
| **Developer Experience** | GUI-dependent, hard to version control | Standard Git workflow, code review friendly |

### Key Design Patterns

**Template Hierarchy** — Leverages WordPress's native template loading: `front-page.php` → `page-{slug}.php` → `single-product.php` → `index.php`. No routing plugins needed.

**Hook-Based Architecture** — All WooCommerce modifications use `add_action` / `add_filter` / `remove_action` instead of editing core files:
```php
// Replace default tabs with custom accordion
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

// Add low stock warning at priority 25
add_action('woocommerce_single_product_summary', function() { /* ... */ }, 25);
```

**Nonce-Protected AJAX** — Every AJAX endpoint follows the same security pattern:
```php
// 1. Create nonce (server → client)
wp_localize_script('antigravity-main', 'amiraAjax', [
    'loginNonce' => wp_create_nonce('amira_login_nonce'),
]);

// 2. Verify nonce (client → server)
if (!wp_verify_nonce($_POST['nonce'], 'amira_login_nonce')) {
    wp_send_json_error(['message' => 'Security check failed.']);
}
```

**Transient-Based Rate Limiting** — Failed login attempts are tracked using WordPress transients with a composite key:
```php
$key = 'amira_login_fail_' . md5($ip . $identifier);
// 5 attempts max → 15-minute lockout
```

### Security Considerations

| Layer | Implementation |
|-------|---------------|
| **Input Sanitization** | `sanitize_text_field()`, `sanitize_email()`, `esc_url_raw()` on all inputs |
| **Output Escaping** | `esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()` on all outputs |
| **Nonce Verification** | Every AJAX handler validates a unique nonce before processing |
| **Rate Limiting** | IP + username composite key, 5 attempts, 15-min lockout via transients |
| **Auth Redirects** | Logged-in users blocked from auth pages at `template_redirect` hook |
| **Direct Access Prevention** | `defined('ABSPATH') || exit;` guard on all PHP files |
| **Password Handling** | Never stored in plaintext; uses WordPress's `wp_signon()` / `wp_create_user()` |

---

## 🛠 Tech Stack

| Layer | Technology | Rationale |
|-------|-----------|-----------|
| **CMS** | WordPress 6.x | Mature ecosystem, native user/role management, extensible hook system |
| **E-Commerce** | WooCommerce 3.0+ | Industry standard; provides cart, checkout, payment gateway integrations |
| **Backend** | PHP 8.x | WordPress native; leverages `WP_Query`, custom post types, meta boxes |
| **Frontend** | Vanilla JavaScript (ES6+) | No framework overhead; `IntersectionObserver`, `fetch()`, `FormData` |
| **Styling** | Hand-written CSS3 | 6500+ lines; CSS custom properties, flexbox, grid, `@media` breakpoints |
| **Slider** | Swiper.js 11 | Lightweight (< 50KB), touch-friendly, CDN-delivered, fade + loop effects |
| **Typography** | Google Fonts | Cormorant Garamond (headings) + Inter (body) — luxury serif + modern sans |
| **Server** | Apache (XAMPP/LAMP) | Standard WordPress hosting stack; `.htaccess` rewrite rules |
| **Database** | MariaDB | WordPress default; stores posts, meta, options, transients |

---

## ⚙️ Installation & Setup

### Prerequisites

- **PHP** ≥ 8.0
- **WordPress** ≥ 5.0
- **WooCommerce** ≥ 3.0
- **MySQL / MariaDB** ≥ 5.7
- **Apache** or Nginx with URL rewriting enabled

### Step-by-Step

```bash
# 1. Clone the repository into your WordPress themes directory
cd /path/to/wordpress/wp-content/themes/
git clone https://github.com/hamzahossainX/Wordpress-Custome-Theme.git antigravity

# 2. Activate the theme
#    Go to: WordPress Admin → Appearance → Themes → Activate "Antigravity"

# 3. Install WooCommerce (if not already installed)
#    Go to: Plugins → Add New → Search "WooCommerce" → Install & Activate

# 4. Create required pages (auto-created on theme activation)
#    The theme auto-generates Login, Register, and Forgot Password pages
#    with correct templates assigned via antigravity_create_auth_pages()

# 5. Set up content
#    - Hero Slides: Admin → Hero Slides → Add New (set background image + button)
#    - Category Banners: Admin → Category Banners → Add New
#    - Products: WooCommerce → Products → Add New

# 6. Configure menus
#    Appearance → Menus → Create menu → Assign to "Primary Menu" location
```

### Environment Configuration

| Setting | Value | Notes |
|---------|-------|-------|
| `WP_DEBUG` | `false` | Set `true` during development |
| `permalink_structure` | `/%postname%/` | Required for clean URLs |
| `users_can_register` | `1` | Enable for registration to work |
| `woocommerce_coming_soon` | `no` | Theme auto-disables this |

### Troubleshooting

| Issue | Solution |
|-------|---------|
| Auth pages return 404 | Go to Settings → Permalinks → click "Save Changes" to flush rewrites |
| Header overlaps content | Ensure `body:not(.home)` has `padding-top: 80px` in `style.css` |
| Hero slides not showing | Check that Hero Slide posts have a Featured Image set |
| WooCommerce "Coming Soon" overlay | Theme auto-disables this, but verify in WooCommerce → Settings |

---

## 🧩 Usage Examples

### Creating a Hero Slide

```
WordPress Admin → Hero Slides → Add New

1. Title: "Spring Collection 2026"
2. Content: (optional description text)
3. Featured Image: Upload 1920×1080+ hero background
4. Slide Settings:
   - Button Text: "SHOP NOW"
   - Button URL: https://yoursite.com/shop
   - Show Content: ✓ checked
5. Publish
```

### Customizing the Header

The header uses a 3-column flexbox architecture. The logo stays mathematically centered because both `.header-left` and `.header-right` use `flex: 1`:

```css
.header-left  { flex: 1; justify-content: flex-start; }
.header-center { flex: 0 0 auto; }  /* shrink-wrap to content */
.header-right { flex: 1; justify-content: flex-end; }
```

### Adding WooCommerce Hooks

```php
// Example: Add a custom badge to products on sale
add_action('woocommerce_single_product_summary', function() {
    global $product;
    if ($product->is_on_sale()) {
        echo '<span class="custom-sale-badge">SALE</span>';
    }
}, 6); // Priority 6 = before title (priority 5 = breadcrumb)
```

---

## 🚀 Performance & Optimizations

| Technique | Impact |
|-----------|--------|
| **No page builder overhead** | Eliminates 200-500KB of unused JS/CSS per page |
| **CDN-delivered Swiper.js** | Only loaded on `is_front_page()` — zero cost on inner pages |
| **Passive scroll listeners** | `{ passive: true }` on scroll handlers for 60fps scrolling |
| **IntersectionObserver** | Replaces expensive `scroll` event listeners for reveal animations |
| **One-time observer pattern** | `observer.unobserve(card)` after animation — no ongoing DOM checks |
| **Transient caching** | Auth page creation uses transient guard to prevent repeated DB writes |
| **Google Fonts `display=swap`** | Text renders immediately with fallback font; no FOIT |
| **Conditional asset loading** | Swiper CSS/JS only enqueued on front page via `is_front_page()` check |

---

## 🗺 Roadmap

### Planned Features
- [ ] AJAX-powered product filtering (price range, categories, attributes)
- [ ] Wishlist persistence (currently UI-only, no backend storage)
- [ ] Variable product support on single product page
- [ ] Search overlay with live product suggestions
- [ ] Mobile hamburger menu with slide-out drawer animation
- [ ] Newsletter form integration (Mailchimp/ConvertKit API)
- [ ] Dark mode toggle with CSS custom properties

### Known Limitations
- Cart price in header is static (`$0.00`) — needs WooCommerce fragment refresh
- Quick View modal requires admin AJAX endpoint (`amira_quick_view`) not yet implemented
- No i18n `.pot` file generated yet (all strings are translatable with `esc_html__()`)
- Sort dropdown on shop page uses full-page fetch instead of true AJAX filtering

---

## 🤝 Contributing

Contributions are welcome. This is a learning project that prioritizes clean code and WordPress best practices.

### Code Style

- **PHP:** WordPress Coding Standards — `snake_case` functions, prefixed with `antigravity_`
- **JavaScript:** ES6+ with strict mode IIFEs, `'use strict'` in every module
- **CSS:** BEM-inspired naming (`.asp-main-wrapper`, `.amira-card__title`)
- **Sanitization:** Every input sanitized, every output escaped — no exceptions

### PR Process

1. Fork the repo
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Follow existing code conventions and prefix patterns
4. Test with WordPress 6.x + WooCommerce latest
5. Submit PR with a clear description of changes and screenshots

---

## 📄 License

This project is licensed under the **GNU General Public License v2.0** — see the [LICENSE](http://www.gnu.org/licenses/gpl-2.0.html) for details.

---

<p align="center">
  <sub>Built with ❤️ in Bangladesh by <a href="https://github.com/hamzahossainX">Ismail Hossen</a></sub>
</p>
