<?php
/**
 * Minimal comments template – kept simple, in keeping with the editorial tone.
 *
 * @package SebKijk_Atelier
 */

if ( post_password_required() ) {
	return;
}
?>

<section class="comments" aria-labelledby="comments-h">
	<h2 id="comments-h" class="comments__heading"><?php
		$count = get_comments_number();
		if ( $count === '0' || $count === 0 ) {
			esc_html_e( 'Notitieboek', 'sebkijk-atelier' );
		} else {
			printf( esc_html( _n( '%s reactie', '%s reacties', $count, 'sebkijk-atelier' ) ), number_format_i18n( $count ) );
		}
	?></h2>

	<?php if ( have_comments() ) : ?>
		<ol class="comments__list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 36 ) ); ?>
		</ol>
		<?php the_comments_pagination( array(
			'prev_text' => __( '←', 'sebkijk-atelier' ),
			'next_text' => __( '→', 'sebkijk-atelier' ),
		) ); ?>
	<?php endif; ?>

	<?php comment_form( array(
		'title_reply' => __( 'Een aantekening achterlaten', 'sebkijk-atelier' ),
		'label_submit'=> __( 'Versturen', 'sebkijk-atelier' ),
		'class_form'  => 'comments__form',
	) ); ?>
</section>
