<?php
/**
 * The sidebar containing a footer widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_7
 */

if ( ! is_active_sidebar( 'sidebar-footer-2' ) ) {
	return;
}?>
<div id="footer-center">
<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
</div>
