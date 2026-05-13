<?php
/**
 * Default card used for any post type that has no specific template.
 *
 * @package SebKijk_Atelier
 */
?>
<article class="card">
	<a class="card__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="card__figure"><?php the_post_thumbnail( 'sebkijk-still' ); ?></figure>
		<?php endif; ?>
		<p class="card__kind"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></p>
		<h2 class="card__title"><?php the_title(); ?></h2>
		<p class="card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<p class="card__date"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></p>
	</a>
</article>
