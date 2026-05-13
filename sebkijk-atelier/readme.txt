=== SebKijk Atelier ===

Contributors: sebkijk
Tested up to: 6.5
Requires at least: 6.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A custom WordPress theme for a Dutch film criticism and cultural notebook
platform. Minimalist editorial design, off-white paper, ink typography,
dark red accents.

== Description ==

SebKijk Atelier turns WordPress into a digital sketchbook and editorial
archive. It registers five custom post types — Films, Essays, Notes,
Dossiers and Sketchbook — and provides matching templates:

* Films are scrapbook dossiers (review, notes, quotes, references,
  scans, revisits, related works).
* Essays are long-form pieces with margin notes and a drop cap.
* Notes are short reflective annotations that can attach to other
  posts (margin, inline, beneath, standalone).
* Dossiers gather mixed items around a topic.
* The Sketchbook holds scans, drawings and visual notes.

The homepage is curated — not a generic feed — and exposes ACF picks
for a featured essay, highlighted film, rotating sketch and archive
fragments.

== Requirements ==

* WordPress 6.0+
* PHP 7.4+
* (Optional) Advanced Custom Fields — fields are registered in PHP so
  the theme works without ACF, but the editor experience is best with it.

== Installation ==

1. Copy the `sebkijk-atelier` folder into `wp-content/themes/`.
2. Activate the theme in Appearance → Themes.
3. Visit Settings → Permalinks once to flush rewrite rules.
4. (Recommended) Install Advanced Custom Fields and assign field groups.
5. Create a "Front Page" page and set it under Settings → Reading.

== Notes shortcode ==

Inside any essay or film body:

  [note]A whispered aside in the margin.[/note]
  [note kind="beneath"]A longer reflection beneath the paragraph.[/note]
  [note ref="42"]Inserts published note #42.[/note]

== Changelog ==

= 1.0.0 =
* Initial release.
