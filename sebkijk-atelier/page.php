<?php
/**
 * Generic page template.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<article class="page-shell prose">
	<?php while ( have_posts() ) : the_post(); ?>
		<header class="page-shell__head">
			<h1 class="page-shell__title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</article>

<?php get_footer(); ?>
