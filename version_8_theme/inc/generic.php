<?php
/**
 * version_8 generic php functions
 *
 * @package version_8
 */



/**
 * parallelize-downloads-across-hostnames
 *
 * use only by itself and not with any other parallelize implementations
 *
 * @link https://stackoverflow.com/questions/34404336/how-to-parallelize-downloads-across-hostnames-on-wordpress
 * @version 8.3.1906
 * @since 8.3.1906
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
 * @version 8.3.1906
 * @since 8.3.1906
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
 * var_dump into a pre html element
 *
 * @link
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_var_dump_pre' ) ) :
function version_8_var_dump_pre($mixed = NULL, $label = NULL)
{
	if(is_string($label)){$label .= ': ';}else{$label = '';}
	echo '<pre>' . $label . "\n";
	var_dump($mixed);
	echo '</pre>';
	return NULL;
}
endif;
/**
* var_dump returned as a string
*
* @link
* @version 8.3.1906
* @since 8.3.1906
*/
if ( ! function_exists( 'version_8_var_dump_return' ) ) :
function version_8_var_dump_return($mixed = NULL)
{
	ob_start();
	var_dump($mixed);
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
endif;


/***********************
Google Material Icons
***********************/
/**
 * REGISTER SCRIPTS AND STYLES
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @link http://google.github.io/material-design-icons/
 * @version 8.3.1908
 * @since 8.3.1908
 */
if ( ! function_exists( 'version_8_register_marterial_icon_scripts' ) ) :
function version_8_register_marterial_icon_scripts() {

	wp_register_style( 'version_8-material_icon_style', 'https://fonts.googleapis.com/icon?family=Material+Icons', NULL , NULL , 'all' );

}
add_action( 'init', 'version_8_register_marterial_icon_scripts' );
endif;
/**
 * ENQUEUE SCRIPTS AND STYLES
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @link http://google.github.io/material-design-icons/
 * @version 8.3.1908
 * @since 8.3.1908
 *
 */
if ( ! function_exists( 'version_8_enqueue_marterial_icon_scripts' ) ) :
function version_8_enqueue_marterial_icon_scripts() {
	wp_enqueue_style( 'version_8-material_icon_style' );
}
add_action( 'wp_enqueue_scripts', 'version_8_enqueue_marterial_icon_scripts' );
endif;


/***********************
BEGIN prettyphoto lightbox
***********************/
/**
 * REGISTER SCRIPTS AND STYLES
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 8.3.1908
 * @since 8.3.1908
 */
if ( ! function_exists( 'version_8_register_prettyPhoto_scripts' ) ) :
function version_8_register_prettyPhoto_scripts() {

	wp_register_style( 'version_8-prettyPhoto_style', get_template_directory_uri() . '/prettyPhoto.css', NULL , NULL , 'all' );

	//JS (non-AJAX)
	wp_register_script( 'version_8-prettyPhoto_script', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), false, false );

}
add_action( 'init', 'version_8_register_prettyPhoto_scripts' );
endif;
/**
 * ENQUEUE SCRIPTS AND STYLES
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 8.3.1908
 * @since 8.3.1908
 *
 */
if ( ! function_exists( 'version_8_enqueue_prettyPhoto_scripts' ) ) :
function version_8_enqueue_prettyPhoto_scripts() {
	wp_enqueue_style( 'version_8-prettyPhoto_style' );
	wp_enqueue_script('version_8-prettyPhoto_script');
}
add_action( 'wp_enqueue_scripts', 'version_8_enqueue_prettyPhoto_scripts' );
endif;

/**
* prettyPhoto
* put the action in the footer
*
* @link
* @version 8.3.1908
* @since 8.3.1908
*/
if ( ! function_exists( 'prettyPhoto_custom_action' ) ) :
function prettyPhoto_custom_action() {
	if ( !is_admin())
	{
		//class="prettyPhoto" for singles
		//class="prettyGallery" for gallery
	?>
        <script type="text/javascript">
        	//add lightbox
			jQuery(document).ready(function($) {
				$(".prettyPhoto a[href*='.jpg'], .prettyPhoto a[href*='.jpeg'], .prettyPhoto a[href*='.gif'], .prettyPhoto a[href*='.png']").prettyPhoto({
					animationSpeed: 'fast', /* fast/slow/normal */
					padding: 40, /* padding for each side of the picture */
					opacity: 0.35, /* Value betwee 0 and 1 */
					theme: 'pp_default', /* pp_default / light_rounded / dark_rounded / light_square / dark_square / facebook */
					social_tools: false, /*leave blank for default, or add html, or false */
					show_title: true /* true/false */
				});
			})

			//add to gallery
			jQuery(document).ready(function($) {
				$(".prettyGallery a[href*='.jpg'], .prettyGallery a[href*='.jpeg'], .prettyGallery a[href*='.gif'], .prettyGallery a[href*='.png']").attr('rel','prettyPhoto[pp_gal]');
			})
        </script>
    <?php
	}
}
endif; // prettyPhoto_custom_action
add_action( 'wp_footer', 'prettyPhoto_custom_action' );
/***********************
END prettyphoto lightbox
***********************/