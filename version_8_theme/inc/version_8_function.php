<?php
/**
 * Keep extra clutter out of the functions.php file.
 *
 * @link
 */

/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
# WP Theme agnostic functions
# WP Theme dependant functions
# WP Security features
# PHP Functions
# Shortcodes
--------------------------------------------------------------*/



/*--------------------------------------------------------------
# WP Theme agnostic functions
--------------------------------------------------------------*/
/**
 * ENQUEUE SCRIPTS AND STYLES
 * 1)put this into the functions.php file and replace the enqueue script function
 * 2)create a new style-v7.css file with the true theme style
 * 3)uncomment the add_action line
 * 4)require get_template_directory() . '/inc/version_8_function.php';
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
if ( ! function_exists( 'version_8_scripts' ) ) :
function version_8_scripts() {
	//first style sheet is the foundation from _s
	wp_enqueue_style( 'foundation-style', get_stylesheet_uri() );

	//last style sheet is the actual style for the site
	wp_register_style( 'version_8-style', get_stylesheet_directory_uri() . '/style-version_8.css', NULL , NULL , 'all' );
	wp_enqueue_style( 'version_8-style', get_stylesheet_directory_uri() . '/style-version_8.css' );

	wp_enqueue_script( 'version_8-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '201802', true );

	wp_enqueue_script( 'version_8-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '201802', true );

	//AJAX
	// register your script location, dependencies and version
	//wp_register_script( 'version_8-AJAX', get_template_directory_uri() . '/js/version_8_ajax.js', array('jquery'), false, true );
	// enqueue the script
	//wp_enqueue_script('version_8-AJAX');
	// localize the script for proper AJAX functioning
	//wp_localize_script( 'version_8-AJAX', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
//add_action( 'wp_enqueue_scripts', 'version_8_scripts' );
endif;

/**
 * parallelize-downloads-across-hostnames
 *
 * use only by itself and not with any other parallelize implementations
 *
 * @link https://stackoverflow.com/questions/34404336/how-to-parallelize-downloads-across-hostnames-on-wordpress
 * @param string $url (file name)
 * @param [, string $id unused]
 * @return string $url
 * @uses parallelize_get_hostname(), add_filter()
 */
function parallelize_hostnames($url, $id) {
	$hostname = parallelize_get_hostname($url); //call supplemental function
	$url = str_replace(parse_url(get_bloginfo('url'), PHP_URL_HOST), $hostname, $url);
	return $url;
}
/**
 * get a hostname from an array
 *
 * return a single hostname from an array, based on the input
 * same input will always return the same hostname
 *
 * @link https://stackoverflow.com/questions/34404336/how-to-parallelize-downloads-across-hostnames-on-wordpress
 * @param string $name (file name)
 * @return string $hostname
 * @uses
 */
function parallelize_get_hostname($name) {
	/*
	$subdomains = array('static1.domain.com','static2.domain.com');
	$host = abs(crc32(basename($name)) % count($subdomains));
	$hostname = $subdomains[$host];
	*/
	//single second domain
	$hostname = 'static1.domain.com';
	return $hostname;
}
//add_filter('wp_get_attachment_url', 'parallelize_hostnames', 10, 2);

/**
 * AJAX action
 *
 * WP AJAX callback function to run php code and send a result to JS
 *
 * @link
 * @param
 * @return
 * @uses sanitize_text_field
 */
if ( ! function_exists( 'version_8_generic_ajax_callback' ) ) :
function version_8_generic_ajax_callback( $action = '', $param0 = '', $param1 = '', $param2 = '', $param3 = '' )
{
	//js version_8_generic_ajax()
	//parameters are in the $_POST

	if( !empty( $_POST['action'] ) )
	{
		$action = sanitize_text_field( $_POST['action'] );
	}
	if( !empty( $_POST['param0'] ) )
	{
		$param0 = sanitize_text_field( $_POST['param0'] );
	}
	if( !empty( $_POST['param1'] ) )
	{
		$param1 = sanitize_text_field( $_POST['param1'] );
	}
	if( !empty( $_POST['param2'] ) )
	{
		$param2 = sanitize_text_field( $_POST['param2'] );
	}
	if( !empty( $_POST['param3'] ) )
	{
		$param3 = sanitize_text_field( $_POST['param3'] );
	}

	//@session_start();
	//global $wpdb;

	//do stuff
	$output = 'test';
	echo( 'Select:' . ',' . $param2 . ',' . $param3 . ';' );
	echo( $param1 . ',' . $param2 . ',' . $param3 . ';' );

	die();
}
endif;
add_action( 'wp_ajax_nopriv_version_8_generic_ajax_callback', 'version_8_generic_ajax_callback' );
add_action( 'wp_ajax_version_8_generic_ajax_callback', 'version_8_generic_ajax_callback' );

