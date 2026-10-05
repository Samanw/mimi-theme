=== Mimin ===
Contributors: samanw
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: e-commerce, blog, two-columns, right-sidebar, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready

Minimal WooCommerce theme for furniture & interior stores — recreates the Mimin Home 5 layout.

== Description ==

Mimin is a clean, typography-first WooCommerce theme built with Tailwind CSS.
It recreates the Mimin "Home 5" demo layout as a fully native WordPress theme:

* Hero slider (3 slides, editable in the Customizer)
* Category banners, Best Sellers tabs (by product category), video banner,
  brand marquee, lookbook with product hotspots, Instagram grid
* Shop archive with a filter sidebar: price, categories, color/size
  attributes, rating, top rated products, tags + mobile filter drawer,
  sorting, and grid/list view
* Product quick view (AJAX), wishlist (localStorage), AJAX cart drawer
  with quantity steppers
* Single product with gallery, variations, tabs, reviews, related products
* Cart, checkout and My Account pages styled to match
* Blog index with featured post, single post, archives, search, static
  pages, 404 — all with a widget-ready blog sidebar
* Footer menus, newsletter signup (AJAX), social links — all editable in
  the Customizer

== Installation ==

1. Install and activate the WooCommerce plugin.
2. In wp-admin go to Appearance → Themes → Add New → Upload Theme and
   choose mimin-theme.zip.
3. Activate Mimin.
4. Create a static front page (Settings → Reading → Your homepage
   displays → A static page) or leave the default — the theme renders the
   Home 5 layout on the front page automatically.
5. Assign your Primary Menu under Appearance → Menus.
   Tip: add the CSS class `mm-mega` to a top-level item to render its
   children as columns inside a full-width mega menu panel.
6. Visit Appearance → Customize → Mimin Theme Options to edit slides,
   banners, video, lookbook, Instagram, socials and footer content.
7. Optional: drop WooCommerce filter widgets (Filter by price, Product
   categories, Filter by attribute, Rating filter, Products, Product
   tags) into the "Shop Filters Sidebar" widget area to replace the demo
   filters.

== Frequently Asked Questions ==

= Does it work without WooCommerce? =
Yes. The blog, pages, archives and search work standalone; shop sections
are simply hidden and the cart drawer shows a notice until WooCommerce is
active.

= How do I get the color/size filters? =
Create global attributes named "Color" (pa_color) and "Size" (pa_size) in
Products → Attributes. The demo filter sidebar links them automatically,
or use the WooCommerce "Filter by attribute" widget.

== Changelog ==

= 1.0.0 =
* Initial release.
