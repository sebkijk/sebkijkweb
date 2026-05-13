/**
 * SebKijk Atelier — small UI behaviours.
 * Vanilla JS, no dependencies. Loaded with `defer` in the footer.
 */
(function () {
	'use strict';

	// Toggle film-index facets on small screens: keep one open at a time
	// so the page does not become a long accordion.
	var facets = document.querySelectorAll('.filmindex__facet');
	if (facets.length) {
		facets.forEach(function (facet) {
			facet.addEventListener('toggle', function () {
				if (!facet.open) { return; }
				facets.forEach(function (other) {
					if (other !== facet) { other.open = false; }
				});
			});
		});
	}

	// Reveal-on-scroll for cards and scrapbook items: a quiet fade-in.
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -10% 0px' });

		document.querySelectorAll('.card, .filmcard, .scrapbook__item, .essaycard').forEach(function (el) {
			el.classList.add('to-reveal');
			io.observe(el);
		});
	}
})();
