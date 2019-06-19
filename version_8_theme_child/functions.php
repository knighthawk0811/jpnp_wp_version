<?php
/**
 * functions.php file for the version_8 child theme
 *
 * @link
 */

/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
# WP Theme child only functions
# WP Theme override functions
# WP Security features
# PHP Functions
# Shortcodes
--------------------------------------------------------------*/



/*--------------------------------------------------------------
# WP Theme child only functions
--------------------------------------------------------------*/
/**
 * REGISTER SCRIPTS AND STYLES
 * 
 * done early, can be overwritten by child theme
 * wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_register_script( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 * 
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
if ( ! function_exists( 'version_8_c_register_scripts' ) ) :
function version_8_c_register_scripts() {
	$parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
 
    wp_register_style( $parent_style, get_template_directory_uri() . '/style.css' );
	//this style sheet is the actual style for the site
	wp_register_style( 'version_8-style', get_stylesheet_directory_uri() . '/style.css', $parent_style , NULL , 'all' );

	//JS (non-AJAX)
	//included in header
	//wp_register_script( 'version_8-c-JS_head', get_template_directory_uri() . '/js/version_8_c_js_head.js', array('jquery'), false, true );	
	//included in footer
	//wp_register_script( 'version_8-c-JS_foot', get_template_directory_uri() . '/js/version_8_c_js_foot.js', array('jquery'), false, false );	
	
	//AJAX
	//wp_register_script( 'version_8-c-AJAX', get_template_directory_uri() . '/js/version_8_c_ajax.js', array('jquery'), false, true );
}
add_action( 'init', 'version_8_c_register_scripts' );
endif;
/**
 * ENQUEUE SCRIPTS AND STYLES
 * 
 * can be overwritten by child theme
 * wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 * 
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
if ( ! function_exists( 'version_8_c_enqueue_scripts' ) ) :
function version_8_c_enqueue_scripts() {	
	wp_enqueue_style( 'parent-style' );	
	//this style sheet is the actual style for the site
	wp_enqueue_style( 'version_8-style' );	

	//JS (non-AJAX)
	//included in header
	//wp_enqueue_script('version_8-c-JS_head');
	//included in footer
	//wp_enqueue_script('version_8-c-JS_foot');
	
	//AJAX
	//wp_enqueue_script('version_8-c-AJAX');
	// localize the script for proper AJAX functioning
	//_wp_localize_script( 'version_8-c-AJAX', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action( 'wp_enqueue_scripts', 'version_8_c_enqueue_scripts' );
endif;


/**
 * URL query parameters/variables
 *
 * @link
 * @param
 * @return
 * @uses
 */
if ( ! function_exists( 'version_8_c_add_query_param' ) ) :
function version_8_c_add_query_param($param) {
	$param[] = "surl"; // URl param
	return $param;
}
// hook version_6_add_query_param function into query_vars
add_filter('query_vars', 'version_8_c_add_query_param');
endif;

/**
 * home page show "front-page" category only
 * 
 * TODO: this needs to be a customizer thing
 *
 * @link 
 * @param
 * @return 
 * @uses 
 */
function version_8_home_page_special_queries($query)
{
	if($query->is_main_query() && $query->is_home())
	{
		$query->set('cat','3');
	}
}
add_action('pre_get_posts','version_8_home_page_special_queries');


/*--------------------------------------------------------------
# WP Theme override functions
--------------------------------------------------------------*/
/**
 * customizer options
 *
 * @link
 * @param
 * @return
 * @uses
 */
function version_8_customizer( $wp_customize ) {
	/*
	//header color
	$wp_customize->add_setting('header_background', array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
		'default' => '#000000',
		'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'sanitize_hex_color',
		'sanitize_js_callback' => '', // Basically to_json.
	) );
	$wp_customize->add_control( 'header_background', array(
		'type' => 'textbox',
		'priority' => 10, // Within the section.
		'section' => 'colors', // Required, core or custom.
		'label' => __( 'Header Background Color' ),
		'description' => __( 'The color behind the main slider should match the sliders color to prevent visible overlap.' ),
	) );
	$wp_customize->add_section( 'custom_css', array(
		'title' => __( 'INMA Custom Options' ),
		'description' => __( 'Change Theme specific Options here.' ),
		'panel' => '', // Not typically needed.
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	) );
	//*/
}
//add_action( 'customize_register', 'version_8_c_customizer' );
function version_8_customize_css()
{
    ?>
		<style type="text/css">
        	#masthead,
			#colophon {
				background:<?php echo get_theme_mod('header_background', '#000000'); ?>;
			}
		</style>
    <?php
}
//add_action( 'wp_head', 'version_8_c_customize_css');


