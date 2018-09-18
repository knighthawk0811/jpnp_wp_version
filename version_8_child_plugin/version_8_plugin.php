<?php
/*
Plugin Name: version_8_child_plugin
Plugin URI: http://neathawk.us
Description: A collection of generic functions that are specific to this site
Version: 2018.09.10 - 0.2
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
--------------------------------------------------------------*/


/*--------------------------------------------------------------
# define default variables
--------------------------------------------------------------*/
define( SITE_PLUGIN_VERSION, '0.2' );
define( SITE_PLUGIN_VERSION_DB, '0.2' );


/*--------------------------------------------------------------
# Generic Plugin Functions
--------------------------------------------------------------*/

/*--------------------------------------------------------------
# Generic PHP functions
--------------------------------------------------------------*/

/*--------------------------------------------------------------
# Shortcodes (are plugin territory)
--------------------------------------------------------------*/


/**
 * CEAC - output a list of links to this months posts (magazine stories)
 *
 * @deprecated as of August 2018 after new design changes made individual posting of articles obsolete
 */
if ( ! function_exists( 'site_display_monthly_story' ) ) :
function site_display_monthly_story()
{
    /*
    [site_display_monthly_story]
    ******
    no options
    ******
    //*/
    $transient_name = 'site_cache_monthy_story';
    if(false === ($month_list = get_transient($transient_name)))
    {
        // It wasn't there, so regenerate the data and save the transient

        $month_list = '';
        //get the current month
        $time_now = date('Y-m-d G:i:s');
        $time_month_working = date('m', strtotime($time_now));
        $time_month_past = 0;

        $found = false;
        while(!$found)
        {
            //get the most recent posts (minus a few categories)
            $post_array = get_posts( array(
                'post_status'=>'publish',
                'numberposts' => 35,
                'category' => '-14,-17,-288',
                'orderby'    => 'date',
                'sort_order' => 'desc'
            ) );

            if(date('m',strtotime($post_array[1]->post_date)) == $time_month_working)
            {
                $found = true;
            }
            else
            {
                $time_month_working = date('m', strtotime('-' . ++$time_month_past . ' months'));
            }

        }

        if(is_array($post_array))
        {
            //cycle all posts found
            foreach($post_array as $item)
            {
                //only use the curernt month's posts
                if(date('m',strtotime($item->post_date)) == $time_month_working)
                {
                    //output a link with the title of the post
                    $month_list .= '<p><a href="' . $item->guid . '" title="' . $item->post_title . '">' . $item->post_title . '</a></p>';
                }
                else
                {
                    //free memory
                    $item = NULL;
                }
            }
        }
        //free memory
        $post_array = NULL;
        unset($post_array);

        set_transient($transient_name, $month_list, 60 * MINUTE_IN_SECONDS );
    }
    //output
    return $month_list;
}
add_shortcode( 'site_display_monthly_story', 'site_display_monthly_story' );
endif; // function



/**
 * CEAC - output a list of nametags for an event
 *
 * @param
 * @shortcode site_print_nametag
 */
