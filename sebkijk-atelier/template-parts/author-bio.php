<?php
/**
 * Author bio appended to essays.
 *
 * @package SebKijk_Atelier
 */
$author_id   = get_post_field( 'post_author', get_the_ID() );
$author_name = get_the_author_meta( 'display_name', $author_id );
$author_bio  = get_the_author_meta( 'description', $author_id );

if ( ! $author_bio ) {
	return;
}
?>
<aside class="author-bio">
	<div class="author-bio__avatar">
		<?php echo get_avatar( $author_id, 96, '', $author_name ); ?>
	</div>
	<div class="author-bio__body">
		<p class="author-bio__name"><?php echo esc_html( $author_name ); ?></p>
		<p class="author-bio__desc"><?php echo esc_html( $author_bio ); ?></p>
		<p><a class="author-bio__more" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php esc_html_e( 'More by this author', 'sebkijk-atelier' ); ?> →</a></p>
	</div>
</aside>
