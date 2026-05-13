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

	register_block_pattern( 'sebkijk-atelier/dek', array(
		'title'       => __( 'Editorial dek', 'sebkijk-atelier' ),
		'description' => __( 'Eyebrow + italic standfirst above an essay.', 'sebkijk-atelier' ),
		'categories'  => array( 'sebkijk' ),
		'content'     => '<!-- wp:paragraph {"className":"eyebrow"} --><p class="eyebrow">' . esc_html__( 'Essay', 'sebkijk-atelier' ) . '</p><!-- /wp:paragraph --><!-- wp:heading {"level":1} --><h1>' . esc_html__( 'A title in italic Garamond', 'sebkijk-atelier' ) . '</h1><!-- /wp:heading --><!-- wp:paragraph {"className":"essay__dek"} --><p class="essay__dek"><em>' . esc_html__( 'A standfirst: one or two sentences that frame the piece.', 'sebkijk-atelier' ) . '</em></p><!-- /wp:paragraph -->',
	) );

	register_block_pattern( 'sebkijk-atelier/revisit-log', array(
		'title'       => __( 'Revisit log', 'sebkijk-atelier' ),
		'description' => __( 'A short table of rewatchings, with dates and notes.', 'sebkijk-atelier' ),
		'categories'  => array( 'sebkijk' ),
		'content'     => '<!-- wp:heading {"level":2} --><h2>' . esc_html__( 'Revisits', 'sebkijk-atelier' ) . '</h2><!-- /wp:heading --><!-- wp:list {"ordered":true,"className":"film__revisits-list"} --><ol class="film__revisits-list"><!-- wp:list-item --><li><time>2024-11-02</time> <p>' . esc_html__( 'Saw it again, late at night. The doorway scene reads differently now.', 'sebkijk-atelier' ) . '</p></li><!-- /wp:list-item --><!-- wp:list-item --><li><time>2022-03-17</time> <p>' . esc_html__( 'First viewing. Noted: the score begins under the opening credits.', 'sebkijk-atelier' ) . '</p></li><!-- /wp:list-item --></ol><!-- /wp:list -->',
	) );

	register_block_pattern( 'sebkijk-atelier/dossier-index', array(
		'title'       => __( 'Dossier index', 'sebkijk-atelier' ),
		'description' => __( 'A numbered table of contents for a long dossier.', 'sebkijk-atelier' ),
		'categories'  => array( 'sebkijk' ),
		'content'     => '<!-- wp:separator {"className":"is-style-thin"} --><hr class="wp-block-separator is-style-thin"/><!-- /wp:separator --><!-- wp:heading {"level":3} --><h3>' . esc_html__( 'Contents', 'sebkijk-atelier' ) . '</h3><!-- /wp:heading --><!-- wp:list {"ordered":true} --><ol><!-- wp:list-item --><li><a href="#one">' . esc_html__( 'First panel', 'sebkijk-atelier' ) . '</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#two">' . esc_html__( 'Second panel', 'sebkijk-atelier' ) . '</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#three">' . esc_html__( 'Coda', 'sebkijk-atelier' ) . '</a></li><!-- /wp:list-item --></ol><!-- /wp:list -->',
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
