<?php
/**
 * Advanced Custom Fields registration.
 *
 * Registered programmatically so the theme works even without exporting
 * an ACF JSON file. If ACF is missing the theme falls back to standard
 * post meta — see template-tags.php → sebkijk_field().
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/* ------------------------------------------------------------------ Film */
	acf_add_local_field_group( array(
		'key'    => 'group_sebkijk_film',
		'title'  => __( 'Film dossier', 'sebkijk-atelier' ),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'film' ) ) ),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
		'fields' => array(
			array( 'key' => 'field_film_original_title', 'label' => __( 'Original title', 'sebkijk-atelier' ), 'name' => 'film_original_title', 'type' => 'text' ),
			array( 'key' => 'field_film_year',     'label' => __( 'Year', 'sebkijk-atelier' ),   'name' => 'film_year',     'type' => 'number', 'min' => 1880, 'max' => 2100 ),
			array( 'key' => 'field_film_runtime',  'label' => __( 'Runtime (min)', 'sebkijk-atelier' ), 'name' => 'film_runtime', 'type' => 'number' ),
			array( 'key' => 'field_film_language', 'label' => __( 'Language', 'sebkijk-atelier' ), 'name' => 'film_language', 'type' => 'text' ),
			array( 'key' => 'field_film_cinematographer', 'label' => __( 'Cinematographer', 'sebkijk-atelier' ), 'name' => 'film_cinematographer', 'type' => 'text' ),
			array( 'key' => 'field_film_cast', 'label' => __( 'Cast', 'sebkijk-atelier' ), 'name' => 'film_cast', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_film_rating', 'label' => __( 'Personal rating (0–5)', 'sebkijk-atelier' ), 'name' => 'film_rating', 'type' => 'number', 'min' => 0, 'max' => 5, 'step' => 0.5 ),
			array(
				'key' => 'field_film_review', 'label' => __( 'Review', 'sebkijk-atelier' ),
				'name' => 'film_review', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'full',
			),
			array(
				'key' => 'field_film_quotes', 'label' => __( 'Quotes', 'sebkijk-atelier' ),
				'name' => 'film_quotes', 'type' => 'repeater', 'layout' => 'row',
				'button_label' => __( 'Add quote', 'sebkijk-atelier' ),
				'sub_fields' => array(
					array( 'key' => 'field_film_quote_text',   'label' => __( 'Quote', 'sebkijk-atelier' ),   'name' => 'quote',  'type' => 'textarea' ),
					array( 'key' => 'field_film_quote_source', 'label' => __( 'Source / speaker', 'sebkijk-atelier' ), 'name' => 'source', 'type' => 'text' ),
				),
			),
			array(
				'key' => 'field_film_director_refs', 'label' => __( 'Director references', 'sebkijk-atelier' ),
				'name' => 'film_director_refs', 'type' => 'textarea', 'rows' => 4,
				'instructions' => __( 'Free-form references, one per line.', 'sebkijk-atelier' ),
			),
			array(
				'key' => 'field_film_related_films', 'label' => __( 'Related films', 'sebkijk-atelier' ),
				'name' => 'film_related_films', 'type' => 'relationship',
				'post_type' => array( 'film' ), 'max' => 12, 'return_format' => 'id',
			),
			array(
				'key' => 'field_film_related_essays', 'label' => __( 'Related essays', 'sebkijk-atelier' ),
				'name' => 'film_related_essays', 'type' => 'relationship',
				'post_type' => array( 'essay' ), 'max' => 12, 'return_format' => 'id',
			),
			array(
				'key' => 'field_film_scans', 'label' => __( 'Scans & visual annotations', 'sebkijk-atelier' ),
				'name' => 'film_scans', 'type' => 'gallery', 'return_format' => 'array',
			),
			array(
				'key' => 'field_film_revisits', 'label' => __( 'Revisit notes', 'sebkijk-atelier' ),
				'name' => 'film_revisits', 'type' => 'repeater', 'layout' => 'block',
				'button_label' => __( 'Add revisit', 'sebkijk-atelier' ),
				'sub_fields' => array(
					array( 'key' => 'field_film_revisit_date', 'label' => __( 'Date', 'sebkijk-atelier' ), 'name' => 'date', 'type' => 'date_picker', 'display_format' => 'd-m-Y', 'return_format' => 'Y-m-d' ),
					array( 'key' => 'field_film_revisit_note', 'label' => __( 'Note', 'sebkijk-atelier' ), 'name' => 'note', 'type' => 'textarea' ),
				),
			),
		),
	) );

	/* ----------------------------------------------------------------- Essay */
	acf_add_local_field_group( array(
		'key'    => 'group_sebkijk_essay',
		'title'  => __( 'Essay metadata', 'sebkijk-atelier' ),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'essay' ) ) ),
		'fields' => array(
			array( 'key' => 'field_essay_subtitle', 'label' => __( 'Subtitle', 'sebkijk-atelier' ), 'name' => 'essay_subtitle', 'type' => 'text' ),
			array( 'key' => 'field_essay_dek',      'label' => __( 'Dek / standfirst', 'sebkijk-atelier' ), 'name' => 'essay_dek', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_essay_reading_time', 'label' => __( 'Reading time (min)', 'sebkijk-atelier' ), 'name' => 'essay_reading_time', 'type' => 'number' ),
			array(
				'key' => 'field_essay_related_films', 'label' => __( 'Related films', 'sebkijk-atelier' ),
				'name' => 'essay_related_films', 'type' => 'relationship',
				'post_type' => array( 'film' ), 'max' => 12, 'return_format' => 'id',
			),
			array(
				'key' => 'field_essay_notes', 'label' => __( 'Linked notes', 'sebkijk-atelier' ),
				'name' => 'essay_notes', 'type' => 'relationship',
				'post_type' => array( 'note' ), 'return_format' => 'id',
			),
		),
	) );

	/* ------------------------------------------------------------------ Note */
	acf_add_local_field_group( array(
		'key'    => 'group_sebkijk_note',
		'title'  => __( 'Note', 'sebkijk-atelier' ),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'note' ) ) ),
		'fields' => array(
			array(
				'key' => 'field_note_kind', 'label' => __( 'Kind', 'sebkijk-atelier' ),
				'name' => 'note_kind', 'type' => 'select',
				'choices' => array(
					'margin'    => __( 'Margin note', 'sebkijk-atelier' ),
					'inline'    => __( 'Inline note', 'sebkijk-atelier' ),
					'beneath'   => __( 'Beneath paragraph', 'sebkijk-atelier' ),
					'standalone'=> __( 'Standalone', 'sebkijk-atelier' ),
				),
				'default_value' => 'standalone',
			),
			array( 'key' => 'field_note_anchor', 'label' => __( 'Anchor (in essay/film)', 'sebkijk-atelier' ), 'name' => 'note_anchor', 'type' => 'text', 'instructions' => __( 'Optional id for inline anchoring.', 'sebkijk-atelier' ) ),
			array(
				'key' => 'field_note_attaches_to', 'label' => __( 'Attaches to', 'sebkijk-atelier' ),
				'name' => 'note_attaches_to', 'type' => 'relationship',
				'post_type' => array( 'essay', 'film', 'dossier' ), 'max' => 1, 'return_format' => 'id',
			),
		),
	) );

	/* --------------------------------------------------------------- Dossier */
	acf_add_local_field_group( array(
		'key'    => 'group_sebkijk_dossier',
		'title'  => __( 'Dossier', 'sebkijk-atelier' ),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'dossier' ) ) ),
		'fields' => array(
			array( 'key' => 'field_dossier_intro', 'label' => __( 'Introduction', 'sebkijk-atelier' ), 'name' => 'dossier_intro', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0 ),
			array(
				'key' => 'field_dossier_items', 'label' => __( 'Dossier items', 'sebkijk-atelier' ),
				'name' => 'dossier_items', 'type' => 'relationship',
				'post_type' => array( 'film', 'essay', 'note', 'sketch' ), 'return_format' => 'id',
			),
		),
	) );

	/* ------------------------------------------------------------- Sketchbook */
	acf_add_local_field_group( array(
		'key'    => 'group_sebkijk_sketch',
		'title'  => __( 'Sketch', 'sebkijk-atelier' ),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'sketch' ) ) ),
		'fields' => array(
			array( 'key' => 'field_sketch_caption', 'label' => __( 'Caption', 'sebkijk-atelier' ), 'name' => 'sketch_caption', 'type' => 'textarea', 'rows' => 2 ),
			array( 'key' => 'field_sketch_medium',  'label' => __( 'Medium', 'sebkijk-atelier' ), 'name' => 'sketch_medium', 'type' => 'text' ),
			array( 'key' => 'field_sketch_date',    'label' => __( 'Date made', 'sebkijk-atelier' ), 'name' => 'sketch_date', 'type' => 'date_picker', 'display_format' => 'd-m-Y', 'return_format' => 'Y-m-d' ),
		),
	) );

	/* -------------------------------------------------- Front-page curation */
	acf_add_local_field_group( array(
		'key'    => 'group_sebkijk_front',
		'title'  => __( 'Front page', 'sebkijk-atelier' ),
		'location' => array( array(
			array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ),
		) ),
		'fields' => array(
			array( 'key' => 'field_home_featured_essay', 'label' => __( 'Featured essay', 'sebkijk-atelier' ), 'name' => 'home_featured_essay', 'type' => 'post_object', 'post_type' => array( 'essay' ), 'return_format' => 'id' ),
			array( 'key' => 'field_home_highlighted_film', 'label' => __( 'Highlighted film', 'sebkijk-atelier' ), 'name' => 'home_highlighted_film', 'type' => 'post_object', 'post_type' => array( 'film' ), 'return_format' => 'id' ),
			array( 'key' => 'field_home_sketches', 'label' => __( 'Rotating sketches', 'sebkijk-atelier' ), 'name' => 'home_sketches', 'type' => 'relationship', 'post_type' => array( 'sketch' ), 'return_format' => 'id' ),
			array( 'key' => 'field_home_fragments_intro', 'label' => __( 'Archive fragments intro', 'sebkijk-atelier' ), 'name' => 'home_fragments_intro', 'type' => 'textarea', 'rows' => 2 ),
		),
	) );
} );

/**
 * Mirror a couple of ACF fields into native post meta so WP_Query can sort
 * the film archive by year even before ACF is fully loaded.
 */
add_action( 'acf/save_post', function ( $post_id ) {
	if ( get_post_type( $post_id ) !== 'film' ) {
		return;
	}
	$year = get_field( 'film_year', $post_id );
	if ( $year ) {
		update_post_meta( $post_id, 'film_year', (int) $year );
	}
}, 20 );
