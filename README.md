# Mimin — Home 5 (Static Rebuild)

A pixel-faithful static rebuild of the **Mimin** WordPress/WooCommerce theme
(origin: `https://mimin.wpbingosite.com/home-5/`) in a single HTML file using
**Tailwind CSS (CDN) + vanilla JavaScript**. No build step required.

## Run it

Open `index.html` directly in any modern browser — or serve the folder:

```bash
npx serve .        # or: python3 -m http.server 8080
```

## What's inside

```
mimin-home5/
├── index.html            ← the whole theme (HTML + Tailwind + JS)
└── assets/img/           ← 40 original theme images (logo, hero, products…)
```

## Sections (matching the original Home 5 layout)

1. **Header** — logo / dropdown nav / full-width mega menu (Shop) / search, account, wishlist, cart icons; sticky with scroll shadow
2. **Hero slider** — 3 slides (`#D5E4E1` sage, `#F0F0F0` mist), full-bleed proportional composition, numbered 01/02/03 bullets, arrows, autoplay, swipe
3. **Category banners** — Home Decor / Living Room / Lighting / Furniture with hover zoom + label buttons
4. **Best Sellers** — working Bedroom / Lighting / Tables tabs (8 products each), sale badges, hover image swap, Quick View / Wishlist / Compare / Add-to-cart actions, "Shop More" button
5. **Video banner** — play button opens a lightbox (drop your own MP4 into the `<video>` tag)
6. **Brands** — infinite CSS marquee (Altura, Crafts, Echelon, Luminary, Stellar, Wooden), pauses on hover
7. **Lookbook** — image with pulsing hotspots revealing product popovers + scroll-snap product carousel
8. **Instagram** — 4-image grid with hover overlay + "Follow Us" button
9. **Footer** — contact, Information / About Us columns, "Sign Up For 10% Off" newsletter, socials, payment icons, legal bar

## Interactive features (vanilla JS)

- Cart drawer: add / qty +− / remove / subtotal / empty state (stored in-memory)
- Quick View modal with quantity picker
- Search popup ("I'm looking for…") and Sign In / Register modal with tabs
- Mobile: hamburger drawer with accordions
- Wishlist counter, toast notifications, back-to-top, reveal-on-scroll, ESC-to-close

## Notes

- Font: **Jost** (Google Fonts) — free stand-in for the theme's FuturaCyrillic
- Tailwind loads via CDN (`cdn.tailwindcss.com`); for production, compile with the Tailwind CLI
- Video source is a placeholder MP4 — replace in the Video Modal `<source>`
- The Lighting / Tables tab products are plausible demo data (original loads via AJAX)
