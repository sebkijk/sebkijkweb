<?php
/**
 * SebKijk Atelier theme bootstrap.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SEBKIJK_ATELIER_VERSION', '1.0.0' );
define( 'SEBKIJK_ATELIER_DIR', get_template_directory() );
define( 'SEBKIJK_ATELIER_URI', get_template_directory_uri() );

require_once SEBKIJK_ATELIER_DIR . '/inc/setup.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/enqueue.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/post-types.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/taxonomies.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/acf-fields.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/template-tags.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/blocks.php';
require_once SEBKIJK_ATELIER_DIR . '/inc/notes.php';