if ( ! function_exists( 'site_display_nametag' ) ) :
function site_display_nametag( $attr )
{

    /*
    [site_print_nametag product="product_number"]
    [site_print_nametag product="product_number, product_number"]
    //*/
    global $wpdb;
    $order_item_id = null;
    $post_id = null;
    $user_id = null;
    $user_meta = null;
    $output = '';

    //get input
    extract( shortcode_atts( array( 'product' => '' ), $attr ) );
    //remove spaces, and build array
    $product = explode(',', str_replace(' ', '', $product));
    //validate input
    foreach( $product as $key => &$value )
    {
        if( !is_numeric( $value ) )
        {
            //$product[$key] = null;
            unset( $product[$key] );
        }
    }
    //get the things
    if( sizeof( $product >= 1 ) )
    {
        //use the product ids to get to the next WC level which is the order ids of the order
        foreach( $product as $key => &$value )
        {
            //gets a 2D array of the target value
            $temp[$value] = $wpdb->get_results(
                $wpdb->prepare(
                    "
                    SELECT order_item_id FROM {$wpdb->prefix}woocommerce_order_itemmeta
                    WHERE meta_key = '_product_id'
                    AND meta_value = %s
                    ",
                        array(
                        $value
                    )
            ), ARRAY_A );

            //I'm just looking for the targetted value, forget the rest
            if( sizeof( $temp[$value] >= 1 ) )
            {
                foreach($temp[$value] as $target_order_item_id )
                {
                    $order_item_id[] = $target_order_item_id['order_item_id'];
                }
            }
        }
        unset( $temp );

        //now we have the order ids
        //the next WC level uses this to get the post ids
        foreach( $order_item_id as $key => &$value )
        {
            //gets a 2D array of the target value
            $temp[$value] = $wpdb->get_results(
                $wpdb->prepare(
                    "
                    SELECT order_id FROM {$wpdb->prefix}woocommerce_order_items
                    WHERE order_item_id = %s
                    ",
                        array(
                        $value
                    )
            ), ARRAY_A );

            //I'm just looking for the targetted value, forget the rest
            if( sizeof( $temp[$value] >= 1 ) )
            {
                foreach($temp[$value] as $target_post_id )
                {
                    $post_id[] = $target_post_id['order_id'];
                }
            }
        }
        unset( $temp );

        //now we have the post ids
        //the next WC level uses this to get the user ids
        foreach( $post_id as $key => &$value )
        {
            //gets a 2D array of the target value
            $temp[$value] = $wpdb->get_results(
                $wpdb->prepare(
                    "
                    SELECT meta_value FROM {$wpdb->prefix}postmeta
                    WHERE post_id = %s
                    AND meta_key = '_customer_user'
                    ",
                        array(
                        $value
                    )
            ), ARRAY_A );

            //I'm just looking for the targetted value, forget the rest
            if( sizeof( $temp[$value] >= 1 ) )
            {
                foreach($temp[$value] as $target_user_id )
                {
                    $user_id[$target_user_id['meta_value']] = $target_user_id['meta_value'];
                }
            }
        }
        unset( $temp );

        //now we have the user ids
        //now we can get all the things
        foreach( $user_id as $key => &$value )
        {
            //$key is the user_id
            $temp[$key] = $wpdb->get_results(
                $wpdb->prepare(
                    "
                    SELECT * FROM {$wpdb->prefix}usermeta
                    WHERE user_id = %s
                    ",
                        array(
                        $key
                    )
            ), ARRAY_A );

            //I'm just looking for the targetted values, not every entire row contents
            if( sizeof( $temp[$value] >= 1 ) )
            {
                foreach($temp[$key] as $target_user_id )
                {
                    $user_meta[$key][$target_user_id['meta_key']] = $target_user_id['meta_value'];
                }
            }
        }
        unset( $temp );
    }

    //output the things
    if( sizeof( $user_meta >= 1 ) )
    {
        foreach( $user_meta as &$user )
        {
            $output .= '<div>';
            $output .= '<p>' . $user['first_name'] . '</p>';
            $output .= '<p>' . $user['last_name'] . '</p>';
            $output .= '<p>' . $user['ceac_company_name'] . '</p>';
            //todo: make the member type actually do the right thing
            //first 3 checks reference the old / quick user data
            if( !empty( $user['ceac_board_member'] ) )
            {
                $output .= '<p>The Chief Engineers Association</p>';
            }
            else if( $user['ceac_status_select'] == "1" )
            {
                $output .= '<p>Member Status Active</p>';
            }
            else if( $user['ceac_status_select'] == "2" )
            {
                $output .= '<p>Member Status Associate</p>';
            }
            else
            {
                //now comes the hard work
                //
                $output .= '<p>Guest</p>';
            }
            $output .= '</div>';

        }
    }


    //$output .= site_var_dump_return($product);
    //$output .= site_var_dump_return($order_item_id);
    //$output .= site_var_dump_return($post_id);
    //$output .= site_var_dump_return($user_id);
    //$output .= site_var_dump_return($user_meta);

    //return "<pre>$output</pre>";
    return $output;
}
add_shortcode( 'site_print_nametag', 'site_display_nametag' );
endif;
/*--------------------------------------------------------------
# Woocommerce Customization
--------------------------------------------------------------*/