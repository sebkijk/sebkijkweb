<?php
/**
 * Theme setup: supports, menus, image sizes.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'sebkijk-atelier', SEBKIJK_ATELIER_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-spacing' );

	// Custom image sizes used across film dossiers and the homepage.
	add_image_size( 'sebkijk-portrait', 640, 900, true );
	add_image_size( 'sebkijk-still',    1280, 720, true );
	add_image_size( 'sebkijk-scan',     1400, 0,   false );
	add_image_size( 'sebkijk-thumb',    320, 320, true );

	register_nav_menus( array(
		'primary'  => __( 'Primary', 'sebkijk-atelier' ),
		'footer'   => __( 'Footer', 'sebkijk-atelier' ),
		'archives' => __( 'Archives', 'sebkijk-atelier' ),
	) );

	add_editor_style( 'assets/css/editor.css' );
} );

/**
 * Register sidebars used by the theme.
 */
add_action( 'widgets_init', function () {
	register_sidebar( array(
		'name'          => __( 'Colophon', 'sebkijk-atelier' ),
		'id'            => 'colophon',
		'description'   => __( 'Appears in the footer.', 'sebkijk-atelier' ),
		'before_widget' => '<section id="%1$s" class="colophon__widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="colophon__title">',
		'after_title'   => '</h2>',
	) );
} );

/**
 * Editorial body classes — used by the CSS to switch layouts per post type.
 */
add_filter( 'body_class', function ( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'is-singular-' . get_post_type();
	}
	if ( is_post_type_archive() ) {
		$classes[] = 'is-archive-' . get_post_type();
	}
	return $classes;
} );

/**
 * Excerpt: ellipsis and length tuned for editorial cards.
 */
add_filter( 'excerpt_more',   fn () => "\xE2\x80\xA6" );
add_filter( 'excerpt_length', fn ()  => 28 );
