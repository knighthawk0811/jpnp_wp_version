<?php
/*
Plugin Name: Version 8 Plugin: Menu Cache
Plugin URI: http://neathawk.us
Description: Cache the menu in a transient.
Version: 0.2.191022
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class version_8_plugin_menu_cache {
    /**
     * $cache_time
     * transient expiration time
     * @var int
     */
    protected $cache_time = 43200; // 12 hours in seconds
    /**
     * $timer
     * simple timer to time the menu generation
     * @var time
     */
    protected $timer;

    /**
     * __construct
     * class constructor will set the needed filter and action hooks
     *
     */
    function __construct(){
        global $wp_version;
        // only do all of this if WordPress version is 3.9+
        if ( version_compare( $wp_version, '3.9', '>=' ) ) {

            //show the menu from cache
            add_filter( 'pre_wp_nav_menu', array($this,'pre_wp_nav_menu'), 10, 2 );
            //store the menu in cache
            add_filter( 'wp_nav_menu', array($this,'wp_nav_menu'), 10, 2);
            //refresh on update
            add_action( 'wp_update_nav_menu', array($this,'wp_update_nav_menu'), 10, 1);
        }
    }

    /**
     * get_menu_key
     * Simple function to generate a unique id for the menu transient
     * based on the menu arguments and currently requested page.
     * @param  object $args     An object containing wp_nav_menu() arguments.
     * @return string
     */
    protected function get_menu_key($args){
        return 'MC-' . md5( serialize( $args ).serialize(get_queried_object()) );
    }

    /**
     * get_menu_transient
     * Simple function to get the menu transient based on menu arguments
     * @param  object $args     An object containing wp_nav_menu() arguments.
     * @return mixed            menu output if exists and valid else false.
     */
    protected function get_menu_transient($args){
        $key = $this->get_menu_key($args);
        return get_transient($key);
    }



    /**
     * pre_wp_nav_menu
     *
     * This is the magic filter that lets us short-circit the menu generation
     * if we find it in the cache so anything other then null returend will skip the menu generation.
     *
     * @param  string|null $nav_menu    Nav menu output to short-circuit with.
     * @param  object      $args        An object containing wp_nav_menu() arguments
     * @return string|null
     */
    public function pre_wp_nav_menu($nav_menu, $args){
        $this->timer = microtime(true);
        $in_cache = $this->get_menu_transient($args);
        $last_updated = get_transient('MC-' . $args->theme_location . '-updated');
        if (isset($in_cache['data']) && isset($last_updated) &&  $last_updated < $in_cache['time'] ){
            return $in_cache['data'].'<!-- From menu cache in '.number_format( microtime(true) - $this->timer, 5 ).' seconds | ' . $this->get_memory_units() . ' -->';
        }
        return $nav_menu;
    }


    /**
     * wp_nav_menu
     * store menu in cache
     * @param  string $nav      The HTML content for the navigation menu.
     * @param  object $args     An object containing wp_nav_menu() arguments
     * @return string           The HTML content for the navigation menu.
     */
    public function wp_nav_menu( $nav, $args ) {
        $last_updated = get_transient('MC-' . $args->theme_location . '-updated');
        if( ! $last_updated ) {
            set_transient('MC-' . $args->theme_location . '-updated', time());
        }
        $key = $this->get_menu_key($args);
        $data = array('time' => time(), 'data' => $nav);

        set_transient( $key, $data ,$this->cache_time);
        return $nav.'<!-- Not From menu cache in '.number_format( microtime(true) - $this->timer, 5 ).' seconds | ' . $this->get_memory_units() . ' -->';
    }

    /**
     * wp_update_nav_menu
     * refresh time on update to force refresh of cache
     * @param  int $menu_id
     * @return void
     */
    public function wp_update_nav_menu($menu_id) {
        $locations = array_flip(get_nav_menu_locations());

        if( isset($locations[$menu_id]) ) {
            set_transient('MC-' . $locations[$menu_id] . '-updated', time());
        }
    }


    protected function calc_memory_units($size)
    {
        $unit = array('B','KiB','MiB','GiB','TiB','PiB');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
    protected function get_memory_units()
    {
        return $this->calc_memory_units(memory_get_usage(true)) . ' Usage ' . $this->calc_memory_units(memory_get_peak_usage(true)) . ' Peak ';
    }


}//end class

//instantiate the class
add_action( 'plugins_loaded', 'version_8_plugin_menu_cache_init' );
function version_8_plugin_menu_cache_init() {
    $GLOBALS['wp_menu_cache'] = new version_8_plugin_menu_cache();
}
