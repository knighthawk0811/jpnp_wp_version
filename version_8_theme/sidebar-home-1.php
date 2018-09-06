<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_8
 */

if ( ! is_active_sidebar( 'home-1' ) ) {
	return;
}
?>

<aside class="home-1" class="widget-area">
	<?php dynamic_sidebar( 'home-1' ); ?>
</aside><!-- #home-1 -->
