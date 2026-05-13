<?php
/**
 * The header.
 *
 * @package SebKijk_Atelier
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'sebkijk-atelier' ); ?></a>

<header class="site-head" role="banner">
	<div class="site-head__inner">
		<p class="site-head__mark">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span class="site-head__mark-name"><?php bloginfo( 'name' ); ?></span>
				<span class="site-head__mark-tag"><?php esc_html_e( 'Atelier · film · notebook', 'sebkijk-atelier' ); ?></span>
			</a>
		</p>

		<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'sebkijk-atelier' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
			} else {
				echo '<ul class="site-nav__list">';
				$pairs = array(
					'essay'   => __( 'Essays', 'sebkijk-atelier' ),
					'film'    => __( 'Films', 'sebkijk-atelier' ),
					'note'    => __( 'Notes', 'sebkijk-atelier' ),
					'dossier' => __( 'Dossiers', 'sebkijk-atelier' ),
					'sketch'  => __( 'Sketchbook', 'sebkijk-atelier' ),
				);
				foreach ( $pairs as $pt => $label ) {
					$link = get_post_type_archive_link( $pt );
					if ( $link ) {
						echo '<li><a href="' . esc_url( $link ) . '">' . esc_html( $label ) . '</a></li>';
					}
				}
				echo '</ul>';
			}
			?>
		</nav>

		<form role="search" class="site-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="site-search-q"><?php esc_html_e( 'Search', 'sebkijk-atelier' ); ?></label>
			<input id="site-search-q" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search the atelier', 'sebkijk-atelier' ); ?>" />
		</form>
	</div>
	<hr class="site-head__rule" aria-hidden="true" />
</header>

<main id="main" class="site-main" role="main">
