<?php
/**
 * Enqueue styles and scripts.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	// Stylesheet header (required by WordPress).
	wp_enqueue_style(
		'sebkijk-atelier',
		get_stylesheet_uri(),
		array(),
		SEBKIJK_ATELIER_VERSION
	);

	// Typography first so cascade can be overridden by layout / components.
	wp_enqueue_style(
		'sebkijk-typography',
		SEBKIJK_ATELIER_URI . '/assets/css/typography.css',
		array( 'sebkijk-atelier' ),
		SEBKIJK_ATELIER_VERSION
	);

	wp_enqueue_style(
		'sebkijk-main',
		SEBKIJK_ATELIER_URI . '/assets/css/main.css',
		array( 'sebkijk-typography' ),
		SEBKIJK_ATELIER_VERSION
	);

	wp_enqueue_script(
		'sebkijk-main',
		SEBKIJK_ATELIER_URI . '/assets/js/main.js',
		array(),
		SEBKIJK_ATELIER_VERSION,
		true
	);

	if ( is_singular() ) {
		wp_enqueue_script(
			'sebkijk-notes',
			SEBKIJK_ATELIER_URI . '/assets/js/notes.js',
			array(),
			SEBKIJK_ATELIER_VERSION,
			true
		);
	}

	if ( is_comment_feed() === false && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}, 20 );

/**
 * Preconnect to Google Fonts for the serif + monospace pairing.
 */
add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=JetBrains+Mono:wght@400;500&family=Inter:wght@400;500;600&display=swap">' . "\n";
}, 5 );
