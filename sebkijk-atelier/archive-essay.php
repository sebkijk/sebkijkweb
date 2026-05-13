<?php
/**
 * Essay archive.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="essaylist">
	<header class="essaylist__head">
		<p class="eyebrow"><?php esc_html_e( 'Essays', 'sebkijk-atelier' ); ?></p>
		<h1 class="essaylist__title"><?php post_type_archive_title(); ?></h1>
		<p class="essaylist__intro"><?php esc_html_e( 'Lange stukken — over films, kijken, lezen, herinneren.', 'sebkijk-atelier' ); ?></p>
	</header>

	<?php if ( have_posts() ) : ?>
		<ol class="essaylist__list">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="essaycard">
					<article>
						<a class="essaycard__link" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<figure class="essaycard__figure"><?php the_post_thumbnail( 'sebkijk-still' ); ?></figure>
							<?php endif; ?>
							<div class="essaycard__body">
								<p class="essaycard__date"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></p>
								<h2 class="essaycard__title"><?php the_title(); ?></h2>
								<?php $sub = sebkijk_field( 'essay_subtitle' ); if ( $sub ) : ?>
									<p class="essaycard__sub"><?php echo esc_html( $sub ); ?></p>
								<?php endif; ?>
								<p class="essaycard__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
							</div>
						</a>
					</article>
				</li>
			<?php endwhile; ?>
		</ol>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Nog geen essays.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
