<?php
/*
Plugin Name: version_8_plugin
Plugin URI: http://neathawk.us
Description: A collection of generic functions that pair with the version_8 theme.
Version: 2018.09.06 - 0.2
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
# Woocommerce Customization
# Woocommerce Custom Subscription Export options
# Woocommerce Template Hooks
--------------------------------------------------------------*/


/*--------------------------------------------------------------
# define default variables
--------------------------------------------------------------*/
define( SITE_PLUGIN_VERSION, '0.2' );
define( SITE_PLUGIN_VERSION_DB, '0.2' );


/*--------------------------------------------------------------
# Generic Plugin Functions
--------------------------------------------------------------*/
/**
 * INIT plugin and create DB tables
 *
 * @link
 */
if ( ! function_exists( 'site_plugin_init' ) ) :
function site_plugin_init()
{
    if( !site_plugin_is_up_to_date() )
    {
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

        update_option( 'site_plugin_version_db', SITE_PLUGIN_VERSION_DB );
    }

    //set these only if they don't already exist
    /*
    if( get_option( 'jpnp_botstop_emergency_last_timestamp', false ) == false )
    {
        update_option( 'jpnp_botstop_emergency_last_timestamp', current_time( 'timestamp' ) );
    }
    //*/
}
register_activation_hook( __FILE__, 'site_plugin_init' );
endif;


/**
 * check if version is up to date
 *
 * @link
 */
if ( ! function_exists( 'site_plugin_is_up_to_date' ) ) :
function site_plugin_is_up_to_date()
{
    return ( floatval(get_option( "site_plugin_version_db", 0 )) >= SITE_PLUGIN_VERSION_DB ? true : false );
}
endif;

/**
 * deactivate plugin, remove SOME data
 *
 * @link
 */
if ( ! function_exists( 'site_plugin_deactivate' ) ) :
function site_plugin_deactivate()
{
    //delete_option('site_plugin_version_db');
}
register_deactivation_hook( __FILE__, 'site_plugin_deactivate' );
endif;

/**
 * uninstall plugin, remove ALL data
 *
 * @link
 */
if ( ! function_exists( 'site_plugin_uninstall' ) ) :
function site_plugin_uninstall()
{
    if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    {
        exit();
    }
    //delete options
    delete_option( 'site_plugin_version_db' );

    //drop custom db table
    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}site_plugin_log_guest" );
}
register_uninstall_hook( __FILE__, 'site_plugin_uninstall' );
endif;

/**
 * ENQUEUE SCRIPTS AND STYLES
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
if ( ! function_exists( 'version_8_plugin_scripts' ) ) :
function version_8_plugin_scripts() {

    //style for the plugin
    wp_register_style( 'version_8_plugin-style', plugins_url( '/version_8_plugin.css', __FILE__ ), NULL , NULL , 'all' );
    wp_enqueue_style( 'version_8_plugin-style' );

    //AJAX
    // register your script location, dependencies and version
    wp_register_script( 'version_8_plugin-js', plugins_url( '/js/version_8_plugin.js', __FILE__ ), array( 'jquery' ), false, true );
    // enqueue the script
    wp_enqueue_script('version_8_plugin-js');
    // localize the script for proper AJAX functioning
    wp_localize_script( 'version_8_plugin-js', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));

}
add_action( 'wp_enqueue_scripts', 'version_8_plugin_scripts' );
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
if ( ! function_exists( 'site_var_dump_pre' ) ) :
function site_var_dump_pre($mixed = NULL, $label = NULL)
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
if ( ! function_exists( 'site_var_dump_return' ) ) :
function site_var_dump_return($mixed = NULL)
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
 */
function do_shortcode_func( $tag, array $atts = array(), $content = null )
{
    global $shortcode_tags;

    if ( ! isset( $shortcode_tags[ $tag ] ) )
    {
        return false;
    }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}
