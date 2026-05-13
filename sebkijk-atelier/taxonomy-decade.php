<?php
/**
 * Decade landing – Sabzian-style grid of films from a decade.
 *
 * @package SebKijk_Atelier
 */

get_header();
$term = get_queried_object();
?>

<section class="filmindex filmindex--decade">
	<header class="filmindex__head">
		<p class="eyebrow"><?php esc_html_e( 'Decade', 'sebkijk-atelier' ); ?></p>
		<h1 class="filmindex__title"><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( $term->description ) : ?>
			<div class="filmindex__intro prose"><?php echo wp_kses_post( wpautop( $term->description ) ); ?></div>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<ol class="filmindex__grid">
			<?php while ( have_posts() ) : the_post();
				$y = sebkijk_field( 'film_year' );
				$d = get_the_term_list( get_the_ID(), 'director', '', ', ', '' ); ?>
				<li class="filmcard">
					<a class="filmcard__link" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<span class="filmcard__poster"><?php the_post_thumbnail( 'sebkijk-portrait' ); ?></span>
						<?php else : ?>
							<span class="filmcard__poster filmcard__poster--blank" aria-hidden="true"></span>
						<?php endif; ?>
						<span class="filmcard__title"><?php the_title(); ?></span>
						<span class="filmcard__meta">
							<?php if ( $d ) echo $d; ?>
							<?php if ( $d && $y ) echo ' <span aria-hidden="true">·</span> '; ?>
							<?php if ( $y ) echo esc_html( $y ); ?>
						</span>
					</a>
				</li>
			<?php endwhile; ?>
		</ol>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Geen films in dit decennium — nog niet.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
