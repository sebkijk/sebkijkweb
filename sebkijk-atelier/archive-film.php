<?php
/**
 * Film index – searchable archive inspired by Sabzian / Great Movies.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="filmindex">
	<header class="filmindex__head">
		<p class="eyebrow"><?php esc_html_e( 'Film index', 'sebkijk-atelier' ); ?></p>
		<h1 class="filmindex__title"><?php post_type_archive_title(); ?></h1>
		<p class="filmindex__intro"><?php esc_html_e( 'Een groeiend dossier van films — recensies, notities, terugzieningen.', 'sebkijk-atelier' ); ?></p>
		<?php sebkijk_filmindex_search(); ?>
	</header>

	<?php
	// Browse-by toolbar (directors / decades / countries).
	$directors = get_terms( array( 'taxonomy' => 'director', 'hide_empty' => true, 'number' => 30 ) );
	$decades   = get_terms( array( 'taxonomy' => 'decade',   'hide_empty' => true ) );
	$countries = get_terms( array( 'taxonomy' => 'country',  'hide_empty' => true, 'number' => 30 ) );
	if ( ! is_wp_error( $directors ) && ( $directors || $decades || $countries ) ) : ?>
		<nav class="filmindex__browse" aria-label="<?php esc_attr_e( 'Browse', 'sebkijk-atelier' ); ?>">
			<?php if ( $decades ) : ?>
				<details class="filmindex__facet" open>
					<summary><?php esc_html_e( 'Decades', 'sebkijk-atelier' ); ?></summary>
					<ul>
						<?php foreach ( $decades as $t ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?> <span class="muted">(<?php echo (int) $t->count; ?>)</span></a></li>
						<?php endforeach; ?>
					</ul>
				</details>
			<?php endif; ?>
			<?php if ( $directors ) : ?>
				<details class="filmindex__facet">
					<summary><?php esc_html_e( 'Directors', 'sebkijk-atelier' ); ?></summary>
					<ul>
						<?php foreach ( $directors as $t ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</details>
			<?php endif; ?>
			<?php if ( $countries ) : ?>
				<details class="filmindex__facet">
					<summary><?php esc_html_e( 'Countries', 'sebkijk-atelier' ); ?></summary>
					<ul>
						<?php foreach ( $countries as $t ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</details>
			<?php endif; ?>
		</nav>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<ol class="filmindex__grid">
			<?php while ( have_posts() ) : the_post();
				$y = sebkijk_field( 'film_year' );
				$d = get_the_term_list( get_the_ID(), 'director', '', ', ', '' );
			?>
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
		<p class="empty"><?php esc_html_e( 'De index is nog leeg.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
