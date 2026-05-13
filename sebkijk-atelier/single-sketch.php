<?php
/**
 * Single sketch – mostly image-led page.
 *
 * @package SebKijk_Atelier
 */

get_header();

while ( have_posts() ) : the_post();
	$caption = sebkijk_field( 'sketch_caption' );
	$medium  = sebkijk_field( 'sketch_medium' );
	$date    = sebkijk_field( 'sketch_date' );
?>
<article <?php post_class( 'sketch' ); ?>>
	<header class="sketch__head">
		<p class="eyebrow"><?php esc_html_e( 'Sketchbook', 'sebkijk-atelier' ); ?></p>
		<h1 class="sketch__title"><?php the_title(); ?></h1>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="sketch__figure">
			<?php the_post_thumbnail( 'sebkijk-scan' ); ?>
			<?php if ( $caption ) : ?>
				<figcaption><?php echo esc_html( $caption ); ?></figcaption>
			<?php endif; ?>
		</figure>
	<?php endif; ?>

	<div class="sketch__body prose">
		<?php the_content(); ?>
	</div>

	<dl class="sketch__meta">
		<?php if ( $medium ) : ?>
			<dt><?php esc_html_e( 'Medium', 'sebkijk-atelier' ); ?></dt>
			<dd><?php echo esc_html( $medium ); ?></dd>
		<?php endif; ?>
		<?php if ( $date ) : ?>
			<dt><?php esc_html_e( 'Date', 'sebkijk-atelier' ); ?></dt>
			<dd><?php echo esc_html( wp_date( 'j F Y', strtotime( $date ) ) ); ?></dd>
		<?php endif; ?>
	</dl>
</article>
<?php endwhile;

get_footer();
