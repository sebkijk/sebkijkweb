<?php
/**
 * Fallback index template.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="page-shell">
	<header class="page-shell__head">
		<p class="eyebrow"><?php esc_html_e( 'Recent', 'sebkijk-atelier' ); ?></p>
		<h1 class="page-shell__title"><?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} else {
				esc_html_e( 'Recent', 'sebkijk-atelier' );
			}
		?></h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<ol class="card-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="card-list__item">
					<?php get_template_part( 'template-parts/card', get_post_type() ); ?>
				</li>
			<?php endwhile; ?>
		</ol>

		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Niets gevonden.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
