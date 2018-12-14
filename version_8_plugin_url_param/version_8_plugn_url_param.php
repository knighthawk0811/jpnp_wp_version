<?php
/*
Plugin Name: Version 8 Plugin: URL Param
Plugin URI: http://neathawk.us
Description: A collection of shortcodes to access/use the URL parameters
Version: 0.2.181214
Author: Joseph Neathawk
Author URI: http://Neathawk.us
License: GNU General Public License v2 or later
*/

class version_8_plugin_url_param {


	/* return parameter value
	 * 
	 */
	private static function get_param($var = null, $default = '<blank value>') 
	{
		if (!isset($var)) 
		{
			return '<b>var attribute required</b>';
		}

		$output = '';
		if(array_key_exists($var, $GLOBALS['wp_query']->query_vars))
		{
			$output = get_query_var($var, $default);
		}
		else
		{
			$output = htmlentities( ( isset($_GET[$var]) ? $_GET[$var] : $default ), ENT_QUOTES, 'UTF-8');
		}
		return $output;
	}

	/* [display-param var="param_name"]
	 *  - returns the value of the URL parameter param_name, or <blank value> if none
	 * 
	 * [display-param var="param_name" default="var was blank"]
	 *  - returns the value of the URL parameter param_name, or "var was blank" if none
	 */
	public static function display_param($atts) 
	{
		$var = '<blank value>';
		if (!isset($atts['var'])) 
		{
			return '<b>display-param requires a var attribute</b>';
		}
		else
		{
			$var = $atts['var'];
		}

		$default = isset($atts['default']) ? $atts['default'] : '<blank value>';

		return version_8_plugin_url_param::get_param($var, $default);
	}

	/* [display-if var="myparam"]
	 * 		This content shows if the parameter is set
	 * [/display-if]
	 *
	 * [display-if var="myparam" value="true"]
	 * 		This content shows if the parameter is set to the value
	 * [/display-if]
	 */
	public static function display_if($atts, $content=null) 
	{
		$var = '<blank value>';
		if (!isset($atts['var'])) 
		{
			return '<b>display-if requires a var attribute</b>';
		}
		else
		{
			$var = version_8_plugin_url_param::get_param($atts['var']);
		}

		if (is_null($content)) 
		{
			return '<b>' + $display_name + ' must have opening and closing tags</b>';
		}

		if (!isset($atts['value']) || $atts['value'] == $var) 
		{
			//return the content if successful
			return do_shortcode($content);
		}
		//return nothing if all else failed
		return '';
	}

	/*
	 * [display-if-not var="myparam"]
	 * 		This content shows if the parameter is NOT set
	 * [/display-if-not]
	 *
	 * [display-if-not var="myparam" value="true"]
	 * 		This content shows if the parameter is NOT set to the value
	 * [/display-if-not]
	 */
	public static function display_if_not($atts, $content=null) 
	{
		$var = '<blank value>';
		if (!isset($atts['var'])) 
		{
			return '<b>display-if-not requires a var attribute</b>';
		}
		else
		{
			$var = version_8_plugin_url_param::get_param($atts['var']);
		}

		if (is_null($content)) 
		{
			return '<b>display-if-not must have opening and closing tags</b>';
		}

		if (!isset($atts['value']) || $atts['value'] == $var) 
		{
			//return empty string if successful
			return '';
		}
		//return content "if not"
		return do_shortcode($content);
	}
}

add_shortcode( 'display-param', Array('version_8_plugin_url_param', 'display_param') );
add_shortcode( 'display-if', Array('version_8_plugin_url_param', 'display_if') );
add_shortcode( 'display-if-not', Array('version_8_plugin_url_param', 'display_if_not') );
