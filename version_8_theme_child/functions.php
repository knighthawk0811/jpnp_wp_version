<?php
/**
 * functions.php file for the version_8_child theme
 * this is a child theme, be careful about function overwrites
 *
 * @link
 */

/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
# WP Theme child only functions
# WP Theme override functions
--------------------------------------------------------------*/



/*--------------------------------------------------------------
# WP Theme child only functions
--------------------------------------------------------------*/

/**
 * URL query parameters/variables
 *
 * @link
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_add_query_param' ) ) :
function version_8_add_query_param($param) {
	$param[] = "surl"; // URl param
	return $param;
}
// hook version_6_add_query_param function into query_vars
add_filter('query_vars', 'version_8_add_query_param');
endif;

/**
 * home page show "front-page" category only
 * 
 * TODO: this needs to be a customizer thing
 *
 * @link 
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_home_page_special_queries' ) ) :
function version_8_home_page_special_queries($query)
{
	if($query->is_main_query() && $query->is_home())
	{
		$query->set('cat','3');
	}
}
//add_action('pre_get_posts','version_8_home_page_special_queries');
endif;

/**
 * need style in visual editor?
 * must create an editor.css file for this to operate. 
 * there's a body tag issue
 *
 * @link 
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_editor_styles' ) ) :
function version_8_editor_styles() {
	add_editor_style();
}
//add_action( 'init', 'version_8_editor_styles' );
endif;	

/**
 * change title for 404 pages
 *
 * @link 
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_filter_wp_title' ) ) :
function version_8_filter_wp_title( $title )
{
	if ( is_404() )
	{
		$title = 'Search | ' . get_bloginfo('name') ;
	}
	// You can do other filtering here, or
	// just return $title
	return $title;
}
add_filter( 'wp_title', 'version_8_filter_wp_title', 10 );
endif;	

/**
 * Changes 'Username' to 'Email Address' on wp-admin login form
 * and the forgotten password form
 *
 * @link https://wpartisan.me/tutorials/wordpress-how-to-change-the-text-labels-on-login-and-lost-password-pages
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_login_head' ) ) :
function version_8_login_head() 
{
	function version_8_username_label( $translated_text, $text, $domain ) 
	{
		if ( 'Username or E-mail:' === $text || 'Username' === $text || 'Username or Email Address' === $text) 
		{
			$translated_text = __( 'Email Address' , 'version_8' );
		}
		return $translated_text;
	}
	add_filter( 'gettext', 'version_8_username_label', 20, 3 );
	add_filter( 'ngettext', 'version_8_username_label', 20, 3 );
}
add_action( 'login_head', 'version_8_login_head' );
endif;


/*--------------------------------------------------------------
# WP Theme override functions
--------------------------------------------------------------*/

/**
 * REGISTER SCRIPTS AND STYLES
 * 
 * done early, can be overwritten by child theme
 * wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_register_script( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 * 
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_register_scripts' ) ) :
function version_8_register_scripts() {
	$parent_style = 'version_8-style_foundation'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.	 
	wp_register_style( $parent_style, get_template_directory_uri() . '/style.css' );
	//this style sheet is the actual style for the site
	wp_register_style( 'version_8-style', get_stylesheet_directory_uri() . '/style.css', $parent_style , NULL , 'all' );

	//JS (non-AJAX)
	//included in header
	//wp_register_script( 'version_8-JS_head', get_template_directory_uri() . '/js/version_8_js_head.js', array('jquery'), false, true );	
	//included in footer
	//wp_register_script( 'version_8-JS_foot', get_template_directory_uri() . '/js/version_8_js_foot.js', array('jquery'), false, false );	

	//AJAX
	//wp_register_script( 'version_8-AJAX', get_template_directory_uri() . '/js/version_8_ajax.js', array('jquery'), false, true );
}
add_action( 'init', 'version_8_register_scripts' );
endif;
/**
 * ENQUEUE SCRIPTS AND STYLES
 * 
 * can be overwritten by child theme
 * wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 * 
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 8.3.1906
 * @since 8.3.1906
 * 
 */
if ( ! function_exists( 'version_8_c_enqueue_scripts' ) ) :
function version_8_enqueue_scripts() {	
	wp_enqueue_style( 'version_8-style_foundation' );	
	//this style sheet is the actual style for the site
	wp_enqueue_style( 'version_8-style' );	

	//JS (non-AJAX)
	//included in header
	//wp_enqueue_script('version_8-JS_head');
	//included in footer
	//wp_enqueue_script('version_8-JS_foot');
	
	//AJAX
	//wp_enqueue_script('version_8-AJAX');
	// localize the script for proper AJAX functioning
	//_wp_localize_script( 'version_8-AJAX', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action( 'wp_enqueue_scripts', 'version_8_enqueue_scripts' );
endif;
	
