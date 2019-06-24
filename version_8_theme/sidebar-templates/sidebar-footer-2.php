<?php
/**
 * Sidebar - footer.
 *
 * @package version_8
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
<?php endif; ?>