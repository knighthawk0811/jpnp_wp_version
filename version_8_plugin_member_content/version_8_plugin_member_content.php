<?php
/*
Plugin Name: Version 8 Plugin: Member Content
Plugin URI: http://neathawk.us
Description: A collection of generic functions that separate content by visitor/member/ member of type
Version: 0.1.20181213
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class version_8_plugin_member_content {
    /*--------------------------------------------------------------
    >>> TABLE OF CONTENTS:
    ----------------------------------------------------------------
    # Reusable Functions
    # Shortcode Functions (are plugin territory)
    --------------------------------------------------------------*/


    /*--------------------------------------------------------------
    # Reusable Functions
    --------------------------------------------------------------*/
    //nothing to see here


    /*--------------------------------------------------------------
    # Shortcode Functions (are plugin territory)
    --------------------------------------------------------------*/

    /**
     * display content to logged OUT users only
     *
     * @link
     * @requires
     * @version 0.1.181213
     */
    public static visitor_content( $atts, $content = null )
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

    /**
     * display content to logged IN users only
     *
     * may include any roles as well, displaying content to different roles
     *
     * @link
     * @requires
     * @version 0.1.181213
     */
    public static function member_content( $attr, $content = null )
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

}//class version_8_plugin_member_content

add_shortcode( 'vip_visitor', Array(  'version_8_plugin_member_content', 'visitor_content' ) );
add_shortcode( 'vip_member', Array(  'version_8_plugin_member_content', 'member_content' ) );

//backward compatability
add_shortcode( 'visitor', Array(  'version_8_plugin_member_content', 'visitor_content' ) );
add_shortcode( 'member', Array(  'version_8_plugin_member_content', 'member_content' ) );

