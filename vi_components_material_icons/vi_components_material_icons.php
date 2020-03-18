<?php
/*
Plugin Name: VI: Components Material Icons
Plugin URI: http://neathawk.us
Description: Just include the Material Icons Components, on the public facing side of the website, nothing more
Version: 9.1.200317
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
 * @link http://google.github.io/material-design-icons/
 * @link https://github.com/google/material-design-icons/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 9.1.200310
 * @since 9.1.200220
 */
if ( ! function_exists( 'version_8_load_material_icon_components' ) ) :
function version_8_load_material_icon_components() {

    wp_enqueue_style( 'version_8-material_icon_style', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '3.0.1', 'all' );
}
//prioritize above default so that it is more likely to be overridden naturally in the theme
add_action( 'wp_enqueue_scripts', 'version_8_load_material_icon_components' 5 );
endif;