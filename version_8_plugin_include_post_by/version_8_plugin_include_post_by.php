<?php
/*
Plugin Name: version_8_plugin_include_post_by
Plugin URI: http://neathawk.us
Description: A collection of shortcodes to include posts inside othe rposts, etc
Version: 0.1.181212
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/

//TODO: not yet self contained

class version_8_plugin_include_post_by {

	/**
	 * include post by ID
	 *
	 * @version 0.1.181212
	 */
	private static function version_8_include_post_by_id( $attr )
	{
	    /*
	    ***************************************************************************
	    [site_include_post_by_id id="123" display="title,link,meta,thumbnail,content,excerpt,all"]
	        //no content is used here, so no closing tag required
	    [/site_include_post_by_id]
	    ***************************************************************************
	    id = post to be shown
	    display = display options CSV
	    ***************************************************************************
	    //*/

	    //TODO: add thumbnail 


	    $post_object = null;
	    $output = '';

	    //get input
	    extract( shortcode_atts( array( 'id' => NULL,'display' => 'all' ), $attr ) );
	    //remove spaces, and build array
	    $display_option = explode(',', str_replace(' ', '', $display));
	    //validate input
	    foreach( $display_option as $key => &$value )
	    {
	        switch( $value )
	        {
	            case 'title':
	                $display_option['title'] = true;
	                break;
	            case 'link':
	                $display_option['link'] = true;
	                break;
	            case 'meta':
	                $display_option['meta'] = true;
	                break;
	            case 'thumbnail':
	                $display_option['thumbnail'] = true;
	                break;
	            case 'content':
	                $display_option['content'] = true;
	                break;
	            case 'excerpt':
	                $display_option['excerpt'] = true;
	                break;
	            case 'all':
	                $display_option['title'] = true;
	                $display_option['link'] = true;
	                $display_option['meta'] = true;
	                $display_option['thumbnail'] = true;
	                $display_option['content'] = true;
	                $display_option['excerpt'] = false;//can't do both, that's crazy
	                break;
	            default:
	                //any other values are garbage in
	                $value = null;
	                unset($display_option[$key]);
	        }
	    }


	    //get the data
	    if( is_numeric( $id) )
	    {

	        //obstream
	        ob_start();
	        //setup post
	        $args = array(
	            'p' => $id
	            );

	        $the_posts = new WP_Query($args);
	        //normal output the post stuff
	        if ( $the_posts->have_posts() )
	        {
	            while( $the_posts->have_posts() )
	            {
	                $the_posts->the_post();//Iterate the post index in the loop.

	                if($display_option['title'])
	                {
	                    if($display_option['link'])
	                    {
	                        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	                    }
	                    else
	                    {
	                        the_title( '<h2 class="entry-title">', '</h2>' );
	                    }
	                }

	                if($display_option['meta'])
	                {
	                    echo('<div class="entry-meta">');
	                    version_8_posted_on();
	                    version_8_posted_by();
	                    echo('</div>');
	                    echo('<div class="entry-footer">');
	                    version_8_entry_footer();
	                    echo('</div>');
	                }

	                if($display_option['thumbnail'])
	                {
	                    if($display_option['link'])
	                    {
	                        echo('<a class="post-thumbnail" href="' . get_the_permalink() . '" >');
	                        echo(' ' . get_the_post_thumbnail($id, 'thumbnail'));
	                        echo('</a>');
	                    }
	                    else
	                    {
	                        echo('<div class="post-thumbnail">');
	                        echo(' ' . get_the_post_thumbnail($id, 'thumbnail'));
	                        echo('</div>');
	                    }
	                }

	                if($display_option['content'])
	                {
	                    echo('<div class="entry-content">');
	                    the_content();
	                    echo('</div>');
	                }
	                else if($display_option['excerpt'])
	                {
	                    echo('<div class="entry-content">');
	                    the_excerpt();
	                    echo('<a href="' . esc_url( get_permalink() ) . '">Continue Reading</a>');
	                    echo('</div>');
	                }
	            }
	            wp_reset_postdata();
	        }

	        //obstream to $output
	        $output = ob_get_contents();
	        ob_end_clean();
	    }
	    //return $output
	    return $output;
	}

	/**
	 * include post by category
	 * uses site_include_post_by_id
	 *
	 * @version 0.1.181212
	 */
	private static version_8_include_post_by_cat( $attr )
	{
	    /*
	    *************************************
	    [site_include_post_by_cat 
	        cat="123" 
	        order="ASC" 
	        orderby="title"
	        display="title,link,meta,thumbnail,content,excerpt,all"
	        pageinate=true
	        perpage="5" 
	        offset="0"
	    ]
	    *************************************
	    uses:    
	    [site_include_post_by_id id="123" display="title,link,meta,thumbnail,content,excerpt,all"]
	    *************************************
	    cat = category to be shown
	    order = sort order
	    orderby = what to sort by
	    display = from site_include_post_by_id
	    pageinate = true/false
	    perpage = items per page
	    offset = how many to skip, useful if you are combining multiple of these
	    *************************************
	    //*/
	    $output = '';
	    extract( shortcode_atts( array( 'cat' => NULL, 'order' => 'DESC', 'orderby' => 'date', 'display' => 'all', 'pageinate' => true, 'perpage' => 5, 'offset' => 0 ), $attr ) );


	    if ( !is_null( $cat ) && ( is_numeric( $cat ) || preg_match( '/^[0-9,]+$/', $cat ) ) && !is_feed() )
	    {
	        //pageinate
	        if ( $pageinate === 'false' ) $pageinate = false; // just to be sure...
	        $pageinate = (bool) $pageinate;

	        //perpage
	        if ( !is_null( $perpage ) && is_numeric( $perpage ) )
	        {
	            if( $perpage < 1 )
	            {
	                $perpage = -1;
	            }
	        }
	        else
	        {
	            $perpage = 5;
	        }

	        //order
	        if ( !is_null($order) && ($order != 'DESC' && $order != 'ASC'))
	        {
	            $order = 'DESC';
	        }

	        //orderby
	        if ( !is_null($orderby) && (preg_match('/^[a-zA-Z\_]+$/', $orderby) != 1))
	        {
	            $orderby = 'date';
	        }

	        //offest
	        $page_current = 1;
	        $offset = 0;
	        if(isset($_GET['pn']) && is_numeric($_GET['pn']))
	        {
	            $page_current = intval($_GET['pn']);
	            $offset = ($page_current - 1) * $perpage;
	            if($offset < 0)
	            {
	                $offset = 0;
	            }
	        }
	        else
	        {
	            $page_current = 1;
	        }

	        //count all posts
	        $post_count = 0;
	        $transient_name = 'site_' . md5($cat . $count . $order . $orderby) . '_c';
	        if(false === ($post_count = get_transient($transient_name)))
	        {
	            // It wasn't there, so regenerate the data and save the transient
	            $args = array(
	                'posts_per_page'   => -1,
	                'offset'           => 0,
	                'category'         => "$cat",
	                'orderby'          => "$orderby",
	                'order'            => "$order",
	                'post_type'        => 'post',
	                'post_status'      => 'publish',
	                );
	            $post_count = count(get_posts($args));
	            set_transient($transient_name, $post_count, 10 * MINUTE_IN_SECONDS );
	        }
	        //get content for just the current page
	        $transient_name = 'site_' . md5($cat . $count . $order . $orderby) . '_' . $page_current;
	        if(false === ($post_array = get_transient($transient_name)))
	        {
	            // It wasn't there, so regenerate the data and save the transient
	            $args = array(
	                'posts_per_page'   => $perpage,
	                'offset'           => $offset,
	                'category'         => "$cat",
	                'orderby'          => "$orderby",
	                'order'            => "$order",
	                'post_type'        => 'post',
	                'post_status'      => 'publish',
	                );
	            $post_array = get_posts($args);
	            set_transient($transient_name, $post_array, 10 * MINUTE_IN_SECONDS );
	        }

	        //display content
	        $output .= '<div class="' . get_category($cat)->slug . '">';
	        if(is_array($post_array) && count($post_array) > 0)
	        {
	            foreach($post_array as $item)
	            {
	                //call site_include_post_by_id();
	                $args = array(
	                    'id'       =>"$item->ID",
	                    'display'   =>"$display"
	                    );
	                $output .= version_8_plugin_include_post_by::version_8_include_post_by_id($args);
	            }


	//revision-line****************************************************************
	//problem: 
	            if($pageinate)
	            {
	                //paginate link back to previous/newer content
	                if($page_current > 1)
	                {
	                    $page_previous = $page_current - 1;
	                    $url_var = '?pn=';
	                    if($page_previous <= 1){$url_var = '';}else{$url_var .= $page_previous;}
	                    $output .= '<a style="clear:left;float:left;" href="' . esc_url(get_permalink()) . $url_var . '" title="Previous Page">Previous Page</a>';
	                }
	                //paginate link to next/older content
	                if(count($post_array) == $perpage)
	                {
	                    //is a link even needed?
	                    if(false === ($post_array_next = get_transient('cat_page_' . str_ireplace(',','_',$cat) . '__' . ($page_current + 1))))
	                    {
	                        // It wasn't there, so regenerate the data and save the transient
	                        $args = array(
	                            'posts_per_page'   => $perpage,
	                            'offset'           => ($page_current + 1) * $perpage,
	                            'category'         => "$cat",
	                            'orderby'          => "$orderby",
	                            'order'            => "$order",
	                            'post_type'        => 'post',
	                            'post_status'      => 'publish',
	                            );
	                        $post_array_next = get_posts($args);
	                        set_transient('cat_page_' . str_ireplace(',','_',$cat) . '__' . ($page_current + 1), $post_array_next, 10 * MINUTE_IN_SECONDS );
	                    }
	                    $count = count($post_array_next);
	                    if(count($count) > 0)
	                    {
	                        $output .= '<a style="clear:right;float:right;" href="' . esc_url(get_permalink()) . '?pn=' . ($page_current + 1) . '" title="Next Page">Next Page</a>';
	                    }
	                }
	                //paginate page numbers
	                if($post_count > $perpage)
	                {
	                    $output .= '<div style="height:40px; margin:0 auto; position:relative; width:220px; text-align:center;">';
	                    $page_count = intval(ceil($post_count / $perpage));
	                    $i = 1;
	                    $step = 0;
	                    if($page_count > 4 && $page_current > 1)
	                    {
	                        $i = $page_current - 1;
	                    }
	                    if($i > 1)
	                    {
	                        $link_extra_style = ' border:1px solid rgba(0,0,0,0); ';
	                        $output .= '<a style="display:inline-block; margin:3px; min-width:20px; padding:0 3px; background:rgba(0,0,0,0.25); ' . $link_extra_style . '" href="' . esc_url(get_permalink()) . '?pn=1" title="Page 1">1</a>';
	                        if($i > 2)
	                        {
	                            $output .= '...';
	                        }
	                    }
	                    for($i;$i <= $page_count; $i++)
	                    {
	                        $step++;
	                        if($step < 4 || $i == $page_count)
	                        {
	                            if($i == $page_count && $step > 3)
	                            {
	                                $output .= '...';
	                            }
	                            if($i == $page_current)
	                            {
	                                $link_extra_style = ' border:1px solid #000000; ';
	                            }
	                            else
	                            {
	                                $link_extra_style = ' border:1px solid rgba(0,0,0,0); ';
	                            }
	                            $output .= '<a style="display:inline-block; margin:3px; min-width:20px; padding:0 3px; background:rgba(0,0,0,0.25); ' . $link_extra_style . '" href="' . esc_url(get_permalink()) . '?pn=' . $i . '" title="Page ' . $i . '">' . $i . '</a>';
	                        }
	                    }
	                    $output .= '</div>';
	                }
	            }
	        }
	        $output .= '</div>';//close the category div tag
	    }
	    else
	    {
	        //do nothing
	    }

	    return $output;
	}


}


add_shortcode( 'include-post-by-id', Array(  'version_8_plugin_include_post_by', 'version_8_include_post_by_id' ) );
add_shortcode( 'include-post-by-cat', Array( 'version_8_plugin_include_post_by', 'version_8_include_post_by_cat' ) );