if ( ! function_exists( 'version_8_theme_support' ) ) :
function version_8_theme_support()
{
	add_theme_support( 'custom-background', array(
		'default-color'          => '',
		'default-image'          => '',
		'default-repeat'         => 'repeat',
		'default-position-x'     => 'left',
	    'default-position-y'     => 'top',
	    'default-size'           => 'auto',
		'default-attachment'     => 'scroll',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	) );

	add_theme_support( 'custom-header', array(
		'default-image'          => get_template_directory_uri() . '/image/banner_main.png',
		'width'                  => 1800,
		'height'                 => 1000,
		'flex-height'            => true,
		'flex-width'             => true,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => true,
		'default-text-color'     => '#ffffff',
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	) );

	add_theme_support( 'custom-logo', array(
		'height'      => 140,
		'width'       => 380,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	add_theme_support( 'post-thumbnails' );
}
endif;
add_action( 'after_setup_theme', 'version_8_theme_support' );

//need style in visual editor?
//must create an editor.css file for this to operate. keep i nming the body tag issue
function version_8_editor_styles() {
    add_editor_style();
}
//add_action( 'init', 'version_8_c_editor_styles' );

/**
 * run shortcode inside text widgets
 *
 * @link https://dannyvankooten.com/enabling-shortcodes-in-widgets-quick-wordpress-tip/
 */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);


//change title for 404 pages
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


/**
 * register multiple menus
 *
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */
if ( ! function_exists( 'version_8_menu_setup' ) ) :
function version_8_menu_setup() {
	// This theme uses wp_nav_menu()
		//'ID' => esc_html__( 'Visible Name', 'version_8' ),
	register_nav_menus( array(
		'mobile-1' => __( 'Mobile 1 [MAIN]', 'version_8' ),
		'mobile-2' => __( 'Mobile 2', 'version_8' ),
		'mobile-3' => __( 'Mobile 3', 'version_8' ),
		'desktop-1' => __( 'Desktop 1 [MAIN]', 'version_8' ),
		'desktop-2' => __( 'Desktop 2', 'version_8' ),
		'desktop-3' => __( 'Desktop 3', 'version_8' ),
	) );
}
endif; // version_8_c_menu_setup
add_action( 'after_setup_theme', 'version_8_menu_setup' );


/**
 * Changes 'Username' to 'Email Address' on wp-admin login form
 * and the forgotten password form
 *
 * @link https://wpartisan.me/tutorials/wordpress-how-to-change-the-text-labels-on-login-and-lost-password-pages
 * @since 20180919
 * @version 20180919
 * @return null
 */
if ( ! function_exists( 'version_8_login_head' ) ) :
function version_8_login_head() 
{
    function version_8_c_username_label( $translated_text, $text, $domain ) 
    {
        if ( 'Username or E-mail:' === $text || 'Username' === $text || 'Username or Email Address' === $text) 
        {
            $translated_text = __( 'Email Address' , 'version_8' );
        }
        return $translated_text;
    }
    add_filter( 'gettext', 'version_8_c_username_label', 20, 3 );
    add_filter( 'ngettext', 'version_8_c_username_label', 20, 3 );
}
add_action( 'login_head', 'version_8_login_head' );
endif;


/*--------------------------------------------------------------
# WP Security features
--------------------------------------------------------------*/

/*--------------------------------------------------------------
# PHP Functions
--------------------------------------------------------------*/

/*--------------------------------------------------------------
# Shortcodes (are plugin territory, go there)
--------------------------------------------------------------*/




