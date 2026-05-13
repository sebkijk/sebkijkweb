<?php
/**
 * Single film – scrapbook dossier layout.
 *
 * @package SebKijk_Atelier
 */

get_header();

while ( have_posts() ) : the_post();
	$pid   = get_the_ID();
	$rev   = sebkijk_field( 'film_review', $pid );
	$quotes= sebkijk_field( 'film_quotes', $pid );
	$dirref= sebkijk_field( 'film_director_refs', $pid );
	$scans = sebkijk_field( 'film_scans', $pid );
	$revs  = sebkijk_field( 'film_revisits', $pid );
?>
<article <?php post_class( 'film' ); ?>>

	<?php sebkijk_film_header( $pid ); ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="film__poster">
			<?php the_post_thumbnail( 'sebkijk-portrait' ); ?>
		</figure>
	<?php endif; ?>

	<div class="film__layout">

		<?php sebkijk_film_credits( $pid ); ?>

		<div class="film__body prose">

			<?php if ( has_excerpt() ) : ?>
				<p class="film__dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<?php if ( $rev ) : ?>
				<section class="film__review" aria-labelledby="film-review-h">
					<h2 id="film-review-h"><?php esc_html_e( 'Review', 'sebkijk-atelier' ); ?></h2>
					<?php echo apply_filters( 'the_content', $rev ); ?>
				</section>
			<?php endif; ?>

			<?php if ( get_the_content() ) : ?>
				<section class="film__notes" aria-labelledby="film-notes-h">
					<h2 id="film-notes-h"><?php esc_html_e( 'Notes & marginalia', 'sebkijk-atelier' ); ?></h2>
					<?php the_content(); ?>
				</section>
			<?php endif; ?>

			<?php if ( $quotes ) : ?>
				<section class="film__quotes" aria-labelledby="film-quotes-h">
					<h2 id="film-quotes-h"><?php esc_html_e( 'Quotes', 'sebkijk-atelier' ); ?></h2>
					<ul class="film__quotes-list">
						<?php foreach ( $quotes as $q ) : ?>
							<li class="film__quote">
								<blockquote><p><?php echo esc_html( $q['quote'] ?? '' ); ?></p></blockquote>
								<?php if ( ! empty( $q['source'] ) ) : ?>
									<cite>— <?php echo esc_html( $q['source'] ); ?></cite>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<?php if ( $dirref ) : ?>
				<section class="film__refs" aria-labelledby="film-refs-h">
					<h2 id="film-refs-h"><?php esc_html_e( 'Director references', 'sebkijk-atelier' ); ?></h2>
					<div class="film__refs-body"><?php echo wpautop( esc_html( $dirref ) ); ?></div>
				</section>
			<?php endif; ?>

			<?php if ( $scans ) : ?>
				<section class="film__scans" aria-labelledby="film-scans-h">
					<h2 id="film-scans-h"><?php esc_html_e( 'Scans & visual annotations', 'sebkijk-atelier' ); ?></h2>
					<div class="scrapbook">
						<?php foreach ( $scans as $img ) :
							$url = is_array( $img ) ? ( $img['sizes']['sebkijk-scan'] ?? $img['url'] ) : wp_get_attachment_image_url( $img, 'sebkijk-scan' );
							$alt = is_array( $img ) ? ( $img['alt'] ?? '' ) : get_post_meta( $img, '_wp_attachment_image_alt', true );
							$cap = is_array( $img ) ? ( $img['caption'] ?? '' ) : wp_get_attachment_caption( $img );
							?>
							<figure class="scrapbook__item">
								<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" />
								<?php if ( $cap ) : ?>
									<figcaption><?php echo esc_html( $cap ); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( $revs ) : ?>
				<section class="film__revisits" aria-labelledby="film-revisits-h">
					<h2 id="film-revisits-h"><?php esc_html_e( 'Revisits', 'sebkijk-atelier' ); ?></h2>
					<ol class="film__revisits-list">
						<?php foreach ( $revs as $r ) : ?>
							<li>
								<time><?php echo esc_html( ! empty( $r['date'] ) ? wp_date( 'j F Y', strtotime( $r['date'] ) ) : '' ); ?></time>
								<p><?php echo esc_html( $r['note'] ?? '' ); ?></p>
							</li>
						<?php endforeach; ?>
					</ol>
				</section>
			<?php endif; ?>

			<?php sebkijk_render_attached_notes( $pid ); ?>

			<?php sebkijk_related_list( 'film_related_essays', $pid, __( 'Related essays', 'sebkijk-atelier' ) ); ?>
			<?php sebkijk_related_list( 'film_related_films',  $pid, __( 'Related films', 'sebkijk-atelier' ) ); ?>

		</div><!-- /.film__body -->
	</div><!-- /.film__layout -->

	<footer class="film__foot">
		<?php sebkijk_divider(); ?>
		<p class="film__navlinks">
			<?php previous_post_link( '%link', '← %title', true, '', 'director' ); ?>
			<?php next_post_link( '%link', '%title →', true, '', 'director' ); ?>
		</p>
	</footer>
</article>
<?php endwhile;

get_footer();
