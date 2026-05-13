<?php
/**
 * Reusable block patterns + a tiny block style registry.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category( 'sebkijk', array(
		'label' => __( 'SebKijk Atelier', 'sebkijk-atelier' ),
	) );

	register_block_pattern( 'sebkijk-atelier/pull-quote', array(
		'title'       => __( 'Editorial pull quote', 'sebkijk-atelier' ),
		'description' => __( 'A serif pull quote with a thin rule above.', 'sebkijk-atelier' ),
		'categories'  => array( 'sebkijk' ),
		'content'     => '<!-- wp:separator {"className":"is-style-thin"} --><hr class="wp-block-separator has-css-opacity is-style-thin"/><!-- /wp:separator --><!-- wp:pullquote {"className":"is-style-atelier"} --><figure class="wp-block-pullquote is-style-atelier"><blockquote><p>' . esc_html__( 'The frame is small but the world is large.', 'sebkijk-atelier' ) . '</p><cite>' . esc_html__( 'Robert Bresson', 'sebkijk-atelier' ) . '</cite></blockquote></figure><!-- /wp:pullquote -->',
	) );

	register_block_pattern( 'sebkijk-atelier/marginalia', array(
		'title'       => __( 'Marginalia paragraph', 'sebkijk-atelier' ),
		'description' => __( 'A paragraph with a note in the margin.', 'sebkijk-atelier' ),
		'categories'  => array( 'sebkijk' ),
		'content'     => '<!-- wp:paragraph --><p>' . esc_html__( 'Body paragraph that anchors the marginal note.', 'sebkijk-atelier' ) . ' [note]' . esc_html__( 'A whispered aside in the margin.', 'sebkijk-atelier' ) . '[/note]</p><!-- /wp:paragraph -->',
	) );

	register_block_pattern( 'sebkijk-atelier/film-scrapbook', array(
		'title'       => __( 'Film scrapbook row', 'sebkijk-atelier' ),
		'description' => __( 'Two columns: scan + annotation.', 'sebkijk-atelier' ),
		'categories'  => array( 'sebkijk' ),
		'content'     => '<!-- wp:columns {"className":"scrapbook-row"} --><div class="wp-block-columns scrapbook-row"><!-- wp:column {"width":"58%"} --><div class="wp-block-column" style="flex-basis:58%"><!-- wp:image {"className":"is-style-scan"} --><figure class="wp-block-image is-style-scan"><img alt=""/></figure><!-- /wp:image --></div><!-- /wp:column --><!-- wp:column {"width":"42%"} --><div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"annotation"} --><p class="annotation">' . esc_html__( 'Annotation: what the scan reveals.', 'sebkijk-atelier' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
	) );

	// Block styles.
	if ( function_exists( 'register_block_style' ) ) {
		register_block_style( 'core/separator', array(
			'name'  => 'thin',
			'label' => __( 'Thin rule', 'sebkijk-atelier' ),
		) );
		register_block_style( 'core/pullquote', array(
			'name'  => 'atelier',
			'label' => __( 'Atelier', 'sebkijk-atelier' ),
		) );
		register_block_style( 'core/image', array(
			'name'  => 'scan',
			'label' => __( 'Scan', 'sebkijk-atelier' ),
		) );
		register_block_style( 'core/quote', array(
			'name'  => 'marginalia',
			'label' => __( 'Marginalia', 'sebkijk-atelier' ),
		) );
	}
} );
