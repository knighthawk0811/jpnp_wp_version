<?php
/**
 * Sidebar - 1.
 *
 * @package version_8
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div id="sidebar-1">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
<?php endif; ?>