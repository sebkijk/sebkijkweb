<?php
/**
 * Template tags used throughout the theme.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read an ACF field with a graceful fallback to post meta if ACF is missing.
 */
function sebkijk_field( $name, $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();

	if ( function_exists( 'get_field' ) ) {
		return get_field( $name, $post_id );
	}
	return get_post_meta( $post_id, $name, true );
}

/**
 * Render the editorial dateline block: monospace date, post type, primary taxonomy.
 */
function sebkijk_dateline( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$type    = get_post_type_object( get_post_type( $post_id ) );
	$label   = $type ? $type->labels->singular_name : '';

	$tax_label = '';
	$primary_tax = sebkijk_primary_taxonomy_for( get_post_type( $post_id ) );
	if ( $primary_tax ) {
		$terms = get_the_terms( $post_id, $primary_tax );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$tax_label = esc_html( $terms[0]->name );
		}
	}
	?>
	<p class="dateline">
		<time datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y', $post_id ) ); ?></time>
		<span class="dateline__sep" aria-hidden="true">·</span>
		<span class="dateline__kind"><?php echo esc_html( $label ); ?></span>
		<?php if ( $tax_label ) : ?>
			<span class="dateline__sep" aria-hidden="true">·</span>
			<span class="dateline__topic"><?php echo $tax_label; ?></span>
		<?php endif; ?>
	</p>
	<?php
}

function sebkijk_primary_taxonomy_for( $post_type ) {
	switch ( $post_type ) {
		case 'film':    return 'director';
		case 'essay':   return 'theme_tag';
		case 'note':    return 'theme_tag';
		case 'dossier': return 'dossier_topic';
		case 'sketch':  return 'theme_tag';
	}
	return '';
}

/**
 * Render a thin divider with optional ornament.
 */
function sebkijk_divider( $ornament = '·' ) {
	echo '<hr class="rule" role="separator" />';
	if ( $ornament ) {
		echo '<p class="ornament" aria-hidden="true">' . esc_html( $ornament ) . '</p>';
	}
}

/**
 * Cinematic header: title with an optional subtitle / original title / year.
 */
function sebkijk_film_header( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$original = sebkijk_field( 'film_original_title', $post_id );
	$year     = sebkijk_field( 'film_year', $post_id );
	?>
	<header class="film-header">
		<p class="film-header__eyebrow"><?php esc_html_e( 'Film dossier', 'sebkijk-atelier' ); ?></p>
		<h1 class="film-header__title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>
		<?php if ( $original || $year ) : ?>
			<p class="film-header__meta">
				<?php if ( $original ) : ?><em><?php echo esc_html( $original ); ?></em><?php endif; ?>
				<?php if ( $original && $year ) : ?><span aria-hidden="true">·</span><?php endif; ?>
				<?php if ( $year ) : ?><span><?php echo esc_html( $year ); ?></span><?php endif; ?>
			</p>
		<?php endif; ?>
	</header>
	<?php
}

/**
 * Film "credits sidebar" – cinematographer, language, runtime, rating.
 */
function sebkijk_film_credits( $post_id = null ) {
	$post_id   = $post_id ?: get_the_ID();
	$director  = get_the_term_list( $post_id, 'director', '', ', ', '' );
	$country   = get_the_term_list( $post_id, 'country', '', ', ', '' );
	$language  = sebkijk_field( 'film_language', $post_id );
	$runtime   = sebkijk_field( 'film_runtime', $post_id );
	$camera    = sebkijk_field( 'film_cinematographer', $post_id );
	$cast      = sebkijk_field( 'film_cast', $post_id );
	$rating    = sebkijk_field( 'film_rating', $post_id );

	$rows = array_filter( array(
		'Regie'           => $director,
		'Land'            => $country,
		'Taal'            => $language ? esc_html( $language ) : '',
		'Duur'            => $runtime ? sprintf( '%d min', (int) $runtime ) : '',
		'Camera'          => $camera ? esc_html( $camera ) : '',
		'Cast'            => $cast ? nl2br( esc_html( $cast ) ) : '',
		'Waardering'      => $rating ? sebkijk_render_rating( $rating ) : '',
	) );

	if ( ! $rows ) {
		return;
	}
	?>
	<aside class="film-credits" aria-label="<?php esc_attr_e( 'Film credits', 'sebkijk-atelier' ); ?>">
		<dl class="film-credits__list">
			<?php foreach ( $rows as $label => $value ) : ?>
				<div class="film-credits__row">
					<dt><?php echo esc_html( $label ); ?></dt>
					<dd><?php echo $value; // Already escaped above. ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</aside>
	<?php
}

function sebkijk_render_rating( $rating ) {
	$rating = max( 0, min( 5, (float) $rating ) );
	$full   = floor( $rating );
	$half   = ( $rating - $full ) >= 0.5 ? 1 : 0;
	$empty  = 5 - $full - $half;
	$out    = '<span class="rating" aria-label="' . esc_attr( sprintf( '%s of 5', $rating ) ) . '">';
	$out   .= str_repeat( '●', (int) $full );
	$out   .= str_repeat( '◐', (int) $half );
	$out   .= str_repeat( '○', (int) $empty );
	$out   .= '</span>';
	return $out;
}

/**
 * Render a list of related posts based on an ACF relationship.
 */
function sebkijk_related_list( $field, $post_id = null, $heading = '' ) {
	$post_id = $post_id ?: get_the_ID();
	$ids = sebkijk_field( $field, $post_id );
	if ( ! $ids || ! is_array( $ids ) ) {
		return;
	}

	echo '<section class="related">';
	if ( $heading ) {
		echo '<h2 class="related__heading">' . esc_html( $heading ) . '</h2>';
	}
	echo '<ul class="related__list">';
	foreach ( $ids as $rid ) {
		$rid = is_object( $rid ) ? $rid->ID : (int) $rid;
		if ( ! $rid ) { continue; }
		?>
		<li class="related__item">
			<a class="related__link" href="<?php echo esc_url( get_permalink( $rid ) ); ?>">
				<span class="related__title"><?php echo esc_html( get_the_title( $rid ) ); ?></span>
				<span class="related__kind"><?php echo esc_html( get_post_type_object( get_post_type( $rid ) )->labels->singular_name ); ?></span>
			</a>
		</li>
		<?php
	}
	echo '</ul></section>';
}

/**
 * Render the search form used in the film index header.
 */
function sebkijk_filmindex_search() {
	?>
	<form role="search" class="filmindex-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="filmindex-search__label" for="filmindex-q"><?php esc_html_e( 'Search the index', 'sebkijk-atelier' ); ?></label>
		<input id="filmindex-q" class="filmindex-search__input" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Title, director, theme', 'sebkijk-atelier' ); ?>" />
		<input type="hidden" name="post_type" value="film" />
		<button type="submit" class="filmindex-search__submit"><?php esc_html_e( 'Find', 'sebkijk-atelier' ); ?></button>
	</form>
	<?php
}

/**
 * Pagination – minimalist.
 */
function sebkijk_pagination() {
	the_posts_pagination( array(
		'mid_size'  => 1,
		'prev_text' => '<span aria-hidden="true">←</span> ' . __( 'Earlier', 'sebkijk-atelier' ),
		'next_text' => __( 'Later', 'sebkijk-atelier' ) . ' <span aria-hidden="true">→</span>',
	) );
}
