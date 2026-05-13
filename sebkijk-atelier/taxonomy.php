<?php
/**
 * Generic taxonomy archive (themes, countries, dossier topics).
 *
 * @package SebKijk_Atelier
 */

get_header();
$term = get_queried_object();
$tax  = get_taxonomy( $term->taxonomy );
?>

<section class="page-shell">
	<header class="page-shell__head">
		<p class="eyebrow"><?php echo esc_html( $tax->labels->singular_name ); ?></p>
		<h1 class="page-shell__title"><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( $term->description ) : ?>
			<div class="page-shell__lede"><?php echo wp_kses_post( wpautop( $term->description ) ); ?></div>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<ol class="card-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="card-list__item">
					<?php
					$tpl = 'template-parts/card-' . get_post_type();
					if ( locate_template( $tpl . '.php' ) ) {
						get_template_part( $tpl );
					} else {
						get_template_part( 'template-parts/card' );
					}
					?>
				</li>
			<?php endwhile; ?>
		</ol>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Niets gevonden in dit thema.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
