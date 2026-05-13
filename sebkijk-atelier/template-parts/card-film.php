<?php
/**
 * Card – film.
 *
 * @package SebKijk_Atelier
 */
$y = sebkijk_field( 'film_year' );
$d = get_the_term_list( get_the_ID(), 'director', '', ', ', '' );
?>
<article class="card card--film">
	<a class="card__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="card__figure"><?php the_post_thumbnail( 'sebkijk-portrait' ); ?></figure>
		<?php endif; ?>
		<p class="card__kind"><?php esc_html_e( 'Film', 'sebkijk-atelier' ); ?></p>
		<h2 class="card__title"><?php the_title(); ?></h2>
		<p class="card__meta">
			<?php if ( $d ) echo $d; ?>
			<?php if ( $d && $y ) echo ' <span aria-hidden="true">·</span> '; ?>
			<?php if ( $y ) echo esc_html( $y ); ?>
		</p>
	</a>
</article>
