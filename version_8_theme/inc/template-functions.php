<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package version_8
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
 * @version 8.3.1908
 * @since 8.3.1904
 * @uses version_8_body_add_class
 */
if ( ! function_exists( 'version_8_body_classes' ) ) :
function version_8_body_classes( $classes = null ) {

	if(!is_array( $classes ))
	{
		$temp = explode(' ', $classes);
		unset($classes);
		$classes = array();
		foreach( $temp as $item)
		{
			$classes[] = $item;
		}
		unset($temp);
	}

	//add built up classes
	foreach( version_8_body_add_class() as $item)
	{
		$classes[] = $item;
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'version_8_body_classes' );
endif;

/**
 * Adds dynamic classes to the array for body classes.
 *
 * @link https://wordpress.stackexchange.com/a/48683
 * @version 8.3.1908
 * @since 8.3.1908
 */
if ( ! function_exists( 'version_8_body_add_class' ) ) :
function version_8_body_add_class( $input = null ) {

	static $version_8_body_add_class_array = array();

	if(!is_array( $input ))
	{
		$temp = explode(' ', $input);
		unset($input);
		$input = array();
		foreach( $temp as $item)
		{
			$input[] = $item;
		}
		unset($temp);
	}

	$version_8_body_add_class_array = array_merge($version_8_body_add_class_array, $input);

	return $version_8_body_add_class_array;
}
endif;


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function version_8_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'version_8_pingback_header' );
