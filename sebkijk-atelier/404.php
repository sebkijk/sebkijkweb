<?php
/**
 * 404 template.
 *
 * @package SebKijk_Atelier
 */

get_header(); ?>

<section class="page-shell page-shell--center">
	<p class="eyebrow"><?php esc_html_e( 'Niet gevonden', 'sebkijk-atelier' ); ?></p>
	<h1 class="page-shell__title"><?php esc_html_e( 'Een ontbrekende pagina', 'sebkijk-atelier' ); ?></h1>
	<p class="page-shell__lede"><?php esc_html_e( 'Misschien een verwijderde schets, een verschoven fragment. Probeer een zoekopdracht.', 'sebkijk-atelier' ); ?></p>
	<?php get_search_form(); ?>
</section>

<?php get_footer(); ?>
