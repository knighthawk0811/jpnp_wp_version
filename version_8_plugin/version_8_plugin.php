<?php
/*
Plugin Name: Version 8 Plugin: Generic
Plugin URI: http://neathawk.us
Description: A collection of generic functions that don't have their own plugin
Version: 0.2.181219
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

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
define( 'VERSION_8_PLUGIN', '0.2.181219' );
define( 'VERSION_8_PLUGIN_DB', '0.2.181219' );


/*--------------------------------------------------------------
# Generic Plugin Functions
--------------------------------------------------------------*/
/**
 * INIT plugin and set options
 *
 * @link
 */
if ( ! function_exists( 'version_8_plugin_init' ) ) :
function version_8_plugin_init()
{
    if( !version_8_plugin_is_up_to_date() )
    {

        update_option( 'version_8_plugin_db', VERSION_8_PLUGIN_DB );
    }

    //set options if they don't already exist
    /*
    if( get_option( 'jpnp_botstop_emergency_last_timestamp', false ) == false )
    {
        update_option( 'jpnp_botstop_emergency_last_timestamp', current_time( 'timestamp' ) );
    }
    //*/
}
register_activation_hook( __FILE__, 'version_8_plugin_init' );
endif;


/**
 * check if version is up to date
 *
 * @link
 */
if ( ! function_exists( 'version_8_plugin_is_up_to_date' ) ) :
function version_8_plugin_is_up_to_date()
{
    return ( floatval(get_option( "version_8_plugin_db", 0 )) >= VERSION_8_PLUGIN_DB ? true : false );
}
endif;

/**
 * deactivate plugin, remove SOME data
 *
 * @link
 */
if ( ! function_exists( 'version_8_plugin_deactivate' ) ) :
function version_8_plugin_deactivate()
{
    //delete_option('version_8_plugin_db');
}
register_deactivation_hook( __FILE__, 'version_8_plugin_deactivate' );
endif;

/**
 * uninstall plugin, remove ALL data
 *
 * @link
 */
if ( ! function_exists( 'version_8_plugin_uninstall' ) ) :
function version_8_plugin_uninstall()
{
    if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    {
        exit();
    }
    //delete options
    delete_option( 'version_8_plugin_db' );
}
register_uninstall_hook( __FILE__, 'version_8_plugin_uninstall' );
endif;

/**
 * ENQUEUE SCRIPTS AND STYLES *
 *
 * wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_register_script( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 *
 * wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_register_script( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
if ( ! function_exists( 'version_8_plugin_scripts' ) ) :
function version_8_plugin_scripts() {

    //style for the plugin
    //wp_enqueue_style( 'version_8_plugin-style', plugins_url( '/version_8_plugin.css', __FILE__ ), NULL , NULL , 'all' );

	//JS
	//included in header
	//wp_enqueue_script( 'version_8_plugin-JS_head', get_template_directory_uri() . '/js/version_8_plugin_head.js', array('jquery'), false, true );
	//included in footer
	//wp_enqueue_script( 'version_8_plugin-JS_foot', get_template_directory_uri() . '/js/version_8_plugin_foot.js', array('jquery'), false, false );

    //AJAX
    //wp_enqueue_script( 'version_8_plugin-AJAX', plugins_url( '/js/version_8_plugin_ajax.js', __FILE__ ), array( 'jquery' ), false, true );
    // localize the script for proper AJAX functioning
    //wp_localize_script( 'version_8_plugin-AJAX', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));

}
//add_action( 'wp_enqueue_scripts', 'version_8_plugin_scripts' );
endif;


/*--------------------------------------------------------------
# Generic PHP functions
--------------------------------------------------------------*/

/**
 * display a var_dump as a <pre> html element
 *
 * @link copied form the version_7 theme
 * @requires
 */
if ( ! function_exists( 'var_dump_pre' ) ) :
function var_dump_pre($mixed = NULL, $label = NULL)
{
    if(is_string($label)){$label .= ': ';}else{$label = '';}
    echo '<pre>' . $label . "\n";
    var_dump($mixed);
    echo '</pre>';
    return NULL;
}
endif;
/**
 * return a var_dump as a string value
 *
 * @link copied form the version_7 theme
 * @requires
 */