/**
 * URL query parameters/variables
 *
 * @link
 * @param
 * @return
 * @uses
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
 * enable jquery from inside wordpress if it's not already enabled
 *
 */
if ( ! function_exists( 'insert_jquery' ) ) :
function insert_jquery(){
	wp_enqueue_script('jquery');
}
//add_action('init', 'insert_jquery');
endif; // insert_jquery

/**
 * jQuery Insert From Google
 * just use https always (sometimes error with flex SSL)
 *
 * @link https://css-tricks.com/snippets/wordpress/include-jquery-in-wordpress-theme/
 */
if ( ! function_exists( 'google_jquery_enqueue' ) ) :
function google_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}
//if (!is_admin()) add_action("wp_enqueue_scripts", "google_jquery_enqueue", 11);
add_action("wp_enqueue_scripts", "google_jquery_enqueue", 11);
endif; // google_jquery_enqueue


/*--------------------------------------------------------------
# WP Theme dependant functions
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
//add_action( 'customize_register', 'version_8_customizer' );
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
//add_action( 'wp_head', 'version_8_customize_css');


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
//add_action( 'init', 'version_8_editor_styles' );

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
endif; // version_8_menu_setup
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
# WP Security features
--------------------------------------------------------------*/

//remove update nag for wordpress versions
//usefull when there are other admins and we really don't want them to clicky things they no should be touchy
if ( ! function_exists( 'version_8_remove_update_nag' ) ) :
function version_8_remove_update_nag() {
	?>
        <style type="text/css">
			.update-nag {
				display:none;
			}
		</style>
    <?php
}
endif; // remove_update_nag
//add_action( 'admin_head', 'remove_update_nag' );

//hide admin bar from those who cannot write
function version_8_hide_admin_from_viewers( )
{
	if( !current_user_can('publish_posts') )
	{
		show_admin_bar(false);
	}
}
//add_filter( 'after_setup_theme' , 'hide_admin_from_viewers' );

//remove the function "wp.getUsersBlogs" to avoid brute force attacks popular 2014-07
//a small plugin has covered this function, but it is left here as memorial
function version_8_remove_unneeded_XMLRPC( $methods ) {
    unset( $methods['wp.getUsersBlogs'] );
    return $methods;
}
//add_filter( 'xmlrpc_methods', 'remove_unneeded_XMLRPC' );


if (!current_user_can('manage_options'))
{
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
}

//hide profile fields with jquery
//not the most secure, but relatively effective for the average user
function version_8_jquery_remove_profile_fields()
{
	if (is_page('your-profile'))
	{
		?>
		<script type="text/javascript">
		jQuery(document).ready(function() {
			<?php //password note ?>
			jQuery("h3:contains('Account Management')").next('.form-table').find("tbody").append('<tr><td colspan="99" style="font-size:small;">If you would like to change your password a new one will be automatically generated for you. You can also type in your own password if you choose.</td><tr>');
			jQuery("h3:contains('Account Management')").next('.tml-form-table').find("tbody").append('<tr><td colspan="99" style="font-size:small;">If you would like to change your password a new one will be automatically generated for you. You can also type in your own password if you choose.</td><tr>');
			jQuery("h3:contains('Account Management')").html('Password');

			<?php //nickname is automatic ?>
			//jQuery("input#nickname").val(jQuery("input#user_login").val());
			//jQuery("tr.tml-nickname-wrap").hide();
			//jQuery("tr.nickname-wrap").hide();

			<?php if (!current_user_can('manage_options')):?>
				<?php //ALL non-admins ?>
				<?php //toolbar/color options ?>
				jQuery("h3:contains('Personal Options')").next('.form-table').hide();
				jQuery("h3:contains('Personal Options')").next('.tml-form-table').hide();
				jQuery("h3:contains('Personal Options')").hide();

				jQuery("h3:contains('Name')").hide();
				jQuery("h3:contains('Contact Info')").next('.form-table').find("tr:contains(Website)").hide();
				jQuery("h3:contains('Contact Info')").next('.tml-form-table').find("tr:contains(Website)").hide();
				jQuery("h3:contains('Contact Info')").next('.form-table').find("label:contains(Events Manager)").html('Phone');
				jQuery("h3:contains('Contact Info')").next('.tml-form-table').find("label:contains(Events Manager)").html('Phone');
				//jQuery("p.indicator-hint").hide();

				jQuery('table.admin-info').hide();
				jQuery("h3:contains('Admin Information')").hide();

				jQuery("h3").hide();
			<?php endif; ?>
		})
		</script>
		<?php
	}
}
//add_action( 'wp_footer', 'jquery_remove_profile_fields');