/**
 * Filters all menu item URLs for a #placeholder#.
 *
 * @link https://stackoverflow.com/questions/11403189/how-to-insert-shortcode-into-wordpress-menu
 * @param WP_Post[] $menu_items All of the nave menu items, sorted for display.
 * @return WP_Post[] The menu items with any placeholders properly filled in.
 */
function site_dynamic_menu_item( $menu_items ) {

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
add_filter( 'wp_nav_menu_objects', 'site_dynamic_menu_item' );

/**
 * display a menu anywhere
 *
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
 * @requires
 */
if ( ! function_exists( 'site_display_menu' ) ) :
function site_display_menu($attr)
{
    /*
    [site_menu id="menu_id"]
    no content
    [/site_menu]
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
add_shortcode( 'site_menu', 'site_display_menu' );
endif;


/**
 * display a login "button" anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_login_button_display' ) ) :
function site_login_button_display($attr)
{
    /*
    [site_login_button redirect="url"]
    no content
    [/site_login_button]
    */
    ob_start();

    extract( shortcode_atts( array( 'redirect' => null ), $attr ) );

    $url = wp_login_url( get_permalink() );
    $redirect = esc_url_raw( $redirect );
    if($redirect != null )
    {
        $url = wp_login_url( $redirect );
    }

    echo('<form name="loginform" id="loginform" action="' . $url . '" method="post">');
    echo('<input type="submit" name="login-submit" class="button button-login" value="Log In" />');
    echo('<input type="hidden" name="redirect_to" value="' . get_permalink() . '" />');
    echo('<input type="hidden" name="login" value="true"/>');
    echo('<input type="hidden" name="request_url" value="' . get_permalink() . '"/>');
    echo('</form>');


    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'site_login_button', 'site_login_button_display' );
add_shortcode( 'site_button_login', 'site_login_button_display' );//will be deprecated
endif;

/**
 * display a login link anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_login_link_display' ) ) :
function site_login_link_display($attr)
{
    /*
    [site_login_link redirect="url"]
    no content
    [/site_login_link]
    */

    extract( shortcode_atts( array( 'redirect' => null ), $attr ) );

    $link = wp_loginout( get_permalink(), false );
    $redirect = esc_url_raw( $redirect );
    if($redirect != null )
    {
        $link = wp_loginout( $redirect, false );
    }

    //echo( $link );

    return $link;
}
add_shortcode( 'site_login_link', 'site_login_link_display' );
endif;

/**
 * display a login URL anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_login_url_display' ) ) :
function site_login_url_display($attr)
{
    /*
    [site_login_url redirect="url"]
    no content
    [/site_login_url]
    */

    extract( shortcode_atts( array( 'redirect' => null ), $attr ) );

    $link = wp_login_url( get_permalink() );
    $redirect = esc_url_raw( $redirect );
    if($redirect != null )
    {
        $link = wp_login_url( $redirect );
    }

    //echo( $link );

    return $link;
}
add_shortcode( 'site_login_url', 'site_login_url_display' );
endif;

/**
 * display a logout "button" anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_logout_button_display' ) ) :
function site_logout_button_display($attr)
{
    /*
    [site_button_logout redirect="url"]
    no content
    [/site_button_logout]
    */
    ob_start();

    extract( shortcode_atts( array( 'redirect' => null ), $attr ) );

    $url = wp_logout_url( get_permalink() );
    $redirect = esc_url_raw( $redirect );
    if($redirect != null )
    {
        $url = wp_logout_url( $redirect );
    }

    echo('<form name="logoutform" id="logoutform" action="' . $url . '" method="post">');
    echo('<input type="submit" name="logout-submit" class="button button-logout" value="Log Out" />');
    echo('<input type="hidden" name="redirect_to" value="' . get_permalink() . '" />');
    echo('<input type="hidden" name="logout" value="true"/>');
    echo('<input type="hidden" name="request_url" value="' . get_permalink() . '"/>');
    echo('</form>');

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'site_logout_button', 'site_logout_button_display' );
endif;

