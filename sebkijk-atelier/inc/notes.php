<?php
/**
 * Notes system.
 *
 * A "note" is a personal, reflective annotation that can be:
 *   – attached to an essay/film/dossier (margin / inline / beneath)
 *   – published standalone in /notes/
 *
 * In long-form content authors can write:
 *
 *   [note]A short note that appears in the margin.[/note]
 *   [note kind="beneath" id="paris-1968"]A note that opens beneath the paragraph.[/note]
 *   [note ref="42"]Inserts the published note with ID 42 as a margin note.[/note]
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'note', function ( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'kind' => 'margin',
		'id'   => '',
		'ref'  => 0,
	), $atts, 'note' );

	$kind = in_array( $atts['kind'], array( 'margin', 'inline', 'beneath' ), true ) ? $atts['kind'] : 'margin';

	if ( $atts['ref'] ) {
		$ref_post = get_post( (int) $atts['ref'] );
		if ( $ref_post && $ref_post->post_type === 'note' ) {
			$content = apply_filters( 'the_content', $ref_post->post_content );
			$kind    = sebkijk_field( 'note_kind', $ref_post->ID ) ?: $kind;
		}
	} else {
		$content = wpautop( do_shortcode( $content ) );
	}

	$id    = $atts['id'] ? ' id="' . esc_attr( sanitize_html_class( $atts['id'] ) ) . '"' : '';
	$class = 'note note--' . sanitize_html_class( $kind );

	// All kinds share the same DOM so JS can move them in/out on viewport size.
	return sprintf(
		'<aside class="%s"%s data-kind="%s"><div class="note__inner">%s</div></aside>',
		esc_attr( $class ),
		$id,
		esc_attr( $kind ),
		$content
	);
} );

/**
 * Helper: render the notes that are attached to a given post.
 *
 * Surfaces them as a "Notes" sidebar at the bottom of the article, so even
 * authors who never used the shortcode still see linked notes.
 */
function sebkijk_render_attached_notes( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();

	$notes = get_posts( array(
		'post_type'      => 'note',
		'posts_per_page' => 20,
		'meta_query'     => array(
			array(
				'key'     => 'note_attaches_to',
				'value'   => '"' . $post_id . '"',
				'compare' => 'LIKE',
			),
		),
	) );

	if ( ! $notes ) {
		return;
	}
	?>
	<section class="notes-stream" aria-labelledby="notes-stream-h">
		<h2 id="notes-stream-h" class="notes-stream__heading"><?php esc_html_e( 'Notes', 'sebkijk-atelier' ); ?></h2>
		<ol class="notes-stream__list">
			<?php foreach ( $notes as $note ) :
				$anchor = sebkijk_field( 'note_anchor', $note->ID ); ?>
				<li class="notes-stream__item" <?php if ( $anchor ) echo 'id="' . esc_attr( $anchor ) . '"'; ?>>
					<?php if ( get_the_title( $note ) ) : ?>
						<h3 class="notes-stream__title"><?php echo esc_html( get_the_title( $note ) ); ?></h3>
					<?php endif; ?>
					<div class="notes-stream__body"><?php echo apply_filters( 'the_content', $note->post_content ); ?></div>
					<p class="notes-stream__meta">
						<a href="<?php echo esc_url( get_permalink( $note ) ); ?>"><?php esc_html_e( 'Open note', 'sebkijk-atelier' ); ?> →</a>
					</p>
				</li>
			<?php endforeach; ?>
		</ol>
	</section>
	<?php
}
