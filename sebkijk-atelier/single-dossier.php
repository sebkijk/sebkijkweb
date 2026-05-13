<?php
/**
 * Single dossier – a curated collection of films, essays, notes and sketches.
 *
 * @package SebKijk_Atelier
 */

get_header();

while ( have_posts() ) : the_post();
	$intro = sebkijk_field( 'dossier_intro' );
	$items = sebkijk_field( 'dossier_items' );
?>
<article <?php post_class( 'dossier' ); ?>>
	<header class="dossier__head">
		<p class="eyebrow"><?php esc_html_e( 'Dossier', 'sebkijk-atelier' ); ?></p>
		<h1 class="dossier__title"><?php the_title(); ?></h1>
		<?php sebkijk_dateline(); ?>
	</header>

	<?php if ( $intro ) : ?>
		<section class="dossier__intro prose"><?php echo apply_filters( 'the_content', $intro ); ?></section>
	<?php endif; ?>

	<div class="dossier__body prose">
		<?php the_content(); ?>
	</div>

	<?php if ( $items ) : ?>
		<section class="dossier__items">
			<?php sebkijk_divider(); ?>
			<h2 class="dossier__items-h"><?php esc_html_e( 'In this dossier', 'sebkijk-atelier' ); ?></h2>
			<ol class="dossier__items-list">
				<?php foreach ( $items as $it ) :
					$iid = is_object( $it ) ? $it->ID : (int) $it;
					if ( ! $iid ) continue; ?>
					<li class="dossier__item">
						<a href="<?php echo esc_url( get_permalink( $iid ) ); ?>">
							<span class="dossier__item-kind"><?php echo esc_html( get_post_type_object( get_post_type( $iid ) )->labels->singular_name ); ?></span>
							<span class="dossier__item-title"><?php echo esc_html( get_the_title( $iid ) ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ol>
		</section>
	<?php endif; ?>
</article>
<?php endwhile;

get_footer();
