/**
 * SebKijk Atelier — minimal scan lightbox.
 *
 * Wires up clicks on scrapbook scans and sketchbook figures so they
 * open in a full-bleed overlay. Esc and click-outside dismiss. No
 * external libraries, no fancy zoom: this is a notebook, not a gallery.
 */
(function () {
	'use strict';

	var triggers = document.querySelectorAll('.scrapbook__item img, .sketchbook__item img, .film__poster img, .sketch__figure img');
	if (!triggers.length) { return; }

	var overlay = document.createElement('div');
	overlay.className = 'lightbox';
	overlay.hidden = true;
	overlay.setAttribute('role', 'dialog');
	overlay.setAttribute('aria-modal', 'true');
	overlay.setAttribute('aria-label', 'Image viewer');
	overlay.innerHTML =
		'<button type="button" class="lightbox__close" aria-label="Close">×</button>' +
		'<figure class="lightbox__figure">' +
			'<img class="lightbox__img" alt="" />' +
			'<figcaption class="lightbox__cap"></figcaption>' +
		'</figure>';
	document.body.appendChild(overlay);

	var imgEl = overlay.querySelector('.lightbox__img');
	var capEl = overlay.querySelector('.lightbox__cap');
	var closeBtn = overlay.querySelector('.lightbox__close');
	var lastFocus = null;

	function open(src, alt, caption) {
		lastFocus = document.activeElement;
		imgEl.src = src;
		imgEl.alt = alt || '';
		capEl.textContent = caption || '';
		capEl.hidden = !caption;
		overlay.hidden = false;
		document.documentElement.classList.add('has-lightbox');
		closeBtn.focus();
	}
	function close() {
		overlay.hidden = true;
		imgEl.src = '';
		document.documentElement.classList.remove('has-lightbox');
		if (lastFocus) { lastFocus.focus(); }
	}

	triggers.forEach(function (img) {
		img.style.cursor = 'zoom-in';
		img.addEventListener('click', function () {
			var src = img.currentSrc || img.src;
			var cap = '';
			var figure = img.closest('figure');
			if (figure) {
				var fc = figure.querySelector('figcaption');
				if (fc) { cap = fc.textContent.trim(); }
			}
			open(src, img.alt, cap);
		});
	});

	overlay.addEventListener('click', function (e) {
		if (e.target === overlay || e.target === closeBtn) { close(); }
	});
	document.addEventListener('keydown', function (e) {
		if (!overlay.hidden && e.key === 'Escape') { close(); }
	});
})();
