# sebkijkweb

A custom WordPress theme — **SebKijk Atelier** — for a Dutch film criticism
and cultural notebook platform. The theme lives in
[`sebkijk-atelier/`](./sebkijk-atelier) and is designed as a digital
sketchbook: minimalist editorial typography on off-white paper, dark red
ink accents, thin divider lines, asymmetrical but readable layouts.

## Features

- **Custom post types**: Films, Essays, Notes, Dossiers, Sketchbook.
- **Film index** — searchable archive with browse-by-decade / director /
  country, inspired by Sabzian and Roger Ebert's Great Movies.
- **Film pages** as scrapbook dossiers — review, notes, quotes, director
  references, scans, related films/essays, revisit log.
- **Notes system** with a `[note]` shortcode that supports inline, margin,
  and beneath-paragraph rendering; notes can also be standalone CPT
  entries attached to an essay or film.
- **Curated homepage** with featured essay, highlighted film, recent
  notes, rotating sketch and archive fragments.
- **ACF integration** with PHP-registered field groups (works without
  ACF too, falling back to post meta).
- Reusable block patterns, block styles, editor CSS.
- Lightweight CSS and vanilla JS — no page builder.

## Install

1. Copy `sebkijk-atelier/` to `wp-content/themes/`.
2. Activate in Appearance → Themes.
3. Visit Settings → Permalinks to flush rewrites.
4. (Recommended) install Advanced Custom Fields.

See [`sebkijk-atelier/readme.txt`](./sebkijk-atelier/readme.txt) for more.