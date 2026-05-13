<?php
/**
 * Curated homepage – not a generic blog feed.
 *
 * Pulls picks from ACF if set, otherwise falls back to the most recent
 * essay / film / sketch / notes.
 *
 * @package SebKijk_Atelier
 */

get_header();

$featured_essay_id = sebkijk_field( 'home_featured_essay', get_option( 'page_on_front' ) );
$highlight_film_id = sebkijk_field( 'home_highlighted_film', get_option( 'page_on_front' ) );
$sketches          = sebkijk_field( 'home_sketches', get_option( 'page_on_front' ) );
$fragments_intro   = sebkijk_field( 'home_fragments_intro', get_option( 'page_on_front' ) );

if ( ! $featured_essay_id ) {
	$q = get_posts( array( 'post_type' => 'essay', 'posts_per_page' => 1 ) );
	$featured_essay_id = $q ? $q[0]->ID : 0;
}
if ( ! $highlight_film_id ) {
	$q = get_posts( array( 'post_type' => 'film', 'posts_per_page' => 1 ) );
	$highlight_film_id = $q ? $q[0]->ID : 0;
}
if ( ! $sketches ) {
	$sketches = get_posts( array( 'post_type' => 'sketch', 'posts_per_page' => 5, 'fields' => 'ids' ) );
}
?>

