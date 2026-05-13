<?php
/**
 * Single note – short, intimate, with a visible link back to its anchor post.
 *
 * @package SebKijk_Atelier
 */

get_header();

while ( have_posts() ) : the_post();
	$attached = sebkijk_field( 'note_attaches_to' );
	$kind     = sebkijk_field( 'note_kind' );
?>
<article <?php post_class( 'note-page' ); ?>>
	<header class="note-page__head">
		<p class="eyebrow">
			<?php esc_html_e( 'Note', 'sebkijk-atelier' ); ?>
			<?php if ( $kind ) : ?>
				<span class="eyebrow__sep" aria-hidden="true">·</span>
				<span><?php echo esc_html( ucfirst( $kind ) ); ?></span>
			<?php endif; ?>
		</p>
		<h1 class="note-page__title"><?php the_title(); ?></h1>
		<?php sebkijk_dateline(); ?>
	</header>

	<div class="note-page__body prose">
		<?php the_content(); ?>
	</div>

	<?php if ( $attached ) :
		$ids = is_array( $attached ) ? $attached : array( $attached );
		$first = is_object( $ids[0] ) ? $ids[0]->ID : (int) $ids[0];
		if ( $first ) : ?>
			<aside class="note-page__attached">
				<?php sebkijk_divider(); ?>
				<p class="eyebrow"><?php esc_html_e( 'In the margin of', 'sebkijk-atelier' ); ?></p>
				<p class="note-page__attached-link">
					<a href="<?php echo esc_url( get_permalink( $first ) ); ?>"><?php echo esc_html( get_the_title( $first ) ); ?></a>
				</p>
			</aside>
		<?php endif; ?>
	<?php endif; ?>
</article>
<?php endwhile;

get_footer();