/**
 * display a logout link anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_logout_link_display' ) ) :
function site_logout_link_display($attr)
{
    /*
    [site_logout_link redirect="url"]
    no content
    [/site_logout_link]
    */

    extract( shortcode_atts( array( 'redirect' => null ), $attr ) );

    $link = wp_loginout( get_permalink(), false );
    $redirect = esc_url_raw( $redirect );
    if($redirect != null )
    {
        $link = wp_loginout( $redirect, false );
    }

    //echo( $link );

    return $link;
}
add_shortcode( 'site_logout_link', 'site_logout_link_display' );
endif;
/**
 * display a logout URL anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_logout_url_display' ) ) :
function site_logout_url_display($attr)
{
    /*
    [site_logout_url redirect="url"]
    no content
    [/site_logout_url]
    */

    extract( shortcode_atts( array( 'redirect' => null ), $attr ) );

    $link = wp_logout_url( get_permalink() );
    $redirect = esc_url_raw( $redirect );
    if($redirect != null )
    {
        $link = wp_logout_url( $redirect );
    }

    //echo( $link );

    return $link;
}
add_shortcode( 'site_logout_url', 'site_logout_url_display' );
endif;


/**
 * display a link "button" anywhere
 *
 * @link https://codex.wordpress.org/Data_Validation#Input_Validation
 * @requires
 */
if ( ! function_exists( 'site_display_button_link' ) ) :
function site_display_button_link($attr)
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
add_shortcode( 'site_button_link', 'site_display_button_link' );
endif;


/**
 * display breadcrumbs anywhere
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_display_breadcrumbs' ) ) :
function site_display_breadcrumbs()
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
add_shortcode( 'site_breadcrumbs', 'site_display_breadcrumbs' );
endif; // function



/**
 * display content to logged OUT users only
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_visitor_content' ) ) :
function site_visitor_content( $atts, $content = null )
{
    /*
    [visitor]
    content
    [/visitor]
    //*/

    if ( ( !is_user_logged_in() && !is_null( $content ) ) || is_feed() )
    {
        //logged out users get this content
        //do nothing
        //return $content;
    }
    else
    {
        //logged in users DO NOT get this content
        $content = '';
    }
    return do_shortcode($content);
}
add_shortcode( 'visitor', 'site_visitor_content' );
endif;

/**
 * display content to logged IN users only
 *
 * may include any roles as well, displaying content to different roles
 *
 * @link
 * @requires
 */
if ( ! function_exists( 'site_member_content' ) ) :
function site_member_content( $attr, $content = null )
{
    /*
    [member]
    content
    [/member]
    [member type="any"]
    content
    [/member]
    [member type="editor"]
    content
    [/member]
    [member type="subscriber, administrator"]
    content
    [/member]
    //*/

    extract( shortcode_atts( array( 'type' => 'read' ), $attr ) );
    //remove spaces
    $type = str_replace(" ", "", $type);
    $ability = explode(",", $type);
    $access_allowed = false;

    //not NULL and also not in any feeds
    if ( !is_null( $content ) && !is_feed() )
    {
        //targetted users get this content
        foreach( $ability as $item )
        {
            if( strtolower($item) === 'any' )
            {
                //ACTION
                $access_allowed = true;
            }
            else if( current_user_can( $item ) )
            {
                //ACTION
                $access_allowed = true;
            }
        }
    }

    if( !$access_allowed )
    {
        //non-targetted users DO NOT get this content
        $content = '';
    }

    return do_shortcode($content);
}
add_shortcode( 'member', 'site_member_content' );
endif;



/*--------------------------------------------------------------
# Woocommerce Customization
--------------------------------------------------------------*/


/**
 * Add guest email address to the checkout process
 * actually add the field to the HTML form
 *
 * @link https://atlantisthemes.com/woocommerce-checkout-customization/
 * @link https://rudrastyh.com/woocommerce/checkout-fields.html#create_checkout_field
 * @link https://www.sitepoint.com/woocommerce-actions-and-filters-manipulate-cart/
 */
