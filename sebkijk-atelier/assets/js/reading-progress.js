/**
 * SebKijk Atelier — reading progress bar.
 *
 * A single hair-thin red line at the top of the viewport. Only attaches
 * on essay pages; uses requestAnimationFrame for the scroll handler so
 * it stays cheap on long pieces.
 */
(function () {
	'use strict';

	var article = document.querySelector('.essay');
	if (!article) { return; }

	var bar = document.createElement('div');
	bar.className = 'reading-progress';
	bar.setAttribute('role', 'progressbar');
	bar.setAttribute('aria-hidden', 'true');
	document.body.appendChild(bar);

	var ticking = false;
	function update() {
		var rect = article.getBoundingClientRect();
		var total = rect.height - window.innerHeight;
		if (total <= 0) { bar.style.transform = 'scaleX(0)'; ticking = false; return; }
		var passed = Math.min(Math.max(-rect.top, 0), total);
		var pct = passed / total;
		bar.style.transform = 'scaleX(' + pct.toFixed(4) + ')';
		ticking = false;
	}
	function onScroll() {
		if (!ticking) { window.requestAnimationFrame(update); ticking = true; }
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll);
	update();
})();
