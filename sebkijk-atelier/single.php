<?php
/**
 * Default single template (used by core posts).
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<article <?php post_class( 'page-shell prose' ); ?>>
	<?php while ( have_posts() ) : the_post(); ?>
		<header class="entry-head">
			<p class="eyebrow"><?php esc_html_e( 'Notebook', 'sebkijk-atelier' ); ?></p>
			<h1 class="entry-head__title"><?php the_title(); ?></h1>
			<?php sebkijk_dateline(); ?>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="entry-figure">
				<?php the_post_thumbnail( 'sebkijk-still' ); ?>
			</figure>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>

		<?php sebkijk_render_attached_notes(); ?>

		<footer class="entry-foot">
			<?php the_tags( '<p class="entry-tags">', ', ', '</p>' ); ?>
		</footer>

		<?php if ( comments_open() || get_comments_number() ) {
			comments_template();
		} ?>
	<?php endwhile; ?>
</article>

<?php get_footer(); ?>
