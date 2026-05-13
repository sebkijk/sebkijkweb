<?php
/**
 * Dossier archive.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="dossierlist">
	<header class="dossierlist__head">
		<p class="eyebrow"><?php esc_html_e( 'Dossiers', 'sebkijk-atelier' ); ?></p>
		<h1 class="dossierlist__title"><?php post_type_archive_title(); ?></h1>
		<p class="dossierlist__intro"><?php esc_html_e( 'Verzamelingen — een regisseur, een motief, een seizoen.', 'sebkijk-atelier' ); ?></p>
	</header>

	<?php if ( have_posts() ) : ?>
		<ul class="dossierlist__list">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="dossiercard">
					<a class="dossiercard__link" href="<?php the_permalink(); ?>">
						<h2 class="dossiercard__title"><?php the_title(); ?></h2>
						<p class="dossiercard__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php the_terms( get_the_ID(), 'dossier_topic', '<p class="dossiercard__topic">', ' · ', '</p>' ); ?>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Nog geen dossiers.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
