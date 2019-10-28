<?php
/*
Plugin Name: Version 8 Plugin: Bootstrap Components
Plugin URI: http://neathawk.us
Description: Just include the Bootstrap Components, nothing more
Version: 0.1.190917
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Add Bootstrap components
 *
 * @link https://getbootstrap.com/docs/4.1/getting-started/introduction/
 * @version 8.3.1909
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_load_bootstrap_components' ) ) :
function version_8_load_bootstrap_components() {
    if ( is_admin() ) {
       return;
    }

    wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1' );

    wp_enqueue_script( 'popper.js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), '1.14.7', true );
    wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), '4.3.1', true );
}
add_action( 'wp_enqueue_scripts', 'version_8_load_bootstrap_components' );
endif;