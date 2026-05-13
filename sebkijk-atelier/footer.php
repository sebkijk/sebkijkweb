<?php
/**
 * The footer.
 *
 * @package SebKijk_Atelier
 */
?>
</main><!-- /#main -->

<footer class="site-foot" role="contentinfo">
	<hr class="site-foot__rule" aria-hidden="true" />
	<div class="site-foot__inner">
		<p class="site-foot__mark"><?php bloginfo( 'name' ); ?></p>
		<p class="site-foot__tag"><?php bloginfo( 'description' ); ?></p>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="site-foot__nav" aria-label="<?php esc_attr_e( 'Footer', 'sebkijk-atelier' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'site-foot__list',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'colophon' ) ) : ?>
			<div class="site-foot__colophon">
				<?php dynamic_sidebar( 'colophon' ); ?>
			</div>
		<?php endif; ?>

		<p class="site-foot__legal">
			<span>© <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.</span>
			<span><?php esc_html_e( 'Een digitaal schetsboek.', 'sebkijk-atelier' ); ?></span>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
