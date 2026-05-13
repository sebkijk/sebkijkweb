<?php
/**
 * Notes archive – an unbroken column of marginalia.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="notelist">
	<header class="notelist__head">
		<p class="eyebrow"><?php esc_html_e( 'Notes', 'sebkijk-atelier' ); ?></p>
		<h1 class="notelist__title"><?php post_type_archive_title(); ?></h1>
		<p class="notelist__intro"><?php esc_html_e( 'Korte aantekeningen, in de marge van het kijken.', 'sebkijk-atelier' ); ?></p>
	</header>

	<?php if ( have_posts() ) : ?>
		<ol class="notelist__stream">
			<?php while ( have_posts() ) : the_post();
				$attached = sebkijk_field( 'note_attaches_to' );
				$kind     = sebkijk_field( 'note_kind' );
			?>
				<li class="notelist__item">
					<p class="notelist__meta">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time>
						<?php if ( $kind ) : ?>
							<span aria-hidden="true">·</span>
							<span><?php echo esc_html( $kind ); ?></span>
						<?php endif; ?>
					</p>
					<?php if ( get_the_title() ) : ?>
						<h2 class="notelist__h"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>
					<div class="notelist__body prose"><?php the_content(); ?></div>
					<?php if ( $attached ) :
						$ids = is_array( $attached ) ? $attached : array( $attached );
						$first = is_object( $ids[0] ) ? $ids[0]->ID : (int) $ids[0];
						if ( $first ) : ?>
							<p class="notelist__attached">
								<?php esc_html_e( 'In de marge van', 'sebkijk-atelier' ); ?>
								<a href="<?php echo esc_url( get_permalink( $first ) ); ?>"><?php echo esc_html( get_the_title( $first ) ); ?></a>
							</p>
						<?php endif;
					endif; ?>
				</li>
			<?php endwhile; ?>
		</ol>
		<?php sebkijk_pagination(); ?>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'Geen notities gevonden.', 'sebkijk-atelier' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
