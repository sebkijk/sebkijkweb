<?php
/**
 * Sketchbook archive – a masonry-ish grid of scans and drawings.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="sketchbook">
	<header class="sketchbook__head">
		<p class="eyebrow"><?php esc_html_e( 'Sketchbook', 'sebkijk-atelier' ); ?></p>
		<h1 class="sketchbook__title"><?php post_type_archive_title(); ?></h1>
		<p class="sketchbook__intro"><?php esc_html_e( 'Tekeningen, scans, visuele notities.', 'sebkijk-atelier' ); ?></p>
	</header>

	<?php if ( have_posts() ) : ?>
		<ul class="sketchbook__grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="sketchbook__item">
					<a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<figure><?php the_post_thumbnail( 'sebkijk-scan' ); ?></figure>
						<?php endif; ?>
						<span class="sketchbook__caption">
							<span class="sketchbook__caption-title"><?php the_title(); ?></span>
							<?php $d = sebkijk_field( 'sketch_date' ); if ( $d ) : ?>
								<span class="sketchbook__caption-date"><?php echo esc_html( wp_date( 'j M Y', strtotime( $d ) ) ); ?></span>
							<?php endif; ?>
						</span>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Het schetsboek is nog leeg.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
