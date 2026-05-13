<?php
/**
 * Search results.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="page-shell">
	<header class="page-shell__head">
		<p class="eyebrow"><?php esc_html_e( 'Search', 'sebkijk-atelier' ); ?></p>
		<h1 class="page-shell__title">
			<?php printf( esc_html__( 'Results for “%s”', 'sebkijk-atelier' ), '<em>' . esc_html( get_search_query() ) . '</em>' ); ?>
		</h1>
		<?php get_search_form(); ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<ol class="searchlist">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="searchlist__item">
					<a href="<?php the_permalink(); ?>">
						<span class="searchlist__kind"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
						<span class="searchlist__title"><?php the_title(); ?></span>
						<span class="searchlist__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></span>
					</a>
				</li>
			<?php endwhile; ?>
		</ol>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Geen resultaten gevonden.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
