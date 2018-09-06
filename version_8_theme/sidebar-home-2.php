<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_8
 */

if ( ! is_active_sidebar( 'home-2' ) ) {
	return;
}
?>

<aside class="home-2" class="widget-area">
	<?php dynamic_sidebar( 'home-2' ); ?>
</aside><!-- #home-2 -->
