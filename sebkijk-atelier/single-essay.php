<?php
/**
 * Single essay – long-form editorial layout with margin notes.
 *
 * @package SebKijk_Atelier
 */

get_header();

while ( have_posts() ) : the_post();
	$sub = sebkijk_field( 'essay_subtitle' );
	$dek = sebkijk_field( 'essay_dek' );
	$rt  = sebkijk_field( 'essay_reading_time' );
?>
<article <?php post_class( 'essay' ); ?>>

	<header class="essay__head">
		<p class="eyebrow"><?php esc_html_e( 'Essay', 'sebkijk-atelier' ); ?></p>
		<h1 class="essay__title"><?php the_title(); ?></h1>
		<?php if ( $sub ) : ?>
			<p class="essay__subtitle"><?php echo esc_html( $sub ); ?></p>
		<?php endif; ?>
		<?php if ( $dek ) : ?>
			<p class="essay__dek"><?php echo esc_html( $dek ); ?></p>
		<?php endif; ?>
		<p class="essay__byline">
			<span><?php the_author(); ?></span>
			<span aria-hidden="true">·</span>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
			<?php if ( $rt ) : ?>
				<span aria-hidden="true">·</span>
				<span><?php echo (int) $rt; ?> <?php esc_html_e( 'min lezen', 'sebkijk-atelier' ); ?></span>
			<?php endif; ?>
		</p>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="essay__figure">
			<?php the_post_thumbnail( 'sebkijk-still' ); ?>
			<?php $cap = get_the_post_thumbnail_caption();
			if ( $cap ) : ?>
				<figcaption><?php echo esc_html( $cap ); ?></figcaption>
			<?php endif; ?>
		</figure>
	<?php endif; ?>

	<div class="essay__body prose with-margin-notes">
		<?php the_content(); ?>
	</div>

	<?php sebkijk_render_attached_notes(); ?>

	<?php get_template_part( 'template-parts/author-bio' ); ?>

	<?php sebkijk_related_list( 'essay_related_films', null, __( 'Films mentioned', 'sebkijk-atelier' ) ); ?>

	<footer class="essay__foot">
		<?php sebkijk_divider(); ?>
		<?php the_terms( get_the_ID(), 'theme_tag', '<p class="entry-tags">', ' · ', '</p>' ); ?>
	</footer>

	<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
</article>
<?php endwhile;

get_footer();
