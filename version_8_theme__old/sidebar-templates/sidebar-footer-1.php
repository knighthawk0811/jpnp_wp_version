<?php
/**
 * The sidebar containing a footer widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_8
 */

if ( ! is_active_sidebar( 'sidebar-footer-1' ) ) {
	return;
} ?>
<div id="footer-1">
<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
</div>
