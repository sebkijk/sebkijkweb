/**
 * SebKijk Atelier — notes interactions.
 *
 * On narrow viewports we collapse margin notes into a tappable indicator
 * (a small superscript) that expands the note in place. On wide
 * viewports the CSS lifts margin notes into the right gutter and we leave
 * the DOM untouched.
 */
(function () {
	'use strict';

	var BREAKPOINT = 1100;

	function decorate(note, index) {
		if (note.dataset.kind !== 'margin') { return; }
		if (note.querySelector('.note__handle')) { return; }

		var handle = document.createElement('button');
		handle.type = 'button';
		handle.className = 'note__handle';
		handle.setAttribute('aria-expanded', 'false');
		handle.setAttribute('aria-label', 'Note ' + (index + 1));
		handle.textContent = String(index + 1);

		var inner = note.querySelector('.note__inner');
		inner.hidden = true;
		note.classList.add('note--collapsed');
		note.insertBefore(handle, inner);

		handle.addEventListener('click', function () {
			var open = note.classList.toggle('is-open');
			handle.setAttribute('aria-expanded', open ? 'true' : 'false');
			inner.hidden = !open;
		});
	}

	function reset(note) {
		var handle = note.querySelector('.note__handle');
		if (handle) { handle.remove(); }
		var inner = note.querySelector('.note__inner');
		if (inner) { inner.hidden = false; }
		note.classList.remove('note--collapsed', 'is-open');
	}

	function apply() {
		var narrow = window.matchMedia('(max-width: ' + (BREAKPOINT - 1) + 'px)').matches;
		var notes = document.querySelectorAll('.note--margin');
		notes.forEach(function (n, i) {
			if (narrow) {
				decorate(n, i);
			} else {
				reset(n);
			}
		});
	}

	apply();
	window.addEventListener('resize', debounce(apply, 200));

	function debounce(fn, delay) {
		var t;
		return function () {
			var args = arguments;
			clearTimeout(t);
			t = setTimeout(function () { fn.apply(null, args); }, delay);
		};
	}
})();
