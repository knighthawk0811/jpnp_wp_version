<?php
/**
 * Sidebar - header.
 *
 * @package version_8
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-header' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-header' ); ?>
<?php endif; ?>