//when adding a new user, redirect to edit their profile immediately so you can access their extra fields
function version_8_redirect_on_user_add( $user_id )
{
	if(!empty($user_id))
	{
		wp_redirect( admin_url("/user-edit.php?user_id=".$user_id) );
	}
}
//add_action( 'user_register', 'redirect_on_user_add', 10, 1 );


/*--------------------------------------------------------------
# PHP Functions
--------------------------------------------------------------*/

function site_var_dump_pre($mixed = NULL, $label = NULL)
{
	if(is_string($label)){$label .= ': ';}else{$label = '';}
	echo '<pre>' . $label . "\n";
	var_dump($mixed);
	echo '</pre>';
	return NULL;
}
function site_var_dump_return($mixed = NULL)
{
	ob_start();
	var_dump($mixed);
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

if ( ! function_exists( 'version_8_view_access' ) ) :
function version_8_view_access($level = 0)
{
	//define page IDs
	$access[0] = 258; // access denied
	$access[1] = 286; // access not yer granted
	$access[2] = 209; // access must be logged in
	$access[3] = 324; // access zero attempts remaining

	//if set to predefined value which corresponds to pages
	if( !isset($access[intval($level)]) )
	{
		//default is to deny access
		$level = 0;
	}

	//display the selected page contents
	$the_query = new WP_Query( 'page_id=' . $access[$level] );
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		//the_content();
		get_template_part( 'template-parts/content', 'page' );
	endwhile;
	wp_reset_postdata();
}
endif;

if ( ! function_exists( 'version_8_get_thumbnail' ) ) :
function version_8_get_thumbnail($id)
{
	//return value
	$the_post_thumbnail = '';

	//new loop
	$query2 = new WP_Query( array( 'p' => $id ) );
	if ( $query2->have_posts() )
	{
		// The 2nd Loop
		while ( $query2->have_posts() )
		{
			//setup post
			$query2->the_post();
			//echo '<li>' . get_the_title( $query2->post->ID ) . '</li>';
			//already have a thumbnail? use that one
			if(has_post_thumbnail($query2->post->ID))
			{
				$the_post_thumbnail = get_the_post_thumbnail($query2->post->ID, 'thumbnail');
			}
			else
			{
				//no thumbnail set, then grab the first image
				ob_start();
				ob_end_clean();
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $query2->post->post_content, $matches);
				$the_post_thumbnail_url = $matches[1][0];

				//set a default image inside the theme folder
				if(empty($the_post_thumbnail_url))
				{
					$the_post_thumbnail_url = get_stylesheet_directory_uri() ."/image/default_thumbnail.png";
				}
				$the_post_thumbnail = '<img src="' . $the_post_thumbnail_url .'" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" width="150" height="150" />';
			}
		}
		// Restore original Post Data
		wp_reset_postdata();
	}

	return $the_post_thumbnail;
}
endif;
if ( ! function_exists( 'version_8_get_thumbnail_url' ) ) :
function version_8_get_thumbnail_url($id)
{
	//return value
	$the_post_thumbnail_url = '';

	//new loop
	$query2 = new WP_Query( array( 'p' => $id ) );
	if ( $query2->have_posts() )
	{
		// The 2nd Loop
		while ( $query2->have_posts() )
		{
			//setup post
			$query2->the_post();
			//echo '<li>' . get_the_title( $query2->post->ID ) . '</li>';
			//already have a thumbnail? use that one
			if(has_post_thumbnail($query2->post->ID))
			{
				ob_start();
				the_post_thumbnail_url('full');
				$the_post_thumbnail_url = ob_get_contents();
				ob_end_clean();
			}
			else
			{
				//no thumbnail set, then grab the first image
				ob_start();
				ob_end_clean();
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $query2->post->post_content, $matches);
				$the_post_thumbnail_url = $matches[1][0];

				//set a default image inside the theme folder
				if(empty($the_post_thumbnail_url))
				{
					$the_post_thumbnail_url = get_stylesheet_directory_uri() ."/image/default_thumbnail.png";
				}
			}
		}
		// Restore original Post Data
		wp_reset_postdata();
	}

	return $the_post_thumbnail_url;
}
endif;


