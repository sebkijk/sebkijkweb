<?php
/**
 * Minimal SEO + Schema.org output.
 *
 * The theme is not a substitute for a dedicated SEO plugin, but it
 * provides solid defaults so films and essays publish with sensible
 * Open Graph, Twitter card and JSON-LD structured data even on a fresh
 * install.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_head', function () {
	if ( is_singular() ) {
		$post = get_queried_object();
		$desc = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_strip_all_tags( wp_trim_words( $post->post_content, 38 ) );
		$img  = get_the_post_thumbnail_url( $post, 'sebkijk-still' );

		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '">' . "\n";
		if ( $img ) {
			echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
		}
		echo '<meta name="twitter:card" content="' . ( $img ? 'summary_large_image' : 'summary' ) . '">' . "\n";

		sebkijk_emit_jsonld( $post );
	}
}, 8 );

function sebkijk_emit_jsonld( $post ) {
	$type = get_post_type( $post );
	$base = array(
		'@context' => 'https://schema.org',
		'headline' => get_the_title( $post ),
		'datePublished' => get_the_date( 'c', $post ),
		'dateModified'  => get_the_modified_date( 'c', $post ),
		'url'      => get_permalink( $post ),
	);
	$img = get_the_post_thumbnail_url( $post, 'sebkijk-still' );
	if ( $img ) {
		$base['image'] = $img;
	}

	switch ( $type ) {
		case 'film':
			$data = array_merge( array( '@type' => 'Review' ), $base );
			$rating  = sebkijk_field( 'film_rating', $post->ID );
			$dirs    = wp_get_post_terms( $post->ID, 'director', array( 'fields' => 'names' ) );
			$year    = sebkijk_field( 'film_year', $post->ID );
			$orig    = sebkijk_field( 'film_original_title', $post->ID );

			$item = array(
				'@type'      => 'Movie',
				'name'       => get_the_title( $post ),
			);
			if ( $orig )  { $item['alternateName'] = $orig; }
			if ( $year )  { $item['datePublished'] = (string) (int) $year; }
			if ( $dirs && ! is_wp_error( $dirs ) ) {
				$item['director'] = array_map( function ( $d ) { return array( '@type' => 'Person', 'name' => $d ); }, $dirs );
			}
			$data['itemReviewed'] = $item;

			if ( $rating ) {
				$data['reviewRating'] = array(
					'@type'       => 'Rating',
					'ratingValue' => (float) $rating,
					'bestRating'  => 5,
					'worstRating' => 0,
				);
			}
			$data['author'] = array( '@type' => 'Person', 'name' => get_bloginfo( 'name' ) );
			break;

		case 'essay':
			$data = array_merge( array( '@type' => 'Article' ), $base );
			$data['author'] = array( '@type' => 'Person', 'name' => get_the_author_meta( 'display_name', $post->post_author ) );
			break;

		default:
			$data = array_merge( array( '@type' => 'CreativeWork' ), $base );
			break;
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
