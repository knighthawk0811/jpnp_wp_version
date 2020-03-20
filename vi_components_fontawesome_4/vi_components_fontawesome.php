<?php
/*
Plugin Name: VI: Components Font Awesome
Plugin URI: http://neathawk.us
Description: Just include the Font Awesome Components, on the public facing side of the website, nothing more
Version: 9.1.200310
Author: Joseph Neathawk
Author URI: http://Neathawk.com
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Add Font Awesome components
 *
 * @link https://www.bootstrapcdn.com/fontawesome/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 9.1.200310
 * @since 9.1.200220
 */
if ( ! function_exists( 'version_8_load_fontawesome_components' ) ) :
function version_8_load_fontawesome_components() {
    //wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/2a10fd682a.js', array(), '5.0.0' );
    wp_enqueue_style( 'fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', false );
    //wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', false );
}
//prioritize above default so that it is more likely to be overridden naturally in the theme
add_action( 'wp_enqueue_scripts', 'version_8_load_fontawesome_components', 5 );
endif;