<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_8
 */

if ( ! is_active_sidebar( 'default-3' ) ) {
	return;
}
?>

<aside id="default-3" class="widget-area">
	<?php dynamic_sidebar( 'default-3' ); ?>
</aside><!-- #default-3 -->
