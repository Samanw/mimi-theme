# Mimin — WordPress WooCommerce Theme

A complete **WordPress + WooCommerce theme** port of the **Mimin** Home 5 demo
(origin: `https://mimin.wpbingosite.com/home-5/`), built on
**Tailwind CSS (compiled) + vanilla JS + jQuery bridge** for WooCommerce AJAX.

The original static rebuild (8 HTML pages) is kept at the repo root for
reference. The installable theme lives in [`mimin-theme/`](mimin-theme/).

## Install

1. Install & activate **WooCommerce**.
2. `wp-admin → Appearance → Themes → Add New → Upload Theme` → `mimin-theme.zip`
   (or copy the `mimin-theme/` folder into `wp-content/themes/`).
3. Activate **Mimin**. The front page renders the Home 5 layout automatically.
4. Assign a **Primary Menu** (Appearance → Menus).
   Add the CSS class `mm-mega` to a top-level item to render its children as
   columns inside a full-width mega-menu panel.
5. Edit everything under **Appearance → Customize → Mimin Theme Options**:
   hero slides, category banners, best sellers, video, lookbook hotspots,
   Instagram, contact, socials, footer & newsletter.

## Features

| Area | Details |
|---|---|
| Home | 3-slide hero (autoplay/arrows/swipe/numbered bullets), 4 category banners, Best Sellers tabs by product category, video lightbox, brand marquee, lookbook with product hotspots, Instagram grid |
| Shop archive | Filter sidebar (price, categories, color/size attributes, rating, top-rated, tags) + widget area override, mobile filter drawer, sorting, grid/list view, pagination |
| Widgets | Blog sidebar, Shop Filters sidebar (Woo filter widgets supported), fallback demo widgets on both, footer menus |
| Product | Quick view (AJAX), wishlist (localStorage), hover gallery, sale badge %, add-to-cart slide-up |
| Single product | Woo gallery (zoom/lightbox), variations, tabs, reviews, related products |
| Cart | Theme-styled cart page, quantity steppers, coupon toggle, totals, cross-sells + AJAX slide-out drawer with steppers |
| Checkout | Classic Woo checkout restyled (grid layout, black buttons) |
| Blog | Featured-post index, single post (tags/share/author/related), archives, search, pages, 404, comments |
| Headers/footers | Announcement bar, sticky header, mega menu, search overlay, account link, cart badge |

## Theme structure

```
mimin-theme/
├── style.css                  theme header
├── functions.php              setup, enqueue, menus, widgets
├── inc/                       template-tags (walkers, breadcrumbs, icons), customizer, woo hooks + AJAX
├── header.php / footer.php    announcement, drawers, search, cart drawer, quickview shell
├── front-page.php             Home 5 (hero, banners, tabs, video, brands, lookbook, instagram)
├── index/single/archive/search/page/404/comments
├── sidebar.php · sidebar-shop.php
├── template-parts/home/*      one part per home section
├── woocommerce/               archive-product, single-product, content-product, cart, mini-cart
├── assets/css/                theme.css (Tailwind build) · woocommerce.css · input.css (source)
├── assets/js/mimin.js         overlays, AJAX cart/quickview/newsletter, hero, tabs
└── assets/img/                40 original demo images + logo/payment
```

### Rebuilding the CSS

```bash
cd mimin-theme
npm install
npm run build     # scans **/*.php + assets/js → assets/css/theme.css
```

## Static reference rebuild (repo root)

`index.html`, `shop.html`, `product.html`, `cart.html`, `checkout.html`,
`blog.html`, `post.html`, `archive.html` + `assets/img/` — the original
pixel-faithful static reconstruction with the same design system. Open any
page in a browser, or `npx serve .`
