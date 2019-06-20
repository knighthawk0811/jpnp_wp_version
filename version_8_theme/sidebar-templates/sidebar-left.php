<?php
/**
 * Sidebar - left.
 *
 * @package version_8
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-left' ); ?>
<?php endif; ?>