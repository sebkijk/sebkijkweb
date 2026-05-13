<?php
/**
 * Taxonomies: directors, countries, decades, themes, tags shared across CPTs.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	register_taxonomy( 'director', array( 'film', 'essay', 'dossier' ), array(
		'labels' => array(
			'name'          => __( 'Directors', 'sebkijk-atelier' ),
			'singular_name' => __( 'Director', 'sebkijk-atelier' ),
			'search_items'  => __( 'Search directors', 'sebkijk-atelier' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'regisseur', 'with_front' => false ),
	) );

	register_taxonomy( 'country', array( 'film', 'essay', 'dossier' ), array(
		'labels' => array(
			'name'          => __( 'Countries', 'sebkijk-atelier' ),
			'singular_name' => __( 'Country', 'sebkijk-atelier' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'land', 'with_front' => false ),
	) );

	register_taxonomy( 'decade', array( 'film', 'essay', 'dossier', 'sketch' ), array(
		'labels' => array(
			'name'          => __( 'Decades', 'sebkijk-atelier' ),
			'singular_name' => __( 'Decade', 'sebkijk-atelier' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'decennium', 'with_front' => false ),
	) );

	register_taxonomy( 'theme_tag', array( 'film', 'essay', 'note', 'dossier', 'sketch' ), array(
		'labels' => array(
			'name'          => __( 'Themes', 'sebkijk-atelier' ),
			'singular_name' => __( 'Theme', 'sebkijk-atelier' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'thema', 'with_front' => false ),
	) );

	register_taxonomy( 'dossier_topic', array( 'dossier' ), array(
		'labels' => array(
			'name'          => __( 'Dossier topics', 'sebkijk-atelier' ),
			'singular_name' => __( 'Dossier topic', 'sebkijk-atelier' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	) );
} );
