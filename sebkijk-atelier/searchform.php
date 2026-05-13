<?php
/**
 * Default search form.
 *
 * @package SebKijk_Atelier
 */
?>
<form role="search" class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s-<?php echo esc_attr( uniqid() ); ?>"><?php esc_html_e( 'Search', 'sebkijk-atelier' ); ?></label>
	<input id="s-<?php echo esc_attr( uniqid() ); ?>" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search the atelier', 'sebkijk-atelier' ); ?>" />
	<button type="submit"><?php esc_html_e( 'Find', 'sebkijk-atelier' ); ?></button>
</form>
