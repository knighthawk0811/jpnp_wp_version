<?php
/*
Plugin Name: Version 8 Plugin: Login Link
Plugin URI: http://neathawk.us
Description: A collection of functions and shortcodes that display login/out links and buttons
Version: 0.2.181214
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class version_8_plugin_login_link {
    /*--------------------------------------------------------------
    >>> TABLE OF CONTENTS:
    ----------------------------------------------------------------
    # General Functions
    # Shortcode Functions (are plugin territory)
    --------------------------------------------------------------*/


    /*--------------------------------------------------------------
    # General Functions
    --------------------------------------------------------------*/
    
    /**
     * Filters all menu item URLs for a #placeholder#.
     *
     * @link https://stackoverflow.com/questions/11403189/how-to-insert-shortcode-into-wordpress-menu
     * @param WP_Post[] $menu_items All of the nave menu items, sorted for display.
     * @return WP_Post[] The menu items with any placeholders properly filled in.
     */
    function dynamic_menu_item( $menu_items ) {

        // A list of placeholders to replace.
        // You can add more placeholders to the list as needed.
        $placeholders = array(
            '#logout-link#' => array(
                'shortcode' => 'vip_logout_url',
                'atts' => array(), // Shortcode attributes.
                'content' => '', // Content for the shortcode.
            ),
            '#login-link#' => array(
                'shortcode' => 'vip_login_url',
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



    /*--------------------------------------------------------------
    # Shortcode Functions (are plugin territory)
    --------------------------------------------------------------*/


    /**
     * display a login "button" anywhere
     *
     * @link
     * @requires
     */
    public static function login_button_display($attr)
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

    /**
     * display a login link anywhere
     *
     * @link
     * @requires
     */
    public static function login_link_display($attr)
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

    /**
     * display a login URL anywhere
     *
     * @link
     * @requires
     */
    public static function login_url_display($attr)
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

    /**
     * display a logout "button" anywhere
     *
     * @link
     * @requires
     */
    public static function logout_button_display($attr)
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

    /**
     * display a logout link anywhere
     *
     * @link
     * @requires
     */
    public static function logout_link_display($attr)
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
    /**
     * display a logout URL anywhere
     *
     * @link
     * @requires
     */
    public static function logout_url_display($attr)
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



}//class version_8_plugin_login_link

add_filter( 'wp_nav_menu_objects', Array(  'version_8_plugin_login_link', 'dynamic_menu_item' ) );

add_shortcode( 'vip_login_button', Array(  'version_8_plugin_login_link', 'login_button_display' ) );
add_shortcode( 'vip_login_link', Array(  'version_8_plugin_login_link', 'login_link_display' ) );
add_shortcode( 'vip_login_url', Array(  'version_8_plugin_login_link', 'login_url_display' ) );
add_shortcode( 'vip_logout_button', Array(  'version_8_plugin_login_link', 'logout_button_display' ) );
add_shortcode( 'vip_logout_link', Array(  'version_8_plugin_login_link', 'logout_link_display' ) );
add_shortcode( 'vip_logout_url', Array(  'version_8_plugin_login_link', 'logout_url_display' ) );