<div class="home">

	<section class="home__masthead" aria-label="<?php esc_attr_e( 'Atelier opening', 'sebkijk-atelier' ); ?>">
		<p class="home__date"><?php echo esc_html( wp_date( 'l, j F Y' ) ); ?></p>
		<h1 class="home__name"><?php bloginfo( 'name' ); ?></h1>
		<p class="home__tag"><?php bloginfo( 'description' ); ?></p>
		<hr class="rule rule--thin" />
	</section>

	<div class="home__grid">

		<?php /* ---------- Featured essay ---------- */ ?>
		<?php if ( $featured_essay_id ) :
			$essay = get_post( $featured_essay_id ); setup_postdata( $essay ); ?>
			<section class="home__featured" aria-labelledby="home-featured-h">
				<p class="eyebrow"><?php esc_html_e( 'Featured essay', 'sebkijk-atelier' ); ?></p>
				<h2 id="home-featured-h" class="home__featured-title">
					<a href="<?php echo esc_url( get_permalink( $essay ) ); ?>"><?php echo esc_html( get_the_title( $essay ) ); ?></a>
				</h2>
				<?php $sub = sebkijk_field( 'essay_subtitle', $essay->ID ); ?>
				<?php if ( $sub ) : ?>
					<p class="home__featured-sub"><?php echo esc_html( $sub ); ?></p>
				<?php endif; ?>
				<?php $dek = sebkijk_field( 'essay_dek', $essay->ID ); ?>
				<?php if ( $dek ) : ?>
					<p class="home__featured-dek"><?php echo esc_html( $dek ); ?></p>
				<?php else : ?>
					<p class="home__featured-dek"><?php echo esc_html( get_the_excerpt( $essay ) ); ?></p>
				<?php endif; ?>
				<p class="home__featured-byline">
					<span><?php echo esc_html( get_the_author_meta( 'display_name', $essay->post_author ) ); ?></span>
					<span aria-hidden="true">·</span>
					<time datetime="<?php echo esc_attr( get_the_date( 'c', $essay ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y', $essay ) ); ?></time>
				</p>
				<p><a class="link-arrow" href="<?php echo esc_url( get_permalink( $essay ) ); ?>"><?php esc_html_e( 'Read the essay', 'sebkijk-atelier' ); ?> →</a></p>
			</section>
		<?php wp_reset_postdata(); endif; ?>

		<?php /* ---------- Highlighted film ---------- */ ?>
		<?php if ( $highlight_film_id ) :
			$film = get_post( $highlight_film_id ); ?>
			<section class="home__film" aria-labelledby="home-film-h">
				<p class="eyebrow"><?php esc_html_e( 'Highlighted film', 'sebkijk-atelier' ); ?></p>
				<?php if ( has_post_thumbnail( $film ) ) : ?>
					<a class="home__film-figure" href="<?php echo esc_url( get_permalink( $film ) ); ?>">
						<?php echo get_the_post_thumbnail( $film, 'sebkijk-portrait' ); ?>
					</a>
				<?php endif; ?>
				<h2 id="home-film-h" class="home__film-title">
					<a href="<?php echo esc_url( get_permalink( $film ) ); ?>"><?php echo esc_html( get_the_title( $film ) ); ?></a>
				</h2>
				<p class="home__film-meta">
					<?php
					$d = get_the_term_list( $film->ID, 'director', '', ', ', '' );
					$y = sebkijk_field( 'film_year', $film->ID );
					if ( $d ) echo $d;
					if ( $d && $y ) echo ' <span aria-hidden="true">·</span> ';
					if ( $y ) echo esc_html( $y );
					?>
				</p>
				<p class="home__film-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $film ), 28 ) ); ?></p>
			</section>
		<?php endif; ?>

		<?php /* ---------- Recent notes ---------- */ ?>
		<section class="home__notes" aria-labelledby="home-notes-h">
			<p class="eyebrow"><?php esc_html_e( 'Recent notes', 'sebkijk-atelier' ); ?></p>
			<h2 id="home-notes-h" class="screen-reader-text"><?php esc_html_e( 'Recent notes', 'sebkijk-atelier' ); ?></h2>
			<?php
			$notes = get_posts( array( 'post_type' => 'note', 'posts_per_page' => 6 ) );
			if ( $notes ) : ?>
				<ol class="home__notes-list">
					<?php foreach ( $notes as $n ) : ?>
						<li class="home__note">
							<a href="<?php echo esc_url( get_permalink( $n ) ); ?>">
								<span class="home__note-date"><?php echo esc_html( get_the_date( 'j M', $n ) ); ?></span>
								<span class="home__note-body"><?php echo esc_html( wp_trim_words( $n->post_title ?: $n->post_content, 18 ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php else : ?>
				<p class="empty"><?php esc_html_e( 'Nog geen notities.', 'sebkijk-atelier' ); ?></p>
			<?php endif; ?>
		</section>

		<?php /* ---------- Rotating sketch ---------- */ ?>
		<?php if ( $sketches ) :
			$picked = is_array( $sketches ) ? $sketches[ array_rand( $sketches ) ] : (int) $sketches;
			$sketch = get_post( $picked );
			if ( $sketch ) : ?>
				<section class="home__sketch" aria-labelledby="home-sketch-h">
					<p class="eyebrow"><?php esc_html_e( 'Sketchbook', 'sebkijk-atelier' ); ?></p>
					<?php if ( has_post_thumbnail( $sketch ) ) : ?>
						<a class="home__sketch-figure" href="<?php echo esc_url( get_permalink( $sketch ) ); ?>">
							<?php echo get_the_post_thumbnail( $sketch, 'sebkijk-scan' ); ?>
						</a>
					<?php endif; ?>
					<h2 id="home-sketch-h" class="home__sketch-title">
						<a href="<?php echo esc_url( get_permalink( $sketch ) ); ?>"><?php echo esc_html( get_the_title( $sketch ) ); ?></a>
					</h2>
					<?php $cap = sebkijk_field( 'sketch_caption', $sketch->ID ); ?>
					<?php if ( $cap ) : ?>
						<p class="home__sketch-caption"><?php echo esc_html( $cap ); ?></p>
					<?php endif; ?>
				</section>
			<?php endif; ?>
		<?php endif; ?>

		<?php /* ---------- Archive fragments ---------- */ ?>
		<section class="home__fragments" aria-labelledby="home-fragments-h">
			<p class="eyebrow"><?php esc_html_e( 'Archive fragments', 'sebkijk-atelier' ); ?></p>
			<h2 id="home-fragments-h" class="screen-reader-text"><?php esc_html_e( 'Archive fragments', 'sebkijk-atelier' ); ?></h2>
			<?php if ( $fragments_intro ) : ?>
				<p class="home__fragments-intro"><?php echo esc_html( $fragments_intro ); ?></p>
			<?php endif; ?>
			<?php
			$frag = get_posts( array(
				'post_type'      => array( 'film', 'essay', 'dossier' ),
				'posts_per_page' => 6,
				'orderby'        => 'rand',
			) );
			if ( $frag ) : ?>
				<ul class="home__fragments-list">
					<?php foreach ( $frag as $f ) : ?>
						<li class="home__fragment">
							<a href="<?php echo esc_url( get_permalink( $f ) ); ?>">
								<span class="home__fragment-kind"><?php echo esc_html( get_post_type_object( $f->post_type )->labels->singular_name ); ?></span>
								<span class="home__fragment-title"><?php echo esc_html( get_the_title( $f ) ); ?></span>
								<span class="home__fragment-date"><?php echo esc_html( get_the_date( 'Y', $f ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>

	</div><!-- /.home__grid -->
</div><!-- /.home -->

<?php get_footer(); ?>