if ( ! function_exists( 'var_dump_return' ) ) :
function var_dump_return($mixed = NULL)
{
    ob_start();
    var_dump($mixed);
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
endif;


/*--------------------------------------------------------------
# Shortcodes
--------------------------------------------------------------*/

/**
 * Call a shortcode function by tag name.
 *
 * @author J.D. Grimes
 * @link https://codesymphony.co/dont-do_shortcode/
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 * @example $result = do_shortcode_func( 'shorcode' );
 * @example $result = do_shortcode_func( 'shortcode', array( 'attr' => 'value' ), 'shortcode content' );
 */
if ( ! function_exists( 'do_shortcode_func' ) ) :
function do_shortcode_func( $tag, array $atts = array(), $content = null )
{
    global $shortcode_tags;

    if ( ! isset( $shortcode_tags[ $tag ] ) )
    {
        return false;
    }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}
endif;

/**
 * Filters all menu item URLs for a #placeholder#.
 *
 * @link https://stackoverflow.com/questions/11403189/how-to-insert-shortcode-into-wordpress-menu
 * @param WP_Post[] $menu_items All of the nave menu items, sorted for display.
 * @return WP_Post[] The menu items with any placeholders properly filled in.
 */
if ( ! function_exists( 'version_8_plugin_dynamic_menu_item' ) ) :
function version_8_plugin_dynamic_menu_item( $menu_items ) {

    // A list of placeholders to replace.
    // You can add more placeholders to the list as needed.
    $placeholders = array(
        '#logout-link#' => array(
            'shortcode' => 'site_logout_url',
            'atts' => array(), // Shortcode attributes.
            'content' => '', // Content for the shortcode.
        ),
        '#login-link#' => array(
            'shortcode' => 'site_login_url',
            'atts' => array(), // Shortcode attributes.
            'content' => '', // Content for the shortcode.
        ),
    );

    foreach ( $menu_items as $menu_item )
    {

        if ( isset( $placeholders[ $menu_item->url ] ) )
        {

            global $shortcode_tags;

            $placeholder = $placeholders[ $menu_item->url ];

            if ( isset( $shortcode_tags[ $placeholder['shortcode'] ] ) )
            {

                $menu_item->url = call_user_func(
                    $shortcode_tags[ $placeholder['shortcode'] ]
                    , $placeholder['atts']
                    , $placeholder['content']
                    , $placeholder['shortcode']
                );
            }
        }
    }

    return $menu_items;
}
add_filter( 'wp_nav_menu_objects', 'version_8_plugin_dynamic_menu_item' );
endif;

/**
 * display a menu anywhere
 *
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
 * @requires
 */
if ( ! function_exists( 'version_8_plugin_display_menu' ) ) :
function version_8_plugin_display_menu($attr)
{
    /*
    [vip_display_menu id="menu_id"]
    no content
    [/vip_display_menu]
    */
    ob_start();

    extract( shortcode_atts( array( 'id' => null ), $attr ) );

    if ( is_nav_menu( $id ) ) {
        wp_nav_menu( array(
            'menu' => $id,
        ) );
    }

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'vip_display_menu', 'version_8_plugin_display_menu' );
add_shortcode( 'vip-display-menu', 'version_8_plugin_display_menu' );
endif;

/**
 * display a menu from another sub-site
 *
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
 * @link https://wordpress.stackexchange.com/questions/26367/use-wp-nav-menu-to-display-a-menu-from-another-site-in-a-network-install
 * @requires
 */
if ( ! function_exists( 'version_8_plugin_display_menu_multi' ) ) :
function version_8_plugin_display_menu_multi($attr)
{
    /*
    [vip_display_menu_multi id="menu_id" sub="sub_site_id"]
    no content
    [/vip_display_menu_multi]
    */
    $blog_id = get_current_blog_id();
    $content = '';

    extract( shortcode_atts( array( 'id' => null, 'sub' => $blog_id), $attr ) );

    $id = sanitize_title( $id );
    $sub = absint( $sub );

    if( ( $sub != $blog_id ) && is_multisite() )
    {
        switch_to_blog( $sub );
    }

    ob_start();

    if ( is_nav_menu( $id ) ) {
        wp_nav_menu( array(
            'menu' => $id,
        ) );
    }

    $content = ob_get_contents();
    ob_end_clean();

    restore_current_blog();
    return $content;
}
add_shortcode( 'vip_display_menu_multi', 'version_8_plugin_display_menu_multi' );
endif;

/**
 * display a link "button" anywhere
 *
 * @link https://codex.wordpress.org/Data_Validation#Input_Validation
 * @requires
 */
if ( ! function_exists( 'version_8_plugin_display_button_link' ) ) :
function version_8_plugin_display_button_link($attr)
{
    /*
    [site_button_link url="url" text="text"]
    no content
    [/site_button_link]
    */
    ob_start();

    extract( shortcode_atts( array( 'url' => null, 'text' => null ), $attr ) );

    if($url != null )
    {
        $url = esc_url_raw( $url );
    }
    else
    {
        $url = '/';
    }
    if($text != null )
    {
        $text = sanitize_text_field( $text );
    }
    else
    {
        $text = 'Link';
    }

    echo('<form name="button-link" class="button button-link" style="position:inline;" action="' . $url . '" method="post">');
    echo('<input type="submit" name="button-link' . $text . '" class="button button-link" value="' . $text . '" />');
    echo('</form>');


    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'vip_button_link', 'version_8_plugin_display_button_link' );
endif;


/**
 * display breadcrumbs anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'version_8_plugin_display_breadcrumbs' ) ) :
function version_8_plugin_display_breadcrumbs()
{
    $output = '';
    $page_id = get_the_ID();
    if(is_single())
    {
        $cats = get_the_category();
        foreach($cats as $cat)
        {
            if($cat->cat_ID == 146)
            {
                //articales & tools
                $page_id = 127;
            }
        }
    }
    //display breadcrumbs
    $breadcrumb_array = array_reverse(get_post_ancestors($page_id));
    $output .= '<div class="breadcrumb">      ';//add 6 spaces in case they get removed later
    if(count($breadcrumb_array) > 0)
    {
        $output .= '<div class="bc-content">';
        foreach($breadcrumb_array as $breadcrumb)
        {
            $output .= '<a href="'. get_permalink($breadcrumb) . '">' . get_the_title( $breadcrumb ) . '</a> &gt; ';
        }
        //this page
        $output .= '<a class="current" href="'. get_permalink($page_id) . '">' . get_the_title($page_id) . '</a> &gt; ';
        //$output .= get_the_title( get_the_ID() );
    }

    //if you are on the directory list page, there might be sub categories to show.
    $map_category_array = NULL;
    if(isset($_REQUEST['mc']) && preg_match('/^[0-9]+(,[0-9]+)*$/', $_REQUEST['mc']) == 1)
    {
        $map_category_array = explode(',',$_REQUEST['mc']);
    }
    if(count($map_category_array) > 0)
    {
        //var_dump($map_category_array);
        $category_array = NULL;
        foreach($map_category_array as $category)
        {
            $category_array[] = get_term_by('id', $category,'bgmp-category',ARRAY_A);
        }
        while ( false !== ( $category_array[] = get_term_by('id', end($category_array)['parent'],'bgmp-category',ARRAY_A) ) )
        {
            // do nothing, the action is in the loop test
        }
        //always gets one last "falsy" entry
        array_pop($category_array);
        $category_array = array_reverse($category_array);

        foreach($category_array as $category)
        {
            $output .= '<a href="' . get_permalink() . '?mc=' .$category['term_id'] . '" />' . $category['name'] . '</a> &gt; ';
        }
    }
    //remove the last ' &gt; '
    $output = substr($output,0 ,-6);
    if(count($breadcrumb_array) > 0)
    {
        //close this div
        $output .= '</div>';
    }
    return $output . '</div>';
}
add_shortcode( 'vip_display_breadcrumbs', 'version_8_plugin_display_breadcrumbs' );
endif; // function