if ( ! function_exists( 'site_wc_custom_field_add' ) ) :
function site_wc_custom_field_add( $checkout ) {

    // check if product in catagory
    if( qualifies_basedon_product_category( 'guest-item' ) > 0 )
    {
        //only one guest allowed per member per event
        echo '<div id="site_wc_guest_field"><h3>'.__('Guest Information').'</h3>';
        woocommerce_form_field( 'site_wc_guest_email', array(
            'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
            'required'      => true, // actually this parameter just adds "*" to the field
            'class'         => array('ceac-field', 'form-row-wide'), // array only, read more about classes and styling in the previous step
            'label'         => 'Guest Email Address',
            'label_class'   => 'ceac-label', // sometimes you need to customize labels, both string and arrays are supported
            //'options'       => array( // options for <select> or <input type="radio" />
            //            ''          => 'Please select', // empty values means that field is not selected
            //            'By phone'  => 'By phone', // 'value'=>'Name'
            //            'By email'  => 'By email'
            //            )
            ), $checkout->get_value( 'site_wc_guest_email' ) );
        woocommerce_form_field( 'site_wc_guest_name_first', array(
            'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
            'required'      => true, // actually this parameter just adds "*" to the field
            'class'         => array('ceac-field', 'form-row-wide'), // array only, read more about classes and styling in the previous step
            'label'         => 'First Name',
            'label_class'   => 'ceac-label', // sometimes you need to customize labels, both string and arrays are supported
            ), $checkout->get_value( 'site_wc_guest_name_first' ) );
        woocommerce_form_field( 'site_wc_guest_name_last', array(
            'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
            'required'      => true, // actually this parameter just adds "*" to the field
            'class'         => array('ceac-field', 'form-row-wide'), // array only, read more about classes and styling in the previous step
            'label'         => 'Last Name',
            'label_class'   => 'ceac-label', // sometimes you need to customize labels, both string and arrays are supported
            ), $checkout->get_value( 'site_wc_guest_name_last' ) );
        woocommerce_form_field( 'site_wc_guest_name_company', array(
            'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
            'required'      => true, // actually this parameter just adds "*" to the field
            'class'         => array('ceac-field', 'form-row-wide'), // array only, read more about classes and styling in the previous step
            'label'         => 'Company',
            'label_class'   => 'ceac-label', // sometimes you need to customize labels, both string and arrays are supported
            ), $checkout->get_value( 'site_wc_guest_name_company' ) );
        echo '</div>';
    }
    else
    {
        //do nothing
    }
}
add_action( 'woocommerce_before_order_notes', 'site_wc_custom_field_add' );
endif;

/**
 * Validate guest email address against the DB collection of previously used email addresses
 * Store logged email (etc) for future validation
 *
 * @link https://atlantisthemes.com/woocommerce-checkout-customization/
 * @link https://rudrastyh.com/woocommerce/checkout-fields.html#create_checkout_field
 * @link https://stackoverflow.com/questions/28603144/custom-validation-of-woocommerce-checkout-fields
 */
