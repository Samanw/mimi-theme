# Mimin — Home 5 (Static Rebuild, Full Theme)

A pixel-faithful static rebuild of the **Mimin** WordPress/WooCommerce theme
(origin: `https://mimin.wpbingosite.com/home-5/`) in plain HTML using
**Tailwind CSS (CDN) + vanilla JavaScript**. No build step required.

## Pages

| File | Page |
|---|---|
| `index.html` | Home 5 — hero slider, category banners, Best Sellers tabs, video banner, brands, lookbook, Instagram |
| `shop.html` | Shop archive — sidebar widgets (price range, categories, colors, sizes, brands, rating, tags, top-rated), sorting, grid/list views, pagination, mobile filter drawer |
| `product.html` | Single product — gallery with thumbs, color/size variations, qty, description/info/reviews tabs, review form, related products |
| `cart.html` | Cart — editable table, coupon (`MIMIN10` / `WELCOME15`), totals, cross-sells |
| `checkout.html` | Checkout — billing form, ship-to-different-address, order review, payment methods, order-received confirmation |
| `blog.html` | Blog — featured post, article list, pagination |
| `archive.html` | Blog archive — category chips + `?cat=` / `?month=` URL views, grid |
| `post.html` | Single post — full article, tags/share, author box, comments with replies, related posts |

## Run it

Open any page directly in a modern browser — or serve the folder:

```bash
npx serve .        # or: python3 -m http.server 8080
```

## What's inside

```
mimin-home5/
├── index.html … archive.html   ← 8 pages (HTML + Tailwind + vanilla JS)
└── assets/img/                 ← 40 original theme images
```

All pages share the same header (mega menu, search, account, cart drawer),
footer, toast and back-to-top systems. The shared JS exposes a small API
(`window.MiminUI`) used by page scripts — cart contents, toasts and product
cards behave identically everywhere.

## Interactive features (vanilla JS, no dependencies)

- **Shop filters**: dual-handle price slider, category/brand checkboxes, color swatches, size + rating + tag chips — all combinable, with result counts and pagination
- **Sorting**: default / popularity / rating / latest / price asc & desc
- **Grid ↔ list view** toggle (`?view=list` supported)
- **Cart**: shared cart store — drawer and cart page stay in sync; qty steppers, remove, coupon codes, free-shipping threshold at $100
- **Checkout**: required-field validation, terms checkbox, 3 payment methods (bank details shown for transfer), simulated "Order received" receipt with order number/date/total
- **Product**: image gallery, color/size selectors, review form that appends live
- **Blog/archive**: category chips, month archive via URL, comment form with reply prefill, widget search
- Hero slider (autoplay/arrows/swipe), quick-view modal, wishlist counter, mobile menu with accordions, lookbook hotspots, video lightbox, toasts, back-to-top, reveal-on-scroll, ESC-to-close

## Notes

- Font: **Jost** (Google Fonts) — free stand-in for the theme's FuturaCyrillic
- Tailwind loads via CDN (`cdn.tailwindcss.com`); for production, compile with the Tailwind CLI
- Cart/checkout pages seed two demo items on load so the full layout is visible
- Coupon codes for demo: `MIMIN10` (10% off), `WELCOME15` (15% off)
- Video source is a placeholder MP4 — replace in the Video Modal `<source>`
- Lighting/Tables tab products and blog content are plausible demo data (the original loads via AJAX)
