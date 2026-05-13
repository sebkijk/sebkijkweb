<?php
/**
 * Customizer: a small set of editorial preferences.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function ( $wp_customize ) {

	$wp_customize->add_section( 'sebkijk_atelier', array(
		'title'    => __( 'Atelier', 'sebkijk-atelier' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'sebkijk_accent_color', array(
		'default'           => '#8a1a1a',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sebkijk_accent_color', array(
		'label'    => __( 'Accent colour', 'sebkijk-atelier' ),
		'section'  => 'sebkijk_atelier',
		'settings' => 'sebkijk_accent_color',
	) ) );

	$wp_customize->add_setting( 'sebkijk_paper_color', array(
		'default'           => '#f3eee3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sebkijk_paper_color', array(
		'label'    => __( 'Paper background', 'sebkijk-atelier' ),
		'section'  => 'sebkijk_atelier',
		'settings' => 'sebkijk_paper_color',
	) ) );

	$wp_customize->add_setting( 'sebkijk_masthead_style', array(
		'default'           => 'editorial',
		'sanitize_callback' => function ( $v ) {
			return in_array( $v, array( 'editorial', 'minimal', 'cinematic' ), true ) ? $v : 'editorial';
		},
	) );
	$wp_customize->add_control( 'sebkijk_masthead_style', array(
		'label'    => __( 'Masthead style', 'sebkijk-atelier' ),
		'section'  => 'sebkijk_atelier',
		'type'     => 'select',
		'choices'  => array(
			'editorial' => __( 'Editorial (date + tag)', 'sebkijk-atelier' ),
			'minimal'   => __( 'Minimal (name only)', 'sebkijk-atelier' ),
			'cinematic' => __( 'Cinematic (large italic)', 'sebkijk-atelier' ),
		),
	) );

	$wp_customize->add_setting( 'sebkijk_show_grain', array(
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	) );
	$wp_customize->add_control( 'sebkijk_show_grain', array(
		'label'    => __( 'Show paper grain texture', 'sebkijk-atelier' ),
		'section'  => 'sebkijk_atelier',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'sebkijk_colophon_text', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'sebkijk_colophon_text', array(
		'label'       => __( 'Colophon (footer note)', 'sebkijk-atelier' ),
		'description' => __( 'A short paragraph rendered in the footer.', 'sebkijk-atelier' ),
		'section'     => 'sebkijk_atelier',
		'type'        => 'textarea',
	) );
} );

/**
 * Inline custom-property overrides driven by Customizer settings.
 */
add_action( 'wp_head', function () {
	$accent = get_theme_mod( 'sebkijk_accent_color', '#8a1a1a' );
	$paper  = get_theme_mod( 'sebkijk_paper_color',  '#f3eee3' );
	$grain  = get_theme_mod( 'sebkijk_show_grain',   true );

	echo '<style id="sebkijk-customizer">:root{';
	echo '--c-accent:' . esc_attr( $accent ) . ';';
	echo '--c-accent-dark:' . esc_attr( sebkijk_darken( $accent, 0.18 ) ) . ';';
	echo '--c-paper:' . esc_attr( $paper ) . ';';
	echo '}';
	if ( ! $grain ) {
		echo 'body{background-image:none !important;}';
	}
	echo '</style>' . "\n";
}, 20 );

/**
 * Tiny hex-darken helper used for the accent hover state.
 */
function sebkijk_darken( $hex, $amount = 0.15 ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( strlen( $hex ) === 3 ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( strlen( $hex ) !== 6 ) {
		return '#' . $hex;
	}
	$r = max( 0, min( 255, hexdec( substr( $hex, 0, 2 ) ) * ( 1 - $amount ) ) );
	$g = max( 0, min( 255, hexdec( substr( $hex, 2, 2 ) ) * ( 1 - $amount ) ) );
	$b = max( 0, min( 255, hexdec( substr( $hex, 4, 2 ) ) * ( 1 - $amount ) ) );
	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Body class for the masthead variant so CSS can adjust the homepage head.
 */
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'masthead-' . get_theme_mod( 'sebkijk_masthead_style', 'editorial' );
	return $classes;
} );
