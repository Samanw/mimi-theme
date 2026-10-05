/* ══════════════════════════════════════════════════════════════
   MIMIN — theme JS (vanilla + jQuery bridge for WooCommerce)
   ══════════════════════════════════════════════════════════════ */
(function () {
	'use strict';

	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
	var cfg = window.miminData || {};

	/* ---------- toast ---------- */
	var toastTimer;
	function toast(msg) {
		var t = $('#toast');
		if (!t) return;
		t.textContent = msg;
		t.classList.remove('translate-y-20', 'opacity-0');
		clearTimeout(toastTimer);
		toastTimer = setTimeout(function () {
			t.classList.add('translate-y-20', 'opacity-0');
		}, 2600);
	}

	/* ---------- overlay panels ---------- */
	function openPanel(backdrop, panel, cls) {
		if (!backdrop || !panel) return;
		backdrop.classList.remove('opacity-0', 'invisible');
		if (cls) panel.classList.remove(cls);
		panel.classList.remove('invisible');
		document.body.classList.add('no-scroll');
	}
	function closePanel(backdrop, panel, cls) {
		if (!backdrop || !panel) return;
		backdrop.classList.add('opacity-0', 'invisible');
		if (cls) panel.classList.add(cls);
		document.body.classList.remove('no-scroll');
	}

	/* cart drawer */
	var cartBackdrop = $('#cart-backdrop'), cartDrawer = $('#cart-drawer');
	function openCart() { openPanel(cartBackdrop, cartDrawer, 'translate-x-full'); }
	function closeCart() { closePanel(cartBackdrop, cartDrawer, 'translate-x-full'); }
	if ($('#cart-open')) $('#cart-open').addEventListener('click', openCart);
	if ($('#cart-close')) $('#cart-close').addEventListener('click', closeCart);
	if (cartBackdrop) cartBackdrop.addEventListener('click', closeCart);

	/* mobile menu */
	var mmBackdrop = $('#mobile-menu-backdrop'), mmDrawer = $('#mobile-menu');
	if ($('#mobile-menu-open')) $('#mobile-menu-open').addEventListener('click', function () { openPanel(mmBackdrop, mmDrawer, '-translate-x-full'); });
	if ($('#mobile-menu-close')) $('#mobile-menu-close').addEventListener('click', function () { closePanel(mmBackdrop, mmDrawer, '-translate-x-full'); });
	if (mmBackdrop) mmBackdrop.addEventListener('click', function () { closePanel(mmBackdrop, mmDrawer, '-translate-x-full'); });

	/* accordions */
	$$('[data-acc]').forEach(function (head) {
		head.addEventListener('click', function () {
			var body = head.nextElementSibling;
			if (!body) return;
			var open = body.style.maxHeight && body.style.maxHeight !== '0px';
			body.style.maxHeight = open ? '0px' : body.scrollHeight + 'px';
			var arrow = head.querySelector('.acc-arrow');
			if (arrow) arrow.style.transform = open ? '' : 'rotate(180deg)';
		});
	});

	/* generic modals */
	function bindModal(rootId, openBtnId, closeBtnId) {
		var root = $('#' + rootId);
		if (!root) return function () {};
		if (openBtnId && $('#' + openBtnId)) {
			$('#' + openBtnId).addEventListener('click', function () {
				root.classList.remove('opacity-0', 'invisible');
				document.body.classList.add('no-scroll');
			});
		}
		var close = function () {
			root.classList.add('opacity-0', 'invisible');
			document.body.classList.remove('no-scroll');
			var vid = root.querySelector('video');
			if (vid) vid.pause();
		};
		if (closeBtnId && $('#' + closeBtnId)) $('#' + closeBtnId).addEventListener('click', close);
		root.addEventListener('click', function (e) { if (e.target === root) close(); });
		return close;
	}
	var closeSearch = bindModal('search-modal', 'search-open', 'search-close');
	var closeQuick = bindModal('quickview-modal', null, null);
	var closeVideo = bindModal('video-modal', 'video-open', 'video-close');

	document.addEventListener('keydown', function (e) {
		if (e.key !== 'Escape') return;
		closeSearch(); closeQuick(); closeVideo(); closeCart();
		if (mmBackdrop && mmDrawer) closePanel(mmBackdrop, mmDrawer, '-translate-x-full');
	});

	/* quickview close is injected via AJAX — delegate */
	document.addEventListener('click', function (e) {
		if (e.target.closest('#quickview-close')) closeQuick();
	});

	/* ---------- header shadow ---------- */
	var header = $('#site-header');
	if (header) {
		window.addEventListener('scroll', function () {
			header.classList.toggle('shadow-[0_10px_30px_rgba(0,0,0,.06)]', window.scrollY > 10);
		}, { passive: true });
	}

	/* ---------- back to top ---------- */
	var btt = $('#back-to-top');
	if (btt) {
		window.addEventListener('scroll', function () {
			var show = window.scrollY > 600;
			btt.classList.toggle('opacity-0', !show);
			btt.classList.toggle('invisible', !show);
		}, { passive: true });
		btt.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
	}

	/* ---------- reveal on scroll ---------- */
	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (en) {
			if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
		});
	}, { threshold: 0.12 });
	function observeReveals() { $$('.reveal:not(.in)').forEach(function (el) { io.observe(el); }); }
	observeReveals();

	/* ---------- wishlist (localStorage) ---------- */
	var wish = [];
	try { wish = JSON.parse(localStorage.getItem('mimin-wishlist') || '[]'); } catch (e) { wish = []; }
	function wishBadge() {
		var badge = $('#wishlist-count');
		if (!badge) return;
		badge.textContent = wish.length;
		badge.classList.toggle('hidden', wish.length === 0);
	}
	function wishToggle(id) {
		var i = wish.indexOf(id);
		if (i > -1) { wish.splice(i, 1); toast(cfg.i18n ? cfg.i18n.wishRemove : 'Removed from wishlist'); }
		else { wish.push(id); toast(cfg.i18n ? cfg.i18n.wishAdd : 'Added to wishlist'); }
		localStorage.setItem('mimin-wishlist', JSON.stringify(wish));
		wishBadge();
	}
	wishBadge();
	document.addEventListener('click', function (e) {
		var w = e.target.closest('.wishlist-btn');
		if (!w) return;
		var pid = parseInt(w.getAttribute('data-product-id'), 10);
		if (pid) wishToggle(pid);
	});
	if ($('#wishlist-open')) $('#wishlist-open').addEventListener('click', function () {
		if (!wish.length) { toast(cfg.i18n ? cfg.i18n.wishList : 'Your wishlist is empty.'); }
		else { toast(wish.length + ' ' + (cfg.i18n ? cfg.i18n.wishItems : 'items in your wishlist.')); }
	});
	document.addEventListener('click', function (e) {
		var c = e.target.closest('.compare-btn');
		if (c) toast(cfg.i18n ? cfg.i18n.compare : 'Compare is available via a comparison plugin.');
	});

	/* ---------- quick view (AJAX) ---------- */
	document.addEventListener('click', function (e) {
		var qv = e.target.closest('.quickview-btn');
		if (!qv || !$('#quickview-modal')) return;
		var pid = parseInt(qv.getAttribute('data-product-id'), 10);
		if (!pid) return;
		qv.classList.add('busy');
		var body = new FormData();
		body.append('action', 'mimin_quickview');
		body.append('nonce', cfg.nonce);
		body.append('product_id', pid);
		fetch(cfg.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
			.then(function (r) { return r.json(); })
			.then(function (res) {
				qv.classList.remove('busy');
				if (res && res.success && res.data && res.data.html) {
					$('#quickview-body').innerHTML = res.data.html;
					$('#quickview-modal').classList.remove('opacity-0', 'invisible');
					document.body.classList.add('no-scroll');
				} else {
					toast('Quick view is unavailable.');
				}
			})
			.catch(function () { qv.classList.remove('busy'); toast('Quick view is unavailable.'); });
	});
	document.addEventListener('click', function (e) {
		var b = e.target.closest('.qv-qty-btn');
		if (!b) return;
		var span = $('#qv-qty');
		if (!span) return;
		span.textContent = Math.max(1, parseInt(span.textContent, 10) + parseInt(b.getAttribute('data-d'), 10));
	});

	/* ---------- newsletter (AJAX) ---------- */
	var nlForm = $('#newsletter-form');
	if (nlForm) {
		nlForm.addEventListener('submit', function (e) {
			e.preventDefault();
			var email = nlForm.querySelector('input[type="email"]');
			var body = new FormData();
			body.append('action', 'mimin_newsletter');
			body.append('nonce', cfg.nonce);
			body.append('email', email ? email.value : '');
			fetch(cfg.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					toast(res && res.data && res.data.message ? res.data.message : 'Thank you for subscribing!');
					if (res && res.success) nlForm.reset();
				})
				.catch(function () { toast('Thank you for subscribing!'); });
		});
	}

	/* ══════════════════ WOOCOMMERCE ══════════════════ */
	if (cfg.isWoo && window.jQuery) {
		var jq = window.jQuery;

		/* open drawer when something is added via AJAX */
		jq(document.body).on('added_to_cart', function (e, fragments, hash, $button) {
			openCart();
			toast(cfg.i18n ? cfg.i18n.added : 'Added to cart');
		});

		/* drawer quantity steppers */
		jq(document.body).on('click', '#cart-items .mini-qty-btn', function () {
			var btn = this;
			var key = btn.getAttribute('data-key');
			var d = parseInt(btn.getAttribute('data-d'), 10);
			var body = new FormData();
			body.append('action', 'mimin_cart_qty');
			body.append('nonce', cfg.nonce);
			body.append('key', key);
			body.append('delta', d);
			fetch(cfg.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (res && res.success && res.data) {
						var items = $('#cart-items');
						if (items && res.data.drawer) items.innerHTML = res.data.drawer;
						var badge = $('#cart-count');
						if (badge) {
							badge.textContent = res.data.count;
							badge.classList.toggle('hidden', !res.data.count);
						}
						jq(document.body).trigger('wc_fragment_refresh');
					}
				});
			return false;
		});
	}

	/* ---------- cart page quantity steppers ---------- */
	document.addEventListener('click', function (e) {
		var minus = e.target.closest('.mimin-qty .qty-minus');
		var plus = e.target.closest('.mimin-qty .qty-plus');
		if (!minus && !plus) return;
		var wrap = (minus || plus).closest('.mimin-qty');
		var input = wrap ? wrap.querySelector('input.qty') : null;
		if (!input) return;
		var cur = parseInt(input.value, 10) || 0;
		var min = parseInt(input.getAttribute('min'), 10); if (isNaN(min)) min = 0;
		var max = parseInt(input.getAttribute('max'), 10); if (isNaN(max)) max = Infinity;
		input.value = Math.min(max, Math.max(min, cur + (plus ? 1 : -1)));
		input.dispatchEvent(new Event('change', { bubbles: true }));

		/* fallback: if Woo core didn't auto-submit, submit ourselves */
		var form = input.closest('form.woocommerce-cart-form');
		if (form) {
			clearTimeout(window.__miminCartSubmitTimer);
			window.__miminCartSubmitTimer = setTimeout(function () {
				if (!form.classList.contains('processing') && $('#update_cart')) {
					$('#update_cart').value = '1';
					if (form.requestSubmit) form.requestSubmit();
					else form.submit();
				}
			}, 1200);
		}
	});

	/* coupon toggle on cart page */
	var couponToggle = $('#coupon-toggle');
	if (couponToggle) {
		couponToggle.addEventListener('click', function () {
			var box = $('#coupon-box');
			if (box) box.classList.toggle('hidden');
		});
	}

	/* ---------- shop: price range demo filter ---------- */
	var priceMin = $('#price-min'), priceMax = $('#price-max');
	if (priceMin && priceMax) {
		var money = function (n) {
			return cfg.isWoo ? String(n) : '$' + n;
		};
		var updatePrice = function () {
			var min = Math.min(parseInt(priceMin.value, 10), parseInt(priceMax.value, 10));
			var max = Math.max(parseInt(priceMin.value, 10), parseInt(priceMax.value, 10));
			var lo = parseInt(priceMin.min, 10) || 0;
			var hi = parseInt(priceMin.max, 10) || 100;
			var track = $('#price-track');
			if (track) {
				track.style.left = ((min - lo) / (hi - lo) * 100) + '%';
				track.style.right = (100 - (max - lo) / (hi - lo) * 100) + '%';
			}
			var label = $('#price-label');
			if (label) label.textContent = money(min) + ' \u2014 ' + money(max);
		};
		priceMin.addEventListener('input', updatePrice);
		priceMax.addEventListener('input', updatePrice);
		updatePrice();
	}

	/* ---------- shop: mobile filter drawer ---------- */
	var shopSidebar = $('#shop-sidebar');
	if (shopSidebar) {
		var openFilter = function () { openPanel($('#filter-backdrop'), shopSidebar, 'max-lg:-translate-x-full'); };
		var closeFilter = function () { closePanel($('#filter-backdrop'), shopSidebar, 'max-lg:-translate-x-full'); };
		if ($('#filter-toggle')) $('#filter-toggle').addEventListener('click', openFilter);
		if ($('#filter-close')) $('#filter-close').addEventListener('click', closeFilter);
		var fb = $('#filter-backdrop');
		if (fb) fb.addEventListener('click', closeFilter);
	}

	/* ---------- hero slider ---------- */
	var hero = $('#hero');
	if (hero) {
		var slides = $$('[data-slide]', hero);
		var bullets = $$('#hero-bullets .hero-bullet');
		var current = Math.max(0, slides.findIndex(function (s) { return s.classList.contains('is-active'); }));
		var timer = null;

		function go(i) {
			slides[current].classList.remove('is-active');
			if (bullets[current]) bullets[current].classList.remove('is-active');
			current = (i + slides.length) % slides.length;
			slides[current].classList.add('is-active');
			if (bullets[current]) bullets[current].classList.add('is-active');
		}
		function play() {
			stop();
			timer = setInterval(function () { go(current + 1); }, 6500);
		}
		function stop() { if (timer) clearInterval(timer); timer = null; }

		if (slides.length > 1) {
			play();
			var prev = $('#hero-prev'), next = $('#hero-next');
			if (prev) prev.addEventListener('click', function () { go(current - 1); play(); });
			if (next) next.addEventListener('click', function () { go(current + 1); play(); });
			bullets.forEach(function (b) {
				b.addEventListener('click', function () { go(parseInt(b.getAttribute('data-index'), 10)); play(); });
			});
			/* swipe */
			var x0 = null;
			hero.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; stop(); }, { passive: true });
			hero.addEventListener('touchend', function (e) {
				if (x0 === null) return;
				var dx = e.changedTouches[0].clientX - x0;
				if (Math.abs(dx) > 40) go(current + (dx < 0 ? 1 : -1));
				x0 = null;
				play();
			}, { passive: true });
			hero.addEventListener('mouseenter', stop);
			hero.addEventListener('mouseleave', play);
		}
	}

	/* ---------- best sellers tabs ---------- */
	var tabWrap = $('#product-tabs');
	if (tabWrap) {
		$$('.tab-btn', tabWrap).forEach(function (btn) {
			btn.addEventListener('click', function () {
				var tab = btn.getAttribute('data-tab');
				$$('.tab-btn', tabWrap).forEach(function (b) { b.classList.remove('is-active'); });
				btn.classList.add('is-active');
				$$('.products-pane').forEach(function (p) {
					if (p.getAttribute('data-pane') === tab) p.classList.remove('hidden');
					else p.classList.add('hidden');
				});
				$$('.products-pane[data-pane="' + tab + '"] .reveal').forEach(function (r) { r.classList.add('in'); });
			});
		});
	}

	/* ---------- hotspots (touch) ---------- */
	document.addEventListener('click', function (e) {
		var dot = e.target.closest('.hotspot-dot');
		if (!dot) return;
		var hs = dot.closest('.hotspot');
		if (!hs) return;
		var open = hs.classList.contains('open');
		$$('.hotspot.open').forEach(function (h) { h.classList.remove('open'); });
		if (!open) hs.classList.add('open');
	});
	document.addEventListener('click', function (e) {
		if (!e.target.closest('.hotspot')) {
			$$('.hotspot.open').forEach(function (h) { h.classList.remove('open'); });
		}
	});

	/* expose small API */
	window.MiminUI = { toast: toast, openCart: openCart, closeCart: closeCart, observeReveals: observeReveals };
})();