if ( ! function_exists( 'site_wc_custom_field_validation' ) ) :
function site_wc_custom_field_validation() {

    // check if product in catagory
    //otherwise don't validate what isn't there
    if( qualifies_basedon_product_category( 'guest-item' ) > 0 )
    {
        site_plugin_init();

        // init variables
        global $wpdb;
        global $woocommerce;
        $error_message = false;
        $table_name = $wpdb->prefix . 'site_plugin_log_guest';
        $guest_email = sanitize_email( $_POST['site_wc_guest_email'] );
        $guest_name_first = sanitize_text_field( $_POST['site_wc_guest_name_first'] );
        $guest_name_last = sanitize_text_field( $_POST['site_wc_guest_name_last'] );
        $guest_name_company = sanitize_text_field( $_POST['site_wc_guest_name_company'] );
        $the_result = $wpdb->get_results( "SELECT email_address FROM " . $table_name, ARRAY_N );
        $result_array = null;

        // is the given email address a valid email at all?
        //if not the don't even process anything else
        if( !is_email( $guest_email ) )
        {
            if( $error_message == false ) //double check
            {
                $error_message = 'The <strong>Guest Email</strong> is invalid. [B294]';
            }
        }
        else
        {
            // $the_result is multidimensional, fix this so we can find values in it easier
            if( is_array( $the_result[0] ) )
            {
                foreach( $the_result as &$result )
                {
                    $result_array[] = $result[0];
                }
            }

            /////TESTING
            //update_option( 'site_plugin_guest_email', $guest_email );
            //update_option( 'site_plugin_the_result', $the_result );
            //update_option( 'site_plugin_result_array', $result_array );

            //if the given email is not found in previous entries
            if( !in_array( $guest_email, $result_array ) )
            {
                //add this email to the db list of previous entries

                // log values
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $user_id = wp_get_current_user();

                // work
                $wpdb->query( $wpdb->prepare(
                    "
                        INSERT INTO $table_name
                        ( email_address, name_first, name_last, name_company, user_id, ip_address, timestamp )
                        VALUES ( %s,%s,%s,%s, %s, %s, %d )
                    ",
                    array(
                        $guest_email,
                        $guest_name_first,
                        $guest_name_last,
                        $guest_name_company,
                        $user_id,
                        $ip_address,
                        current_time('timestamp')
                    )
                ) );
            }
            else
            {
                // the given email was found in previous entries
                if( $error_message == false ) //double check
                {
                    $error_message = 'This <strong>Guest</strong> has already attended a CEAC Event.
                    Guests are only allowed once.
                    <br /> Please choose a different guest (via Guest Email) or cancel this order. [B376]';
                }
            }

        }

        // finally throws an error message if one was set
        if( $error_message !== false )
        {
            //$woocommerce->add_error( __( $error_message ) ); // throws internal server error
            wc_add_notice( __( $error_message ), 'error' );
        }
    }
}
add_action( 'woocommerce_checkout_process', 'site_wc_custom_field_validation' );
endif;

/**
 * Add guest email address to the checkout process
 * save value to the post meta
 *
 * @link https://atlantisthemes.com/woocommerce-checkout-customization/
 * @link https://rudrastyh.com/woocommerce/checkout-fields.html#create_checkout_field
 */
if ( ! function_exists( 'site_wc_save_custom_field' ) ) :
function site_wc_save_custom_field( $order_id ) {

    if( !empty( $_POST['site_wc_guest_email'] ) )
    {
        update_post_meta( $order_id, 'site_wc_guest_email', sanitize_text_field( $_POST['site_wc_guest_email'] ) );
        update_post_meta( $order_id, 'site_wc_guest_name_first', sanitize_text_field( $_POST['site_wc_guest_name_first'] ) );
        update_post_meta( $order_id, 'site_wc_guest_name_last', sanitize_text_field( $_POST['site_wc_guest_name_last'] ) );
        update_post_meta( $order_id, 'site_wc_guest_name_company', sanitize_text_field( $_POST['site_wc_guest_name_company'] ) );
    }

}
add_action( 'woocommerce_checkout_update_order_meta', 'site_wc_save_custom_field' );
endif;

/**
 * Add the field to order review/ thank you
 *
 * @link https://developer.wordpress.org/reference/functions/get_post_meta/
 * @link https://docs.woocommerce.com/wc-apidocs/class-WC_Order.html
 * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
 **/
if ( ! function_exists( 'site_wc_checkout_field_order_review' ) ) :
function site_wc_checkout_field_order_review( $order ) {
    $guest_email = get_post_meta( $order->get_order_number(), 'site_wc_guest_email', true );
    $guest_name_first = get_post_meta( $order->get_order_number(), 'site_wc_guest_name_first', true );
    $guest_name_last = get_post_meta( $order->get_order_number(), 'site_wc_guest_name_last', true );
    $guest_name_company = get_post_meta( $order->get_order_number(), 'site_wc_guest_name_company', true );
    if( !empty( $guest_email ) )
    {
        echo '<div id="site_wc_guest_field"><h2>'.__('Guest Information').'</h2>';
        echo 'Email Address: ' . $guest_email . '<br />';
        echo 'First Name: ' . $guest_name_first . '<br />';
        echo 'Last Name: ' . $guest_name_last . '<br />';
        echo 'Company: ' . $guest_name_company . '<br />';
        echo '</div>';
    }
}
add_filter('woocommerce_order_details_after_order_table', 'site_wc_checkout_field_order_review');
endif;

