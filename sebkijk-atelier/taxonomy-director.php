<?php
/**
 * Director landing page – portrait of a film-maker.
 *
 * Inspired by Roger Ebert's Great Movies director pages: a short bio
 * (from term description), a chronological filmography pulled from the
 * Films CPT, and any essays tagged with this director.
 *
 * @package SebKijk_Atelier
 */

get_header();

$term = get_queried_object();

$films = new WP_Query( array(
	'post_type'      => 'film',
	'posts_per_page' => -1,
	'tax_query'      => array( array(
		'taxonomy' => 'director',
		'field'    => 'term_id',
		'terms'    => $term->term_id,
	) ),
	'meta_key' => 'film_year',
	'orderby'  => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
) );

$essays = get_posts( array(
	'post_type'      => 'essay',
	'posts_per_page' => 10,
	'tax_query'      => array( array(
		'taxonomy' => 'director',
		'field'    => 'term_id',
		'terms'    => $term->term_id,
	) ),
) );
?>

<section class="director">
	<header class="director__head">
		<p class="eyebrow"><?php esc_html_e( 'Director', 'sebkijk-atelier' ); ?></p>
		<h1 class="director__title"><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( $term->description ) : ?>
			<div class="director__bio prose"><?php echo wp_kses_post( wpautop( $term->description ) ); ?></div>
		<?php endif; ?>
		<p class="director__counts">
			<?php
			printf(
				esc_html__( '%1$d films · %2$d essays in the atelier.', 'sebkijk-atelier' ),
				(int) $films->found_posts,
				count( $essays )
			);
			?>
		</p>
	</header>

	<?php sebkijk_divider(); ?>

	<?php if ( $films->have_posts() ) : ?>
		<section class="director__films" aria-labelledby="director-films-h">
			<h2 id="director-films-h" class="director__section-h"><?php esc_html_e( 'Filmography', 'sebkijk-atelier' ); ?></h2>
			<ol class="director__filmography">
				<?php while ( $films->have_posts() ) : $films->the_post();
					$y = sebkijk_field( 'film_year' );
					$orig = sebkijk_field( 'film_original_title' ); ?>
					<li class="director__film">
						<a href="<?php the_permalink(); ?>">
							<span class="director__film-year"><?php echo $y ? esc_html( $y ) : '—'; ?></span>
							<span class="director__film-title">
								<?php the_title(); ?>
								<?php if ( $orig ) : ?>
									<em class="director__film-orig"><?php echo esc_html( $orig ); ?></em>
								<?php endif; ?>
							</span>
						</a>
					</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ol>
		</section>
	<?php endif; ?>

	<?php if ( $essays ) : ?>
		<section class="director__essays" aria-labelledby="director-essays-h">
			<?php sebkijk_divider(); ?>
			<h2 id="director-essays-h" class="director__section-h"><?php esc_html_e( 'Essays', 'sebkijk-atelier' ); ?></h2>
			<ul class="director__essays-list">
				<?php foreach ( $essays as $e ) : ?>
					<li>
						<a href="<?php echo esc_url( get_permalink( $e ) ); ?>">
							<span class="director__essay-title"><?php echo esc_html( get_the_title( $e ) ); ?></span>
							<span class="director__essay-date"><?php echo esc_html( get_the_date( 'Y', $e ) ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
