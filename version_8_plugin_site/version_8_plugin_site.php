<?php
/*
Plugin Name: version_8_plugin_site
Plugin URI: http://neathawk.us
Description: A collection of generic functions that are specific to this site
Version: 0.2.181214
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class version_8_plugin_site {
/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
# define default variables
# Generic Plugin Functions
# Generic PHP functions
# Shortcodes (are plugin territory)
--------------------------------------------------------------*/


/*--------------------------------------------------------------
# define default variables
--------------------------------------------------------------*/
define( VERSION_8_PLUGIN_SITE, '0.1.20181214' );
define( VERSION_8_PLUGIN_SITE_DB, '0.1.20181214' );


/*--------------------------------------------------------------
# Generic Plugin Functions
--------------------------------------------------------------*/

/**
 * INIT plugin and create DB tables
 *
 * @link
 */
public static function init()
{
    if( !version_8_plugin_site::plugin_is_up_to_date() )
    {
        //access DB
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        //DB version 0.1
        $sql = "CREATE TABLE " . $wpdb->prefix."site_plugin_log_guest (
        id int( 60 ) UNSIGNED NOT NULL AUTO_INCREMENT,
        email_address text NOT NULL,
        name_first text NOT NULL,
        name_last text NOT NULL,
        name_company text NOT NULL,
        user_id int(30) NOT NULL,
        ip_address varchar(25) NOT NULL,
        timestamp int(30) NOT NULL,
        UNIQUE KEY id ( id )
        );";
        dbDelta( $sql );

        update_option( 'version_8_plugin_site_db', VERSION_8_PLUGIN_SITE_DB );
    }

    //set options if they don't already exist
    /*
    if( get_option( 'jpnp_botstop_emergency_last_timestamp', false ) == false )
    {
        update_option( 'jpnp_botstop_emergency_last_timestamp', current_time( 'timestamp' ) );
    }
    //*/
}


/**
 * check if version is up to date
 *
 * @link
 */
public static function plugin_is_up_to_date()
{
    return ( floatval(get_option( "version_8_plugin_site_db", 0 )) >= VERSION_8_PLUGIN_SITE_DB ? true : false );
}

/**
 * deactivate plugin, remove SOME data
 *
 * @link
 */
public static function deactivate()
{
    //delete_option('version_8_plugin_site_db');
}

/**
 * uninstall plugin, remove ALL data
 *
 * @link
 */
public static function uninstall()
{
    if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    {
        exit();
    }
    //delete options
    delete_option( 'version_8_plugin_site_db' );

    //drop custom db table
    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}site_plugin_log_guest" );
}

/**
 * ENQUEUE SCRIPTS AND STYLES
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
public static function enqueue_scripts() {

    //style for the plugin
    wp_register_style( 'version_8_plugin_site-style', plugins_url( '/version_8_plugin_site.css', __FILE__ ), NULL , NULL , 'all' );
    wp_enqueue_style( 'version_8_plugin_site-style' );

    //AJAX
    // register your script location, dependencies and version
    wp_register_script( 'version_8_plugin_site-js', plugins_url( '/js/version_8_plugin_site.js', __FILE__ ), array( 'jquery' ), false, true );
    // enqueue the script
    wp_enqueue_script('version_8_plugin_site-js');
    // localize the script for proper AJAX functioning
    wp_localize_script( 'version_8_plugin_site-js', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));

}

/*--------------------------------------------------------------
# Generic PHP functions
--------------------------------------------------------------*/

/*--------------------------------------------------------------
# Shortcodes (are plugin territory)
--------------------------------------------------------------*/




}// class version_8_plugin_site



/*--------------------------------------------------------------
>>> Filters, Hooks, and Shortcodes:
----------------------------------------------------------------*/
# define default variables
register_activation_hook( __FILE__, Array(  'version_8_plugin_site', 'init' ) );
register_deactivation_hook( __FILE__, Array(  'version_8_plugin_site', 'deactivate' ) );
register_uninstall_hook( __FILE__, Array(  'version_8_plugin_site', 'uninstall' ) );
add_action( 'wp_enqueue_scripts', Array(  'version_8_plugin_site', 'enqueue_scripts' ) );
# Generic Plugin Functions
# Generic PHP functions
# Shortcodes (are plugin territory)
/*--------------------------------------------------------------*/