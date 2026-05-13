<?php
/**
 * Custom post types: Films, Essays, Notes, Dossiers, Sketchbook.
 *
 * Slugs are deliberately Dutch-friendly while keeping post type keys English.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	register_post_type( 'film', array(
		'labels' => array(
			'name'               => __( 'Films', 'sebkijk-atelier' ),
			'singular_name'      => __( 'Film', 'sebkijk-atelier' ),
			'add_new_item'       => __( 'New film', 'sebkijk-atelier' ),
			'edit_item'          => __( 'Edit film', 'sebkijk-atelier' ),
			'search_items'       => __( 'Search films', 'sebkijk-atelier' ),
			'menu_name'          => __( 'Films', 'sebkijk-atelier' ),
		),
		'public'        => true,
		'has_archive'   => 'films',
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-format-video',
		'menu_position' => 5,
		'rewrite'       => array( 'slug' => 'film', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields', 'comments' ),
	) );

	register_post_type( 'essay', array(
		'labels' => array(
			'name'          => __( 'Essays', 'sebkijk-atelier' ),
			'singular_name' => __( 'Essay', 'sebkijk-atelier' ),
			'add_new_item'  => __( 'New essay', 'sebkijk-atelier' ),
			'edit_item'     => __( 'Edit essay', 'sebkijk-atelier' ),
			'search_items'  => __( 'Search essays', 'sebkijk-atelier' ),
			'menu_name'     => __( 'Essays', 'sebkijk-atelier' ),
		),
		'public'        => true,
		'has_archive'   => 'essays',
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-book-alt',
		'menu_position' => 6,
		'rewrite'       => array( 'slug' => 'essay', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'author', 'custom-fields', 'comments' ),
	) );

	register_post_type( 'note', array(
		'labels' => array(
			'name'          => __( 'Notes', 'sebkijk-atelier' ),
			'singular_name' => __( 'Note', 'sebkijk-atelier' ),
			'add_new_item'  => __( 'New note', 'sebkijk-atelier' ),
			'edit_item'     => __( 'Edit note', 'sebkijk-atelier' ),
			'search_items'  => __( 'Search notes', 'sebkijk-atelier' ),
			'menu_name'     => __( 'Notes', 'sebkijk-atelier' ),
		),
		'public'        => true,
		'has_archive'   => 'notes',
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-edit-page',
		'menu_position' => 7,
		'rewrite'       => array( 'slug' => 'note', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
	) );

	register_post_type( 'dossier', array(
		'labels' => array(
			'name'          => __( 'Dossiers', 'sebkijk-atelier' ),
			'singular_name' => __( 'Dossier', 'sebkijk-atelier' ),
			'add_new_item'  => __( 'New dossier', 'sebkijk-atelier' ),
			'edit_item'     => __( 'Edit dossier', 'sebkijk-atelier' ),
			'search_items'  => __( 'Search dossiers', 'sebkijk-atelier' ),
			'menu_name'     => __( 'Dossiers', 'sebkijk-atelier' ),
		),
		'public'        => true,
		'has_archive'   => 'dossiers',
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 8,
		'rewrite'       => array( 'slug' => 'dossier', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
	) );

	register_post_type( 'sketch', array(
		'labels' => array(
			'name'          => __( 'Sketchbook', 'sebkijk-atelier' ),
			'singular_name' => __( 'Sketch', 'sebkijk-atelier' ),
			'add_new_item'  => __( 'New sketch', 'sebkijk-atelier' ),
			'edit_item'     => __( 'Edit sketch', 'sebkijk-atelier' ),
			'search_items'  => __( 'Search sketchbook', 'sebkijk-atelier' ),
			'menu_name'     => __( 'Sketchbook', 'sebkijk-atelier' ),
		),
		'public'        => true,
		'has_archive'   => 'sketchbook',
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-art',
		'menu_position' => 9,
		'rewrite'       => array( 'slug' => 'sketch', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
	) );
} );

/**
 * Make the film archive searchable: include CPTs in the main search query.
 */
add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_search() ) {
		$query->set( 'post_type', array( 'post', 'film', 'essay', 'note', 'dossier', 'sketch' ) );
	}

	// Film archive: order by year, then title, and paginate sparingly.
	if ( $query->is_post_type_archive( 'film' ) ) {
		$query->set( 'posts_per_page', 36 );
		$query->set( 'meta_key',       'film_year' );
		$query->set( 'orderby',        array( 'meta_value_num' => 'DESC', 'title' => 'ASC' ) );
	}

	if ( $query->is_post_type_archive( 'note' ) ) {
		$query->set( 'posts_per_page', 40 );
	}
} );

/**
 * Register a flush on theme activation so the new rewrite rules apply.
 */
add_action( 'after_switch_theme', function () {
	flush_rewrite_rules();
} );