/**
 * Translates a number to a short alphanumeric version
 *
 * Translated any number up to 9007199254740992 to a shorter version in letters
 * e.g.: 9007199254740989 --> PpQXn7COf
 *
 * this function is based on alphaID by
 * kevin[at]vanzonneveld[dot]net
 * @link http://kvz.io/blog/2009/06/10/create-short-ids-with-php-like-youtube-or-tinyurl/
 *
 * @author    Joseph Neathawk
 * @copyright 2017 Joseph Neathawk (http://neathawk.us)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   0.1.0
 *
 * @param mixed   $input    String or long input to translate
 * @param boolean $decode   Reverses translation when true (default is to convert a number to a shortened string)
 * @param mixed   $padding  Number or boolean padds the result up to a specified min length
 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 *
 */
if ( ! function_exists( 'version_8_url_short' ) ) :
function version_8_url_short($input, $decode = false, $padding = 8, $pass_key = null)
{
	$output = '';
	//list of characters that may be included in the output
	$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	//base unit
	$base = strlen($index);
	if($padding < 8)
	{
		$padding = 8;
	}

	//will reshuffle the $index using the $pass_key
	if($pass_key !== null)
	{
		/* classic version
		for ($n = 0; $n < strlen($index); $n++)
		{
			$i[] = substr($index, $n, 1);
		}//*/
		//split $index string into array of single characters
		$i = str_split($index,1);

		$pass_hash = hash('sha256',$pass_key);
		$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		//* classic version required to keep $i and $p the same length
		for ($n = 0; $n < strlen($index); $n++)
		{
			$p[] = substr($pass_hash, $n, 1);
		}//*/
		//split $pass_hash string into array of single characters
		//$p = str_split($pass_hash,1);

		//sort $p descending, and also sort $i in the corresponding order
		//(every sort change made in $p will be made in $i and $i will not be in desc order afterward)
		array_multisort($p, SORT_DESC, $i);
		//put the re-arranged $i back into the $index
		$index = implode($i);
	}

	if($decode)
	{
		//DECODE
		// Digital number  <<--  alphabet letter code
		$len = strlen($input) - 1;

		for ($t = $len; $t >= 0; $t--)
		{
			$bcp = bcpow($base, $len - $t);
			$output = $output + strpos($index, substr($input, $t, 1)) * $bcp;
		}

		if (is_numeric($padding))
		{
			$padding--;

			if ($padding > 0)
			{
				$output -= pow($base, $padding);
			}
		}
	}
	else
	{
		//ENCODE
		// Digital number  -->>  alphabet letter code
		if (is_numeric($padding))
		{
			$padding--;

			if ($padding > 0)
			{
				$input += pow($base, $padding);
			}
		}

		for ($t = ($input != 0 ? floor(log($input, $base)) : 0); $t >= 0; $t--)
		{
			$bcp = bcpow($base, $t);
			$a   = floor($input / $bcp) % $base;
			$output = $output . substr($index, $a, 1);
			$input  = $input - ($a * $bcp);
		}
	}

  	return $output;
}
endif;


/*--------------------------------------------------------------
# Shortcodes (are plugin territory, go there)
--------------------------------------------------------------*/




