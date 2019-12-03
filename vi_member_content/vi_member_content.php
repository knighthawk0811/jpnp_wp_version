<?php
/*
Plugin Name: VI: Member Content
Plugin URI: https://neathawk.com/2019/plugin-member-content/
Description: A collection of generic functions that separate content by visitor/member/ member of type
Version: 9.1.191203
Author: Joseph Neathawk
Author URI: http://Neathawk.com
License: GNU General Public License v2 or later
* Text Domain: vi-member-content
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class vi_plugin_member_content {
    /*--------------------------------------------------------------
    >>> TABLE OF CONTENTS:
    ----------------------------------------------------------------
    # Instructions
    # Reusable Functions
    # Shortcode Functions (are plugin territory)
    # Shortcode Definitions (outside the class)
    --------------------------------------------------------------*/

    /*--------------------------------------------------------------
    # Instructions
    --------------------------------------------------------------*/
    //SEE README

    /*--------------------------------------------------------------
    # Reusable Functions
    --------------------------------------------------------------*/


    /**
     * display content to logged OUT users only
     *
     * return only boolean, let no secure data escape like an array of all the roles
     *
     * @link https://wordpress.stackexchange.com/questions/5047/how-to-check-if-a-user-is-in-a-specific-role
     * @version 9.1.1028
     * @since 9.1.1028
     * @return true/false
     */
    private static function is_user_in_role( $user_id, $role  )
    {
        $user = get_userdata( $user_id );
        $role_array = empty( $user ) ? array() : $user->roles;
        return in_array( $role, $role_array );
    }



    /*--------------------------------------------------------------
    # Shortcode Functions (are plugin territory)
    --------------------------------------------------------------*/

    /**
     * display content to logged OUT users only
     *
     * @link
     * @version 9.1.1028
     * @since 0.1.181213
     */
    public static function visitor_content( $atts, $content = null )
    {

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

    /**
     * display content to logged IN users only
     *
     * may include any roles/abillities as well, displaying content to different roles
     *
     * @link
     * @version 9.1.1028
     * @since 0.1.181213
     */
    public static function member_content( $attr, $content = null )
    {

        extract( shortcode_atts( array( 'type' => 'read' ), $attr ) );
        //remove spaces
        $type = str_replace(" ", "", $type);
        $ability = explode(",", $type);
        $access_allowed = false;

        //not NULL and user is at least logged in
        if ( !is_null( $content ) && is_user_logged_in() )
        {
            //targetted users get this content
            foreach( $ability as $item )
            {
                if( strtolower($item) === 'any' )
                {
                    //ACTION
                    $access_allowed = true;
                }
                else if( self::is_user_in_role( get_current_user_id(), $item ) || current_user_can( $item ) )
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

}//class vi_plugin_member_content


/*--------------------------------------------------------------
# Shortcode Definitions
--------------------------------------------------------------*/
add_shortcode( 'vi-visitor', Array(  'vi_plugin_member_content', 'visitor_content' ) );
add_shortcode( 'vi-member', Array(  'vi_plugin_member_content', 'member_content' ) );