/**
 * Add the field to order emails
 * ugly version
 *
 * @param $keys array of keys
 *
 * @link https://atlantisthemes.com/woocommerce-checkout-customization/
 * @link https://rudrastyh.com/woocommerce/order-meta-in-emails.html
 **/
if ( ! function_exists( 'site_wc_checkout_email_order_meta_keys' ) ) :
function site_wc_checkout_email_order_meta_keys( $keys ) {
    $keys[] = 'site_wc_guest_email';
    $keys[] = 'site_wc_guest_name_first';
    $keys[] = 'site_wc_guest_name_last';
    $keys[] = 'site_wc_guest_name_company';
    return $keys;
}
//add_filter( 'woocommerce_email_order_meta_keys', 'site_wc_checkout_email_order_meta_keys' );
endif;

/**
 * Add the field to order emails
 * broken version
 *
 * @param $fields array of fields
 * @param $sent_to_admin If this email is for administrator or for a customer
 * @param $order_obj Order Object
 *
 * @link https://atlantisthemes.com/woocommerce-checkout-customization/
 * @link https://rudrastyh.com/woocommerce/order-meta-in-emails.html
 **/
if ( ! function_exists( 'site_wc_checkout_email_order_meta_fields' ) ) :
function site_wc_checkout_email_order_meta_fields( $fields, $sent_to_admin, $order_obj ) {
    $fields['site_wc_guest_email'] = array(
        'label' => 'Guest Email Address',
        'value' => get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_email', true )
    );
    $fields['site_wc_guest_name_first'] = array(
        'label' => 'Guest First Name',
        'value' => get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_name_first', true )
    );
    $fields['site_wc_guest_name_last'] = array(
        'label' => 'Guest Last Name',
        'value' => get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_name_last', true )
    );
    $fields['site_wc_guest_name_company'] = array(
        'label' => 'Guest Company',
        'value' => get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_name_company', true )
    );

    return $fields;
}
//add_filter( 'woocommerce_email_order_meta_fields', 'site_wc_checkout_email_order_meta_fields' );
endif;

/**
 * Add the field to order emails
 * best, most customized version
 *
 * @param $order_obj Order Object
 * @param $sent_to_admin If this email is for administrator or for a customer
 * @param $plain_text HTML or Plain text (can be configured in WooCommerce > Settings > Emails)
 *
 * @link https://atlantisthemes.com/woocommerce-checkout-customization/
 * @link https://rudrastyh.com/woocommerce/order-meta-in-emails.html
 **/
if ( ! function_exists( 'site_wc_checkout_email_order_meta' ) ) :
function site_wc_checkout_email_order_meta( $order_obj, $sent_to_admin, $plain_text) {
    $guest_email = get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_email', true );
    $guest_name_first = get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_name_first', true );
    $guest_name_last = get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_name_last', true );
    $guest_name_company = get_post_meta( $order_obj->get_order_number(), 'site_wc_guest_name_company', true );

    if( !empty( $guest_email ) )
    {
        // add a separate version for plaintext emails
        if( $plain_text == false )
        {
            // you shouldn't have to worry about inline styles, WooCommerce adds them itself depending on the theme you use
            echo '<h2>Guest Information</h2>
            <ul>
            <li><strong>Email Address</strong> ' . $guest_email . '</li>
            <li><strong>First Name</strong> ' . $guest_name_first . '</li>
            <li><strong>Last Name</strong> ' . $guest_name_last . '</li>
            <li><strong>Company</strong> ' . $guest_name_company . '</li>
            </ul>';
        }
        else
        {
            echo 'Guest Information'. "\n" . 'Email Address: ' . $guest_email;
            echo "\n" . 'First Name: ' . $guest_name_first;
            echo "\n" . 'Last Name: ' . $guest_name_last;
            echo "\n" . 'Company: ' . $guest_name_company;
        }
    }
}
add_action( 'woocommerce_email_order_meta', 'site_wc_checkout_email_order_meta' );
endif;

