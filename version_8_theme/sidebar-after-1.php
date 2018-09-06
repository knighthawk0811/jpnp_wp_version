<?php
/**
 * The sidebar containing a widget area that loads after the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_7
 */

if ( ! is_active_sidebar( 'sidebar-active-1' ) ) {
	return;
}?>
<div>
<?php dynamic_sidebar( 'sidebar-active-1' ); ?>
</div>