/**
 * Will extract the Variation ID if available otherwise it will get the Product ID
 * @param $product Product
 * @param bool $check_variations Whether or not to check for variation IDs
 * @return mixed
 * @link https://www.sitepoint.com/woocommerce-actions-and-filters-manipulate-cart/
 */
if ( ! function_exists( 'get_id_from_product' ) ) :
function get_id_from_product( $product, $check_variations = true ) {
    // Are we taking variations into account?
    if( $check_variations ) {
        // Ternary Operator
        // http://php.net/manual/en/language.operators.comparison.php
        return ( isset( $product['variation_id'] )
            && ! empty( $product['variation_id'])
            && $product['variation_id'] != 0 )
            ? $product['variation_id']
            : $product['product_id'];
    } else {
        // No variations, just need the product IDs
        return $product['product_id'];
    }
}
endif;
/**
 * Checks the cart to verify whether or not a product from a Category is in the cart
 * @param $category Accepts the Product Category Name, ID, Slug or array of them
 * @return bool
 * @link https://www.sitepoint.com/woocommerce-actions-and-filters-manipulate-cart/
 */
if ( ! function_exists( 'qualifies_basedon_product_category' ) ) :
function qualifies_basedon_product_category( $category ) {
    $count = 0;
    foreach( WC()->cart->cart_contents as $key => $product_in_cart ) {
        if( has_term( $category, 'product_cat', get_id_from_product( $product_in_cart, false ) ) ) {
            $count++;
        }
    }
    return $count;
}
endif;


/*--------------------------------------------------------------
# Woocommerce Custom Subscription Export options
--------------------------------------------------------------*/
/**
 * Add custom headers to the list of default headers exported in the CSV
 *
 * @param array $headers
 * @return array
 */
if ( ! function_exists( 'site_wcsie_custom_export_headers' ) ) :
function site_wcsie_custom_export_headers( $headers = array() ) {
    return array_merge( $headers, array(
        'ceac_status_select' => 'Member Status',
    ) );
}
add_filter( 'wcsie_export_headers', 'site_wcsie_custom_export_headers', 10, 1 );
endif;

/**
 * Adds a custom meta value to the exported row
 *
 * @param string value
 * @param WC_Subscription $subscription
 * @param
 * @return string
 */
if ( ! function_exists( 'site_wcsie_custom_export_values' ) ) :
 function site_wcsie_custom_export_values( $value, $subscription, $header_key ) {
    if ( 'ceac_status_select' == $header_key && empty( $value ) )
    {
        //use the customer ID to gather their "STATUS" from the user meta
        $value = get_user_meta($subscription->customer_id, 'ceac_status_select', true);;
    }

    return $value;
 }
add_filter( 'wcsie_format_export_value', 'site_wcsie_custom_export_values', 10, 3 );
endif;



/*--------------------------------------------------------------
# Woocommerce Template Hooks
--------------------------------------------------------------*/


/**
 * Hook: woocommerce_account_dashboard.
 *
 * @link https://businessbloomer.com/woocommerce-visual-hook-guide-account-pages/
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @requires
 */
if ( ! function_exists( 'site_wc_hook_account_message' ) ) :
function site_wc_hook_account_message()
{
    //echo(' *found it* ' );
    if( !is_user_logged_in() )
    {
        //echo(' *not logged in* ');
    }
    else
    {
        //echo(' *logged in* ');

        echo( '<p>If this is your first time here, be sure to edit your <a href="https://chiefengineer.org/home/my-account/edit-account/">Account Details</a> and <a href="https://chiefengineer.org/home/my-account/edit-address/">Addresses.</p>');

    }
}
endif;
add_filter( 'woocommerce_account_dashboard', 'site_wc_hook_account_message' );


